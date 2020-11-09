<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Vote;
use App\Vote_log;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VotesController extends Controller
{
    public function index(){
        $data = Auth::user();
        $votes = Vote::all();
        
        foreach ($votes as &$vote)
        {
            if ($vote->clickable_only == 1)
                $vote->url = route('votes.callback').'/'.$vote->id.'?'.'player_name=';
            
            $vote->url .= $data->name;
            $vote->{'isvoted'} = $this->isplayerrewardedtoday($vote->id, $data->name) ? 1 : 0;
        }
        
        $logs = Vote_log::orderBy('created_at', 'DESC')->take(10)->get();
		foreach ($logs as &$log) {
			$log->{ 'vote_name'} = $votes->find($log->voteid)->name;
		}
		
        $topusers = User::where('vote', '>', 0)->orderBy('vote', 'DESC')->take(5)->get();
		
        return view('admin.account.vote', ['data' => $data, 'topusers' => $topusers, 'votes' => $votes, 'logs' => $logs]);
    }
	
	public function callback(Request $request, $voteid = 0)
	{               
        $data = null;
        $vote = Vote::find($voteid);
        if ($vote == null)
            return Redirect::back();
             
        if ($vote->clickable_only == 1)
        {
            $fields = explode(",", $vote->inputs); 
            foreach ($fields as $field)
                $data[$field] = $request->input($field);
                    
            $this->rewardplayer($vote, $data);	
            return Redirect::to($vote->url);
        }
        else
        {
            switch ($vote->name)
            {
                case "Gtop100":
                {
                    $data['player_name'] = $request->input('pingUsername');
                    $data['ip'] = $request->input('VoterIP');
                    break;
                }
                case "Top100Arena":
                {
                    $data['player_name'] = $request->input('postback');
                    break;
                }
                case "TopG":
                {
                    $data['player_name'] = $request->input('p_resp');
                    $data['ip'] = $request->input('ip');
                    break;
                }
                case "Arena-top100":
                {
                    $data['player_name'] = $request->input('userid');
                    $data['ip'] = $request->input('userip');
                    break;
                }
                case "Xtremetop100":
                {
                    $data['player_name'] = $request->input('custom');
                    break;
                }
                default:
                    break;
            }
        
            if ($request->ip() == gethostbyname ($vote->hostname))
                $this->rewardplayer($vote, $data);	
        }
	}
        
    public function synclogs(Request $request) {        
        $oauth_token =  $request->input('oauth_token');
         
        if ($oauth_token != env('OAUTH_SYNCVOTE_TOKEN')) {
             abort(403);
         }
         
        $votes = Vote::where('active', 1)->get();
                  
        foreach ($votes as $vote) {        
            $log_urls = [ $vote->log_url1, $vote->log_url2, $vote->log_url3, $vote->log_url4, $vote->log_url5];
            $logs = null;  
             
            foreach($log_urls as $log_url) {                                          
                 $log = @file_get_contents($log_url);
                 if (empty($log))
                     continue;
                 
                 if ($logs == null)
                     $logs = $log;
                 else                        
                     $logs .= $log;                     
            }
                                              
            $fields = explode(",", $vote->inputs); 
            if (empty($fields))
                continue;
            
            $rows = explode("\n", $logs);                
            foreach($rows as $row => $data) {   
                $row_data = preg_split('/\s+/', $data, -1, PREG_SPLIT_NO_EMPTY);
                if (empty($row_data))
                    continue;

                $this->rewardplayer($vote, array_combine($fields, $row_data));                             
            }  
		}
	}
    
    public function appendlog($voteid, $data) {
        $log = new Vote_log;
        $log->player_name = $data['player_name'];
        $log->vote_time = $data['vote_time'];
        $log->vote_count = $data['vote_count'];
        $log->ip = $data['ip'];
        $log->voteid = $voteid;
        $log->save();
    }
    
    public function rewardplayer($vote, $data) {
        // skip unknown user names
        $user = User::where('name', $data['player_name'])->first();
        if ($user == null)
            return;
        
        if ($this->isplayerrewardedtoday($vote->id, $user->name))
            return;
        
        if (!array_key_exists('vote_count', $data) || is_null($data['vote_count']))
            $data['vote_count'] = 1;
        
        if (!array_key_exists('vote_time', $data) || is_null($data['vote_time']))
            $data['vote_time'] = Carbon::now()->toDateTimeString();
        
        if (!array_key_exists('ip', $data) || is_null($data['ip']))
            $data['ip'] = \Request::ip();
            
        $reward_calc = $this->istopuser($user->id) && $vote->clickable_only == 0 ? ($vote->reward * $data['vote_count']) * 2 : ($vote->reward * $data['vote_count']);
        $user->donate = $user->donate + $reward_calc;
        $user->vote = $user->vote + $data['vote_count'];
        $user->save();
        
        $history['userid'] = $user->id;
        $history['comment'] = 'Charge '.$reward_calc.' donation points for voting on '.$vote->name;
        $history['type'] = 'rewards';
        $history['ip'] = $data['ip'];
        $this->sethistory($history); 

        $this->appendlog($vote->id, $data);
    }
    
    public function istopuser($userid) {
		$topusers = User::orderBy('vote', 'DESC')->take(5)->get();
        return $topusers->contains('id', $userid);
    }
    
    public function isplayerrewardedtoday($voteid, $player_name) {
        return Vote_log::where([
                  ['voteid', '=', $voteid],
                  ['player_name', '=', $player_name],
                  ['created_at', '>=', Carbon::today()]
                ])->count() > 0;
    }
}
