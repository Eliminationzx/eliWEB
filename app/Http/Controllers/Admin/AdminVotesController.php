<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Vote;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminVotesController extends Controller
{
    public function getallvotes() {
        $data = Auth::user();
        if ($data->can('view-votes') === false) {
            abort(403);
        }
        $votes = Vote::orderBy('id', 'desc')->paginate(10);
        return view('admin.system.votes.getallvotes',compact(['votes','data']));
    }
	
	public function formcreatevotes() {
        $data = Auth::user();
        if ($data->can('create-votes') === false) {
            abort(403);
        }

        return view('admin.system.votes.formcreatevotes',compact(['data']));
    }

    public function createvotes(Request $request) {
        $data = $request->user();
        if ($data->can('create-votes') === false) {
            abort(403);
        }
        					
        $vote = new Vote();
		for($i = 1; $i <= 5; $i++) {
			$vote['log_url'.$i] = $request['vote_log'.$i];
		}
		
		$vote->url = $request->vote_url;
		if ($request->hasFile('vote_img')) {
            
            $this->validate($request, [
            'vote_img' => 'mimes:jpeg,gif,png,bmp,tiff',
            ],
                $messages = [
                    'mimes' => 'Only jpeg,gif, png, bmp,tiff are allowed.'
                ]
            );
                      
            $vote_img = $request->file('vote_img');
            $filename = md5(microtime()).'.'.$vote_img->getClientOriginalExtension();
			$vote_img->move(storage_path('app/public/uploads/tops'), $filename);     
			$vote->img = url('storage/uploads/tops/'.$filename);
		}
        $vote->hostname = $request->hostname;        
        $vote->name = $request->vote_name;
		$vote->descr = $request->vote_descr;
		$vote->reward = $request->vote_reward;
        $vote->inputs = $request->inputs;
        $vote->status = $request->status === null ? 0 : 1;
        $vote->clickable_only = $request->clickable_only === null ? 0 : 1;
        $vote->save();

        return redirect()->route('admin.votes')->with('status', 'The voting top has been successfully created!');
    }

    public function formupdatevotes($id) {
        $data = Auth::user();
        if ($data->can('update-votes') === false) {
            abort(403);
        }

		$vote = Vote::find($id);
		if (empty($vote))
			return redirect()->route('admin.votesl');
		
        return view('admin.system.votes.formupdatevotes',compact(['vote', 'data']));
    }

    public function updatevotes(Request $request) {
        $data = $request->user();
        if ($data->can('update-votes') === false) {
            abort(403);
        }
		
        $id = $request->vote_id;		
        $vote = Vote::find($id);
		if (empty($vote))
			return redirect()->route('admin.votesl');
		
		for($i = 1; $i <= 5; $i++) {
			$vote['log_url'.$i] = $request['vote_log'.$i];
		}
		$vote->url = $request->vote_url;
		if ($request->hasFile('vote_img')) {
            
            $this->validate($request, [
            'vote_img' => 'mimes:jpeg,gif,png,bmp,tiff',
            ],
                $messages = [
                    'mimes' => 'Only jpeg,gif, png, bmp,tiff are allowed.'
                ]
            );
                      
            $vote_img = $request->file('vote_img');
            $filename = md5(microtime()).'.'.$vote_img->getClientOriginalExtension();
			$vote_img->move(storage_path('app/public/uploads/tops'), $filename);     
			$vote->img = url('storage/uploads/tops/'.$filename);
		}
        $vote->hostname = $request->hostname;
        $vote->name = $request->vote_name;
		$vote->descr = $request->vote_descr;
		$vote->reward = $request->vote_reward;
        $vote->inputs = $request->inputs;
        $vote->status = $request->status === null ? 0 : 1;
        $vote->clickable_only = $request->clickable_only === null ? 0 : 1;
        $vote->save();

        return redirect()->route('admin.votes')->with('status', 'The voting top has been successfully edited!');
    }

    public function deletevotes (Request $request){
        $data = $request->user();
        if ($data->can('delete-votes') === false) {
            abort(403);
        }
        $id = $request->element_id;
        Vote::find($id)->delete();
    }
}