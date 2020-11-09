<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Launcher_videos;
use App\Launcher_news;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class AdminLauncherController extends Controller
{
    public function getallnews() {
        $data = Auth::user();
        if ($data->can('view-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $news_list = Launcher_news::where('server', $server)->orderBy("id", 'desc')->paginate(10);      
        return view('admin.system.launcher.getallnews',compact(['news_list', 'data']));
    }

    public function formcreatenews() {
        $data = Auth::user();
        if ($data->can('create-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');

        return view('admin.system.launcher.formcreatenews',compact(['data']));
    }

    public function createnews(Request $request) {
        $data = $request->user();
        if ($data->can('create-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $title = $request->input('title');
        $body = $request->input('body');
           
        if (!$this->servervalidation($server))
            return redirect()->route('personal');

        $news = new Launcher_news();
        $news->server = $server;
        $news->title = $title;
        $news->body = $body;
		
		if ($request->hasFile('thumbnail_source')) {
            
            $this->validate($request, [
            'thumbnail_source' => 'mimes:jpeg,gif,png,bmp,tiff',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only jpeg,gif, png, bmp,tiff are allowed.'
                ]
            );
                      
            $thumbnail_source = $request->file('thumbnail_source');
            $filename = md5(microtime()).'.'.$thumbnail_source->getClientOriginalExtension();
			$thumbnail_source->move(storage_path('app/public/uploads/thumbnails'), $filename);     
			$news->thumbnail_url = url('storage/app/public/uploads/thumbnails/'.$filename);
		}
        $news->save();

        return redirect()->route('admin.launcher.news')->with('status', 'The news is successfully created!');
    }

    public function formupdatenews($id) {
        $data = Auth::user();
        if ($data->can('update-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $news = Launcher_news::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        return view('admin.system.launcher.formupdatenews',compact(['news', 'data']));
    }

    public function updatenews(Request $request) {
        $data = $request->user();
        if ($data->can('update-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $title = $request->input('title');
        $body = $request->input('body');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->input('newsid');
        $news = Launcher_news::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
				
	    if (empty($news))
			return redirect()->route('admin.launcher.news');
                
        $news->title = $title;
        $news->body = $body;
		if ($request->hasFile('thumbnail_source')) {
            
            $this->validate($request, [
            'thumbnail_source' => 'mimes:jpeg,gif,png,bmp,tiff',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only jpeg,gif, png, bmp,tiff are allowed.'
                ]
            );
                      
            $thumbnail_source = $request->file('thumbnail_source');
            $filename = md5(microtime()).'.'.$thumbnail_source->getClientOriginalExtension();
			$thumbnail_source->move(storage_path('app/public/uploads/thumbnails'), $filename);     
			$news->thumbnail_url = url('storage/app/public/uploads/thumbnails/'.$filename);
		}
        $news->save();

        return redirect()->route('admin.launcher.news')->with('status', 'The news has been successfully updated!');
    }

    public function deletenews(Request $request){
        $data = $request->user();
        if ($data->can('delete-launcher-news') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->element_id;
        $news = Launcher_news::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        $news->delete();
    }
	
	public function getallvideos() {
        $data = Auth::user();
        if ($data->can('view-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $videos = Launcher_videos::where('server', $server)->orderBy("id", 'desc')->paginate(10);      
        return view('admin.system.launcher.getallvideos',compact(['videos', 'data']));
    }

    public function formcreatevideos() {
        $data = Auth::user();
        if ($data->can('create-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');

        return view('admin.system.launcher.formcreatevideos',compact(['data']));
    }

    public function createvideos(Request $request) {
        $data = $request->user();
        if ($data->can('create-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $name = $request->input('name');
        $description = $request->input('description');
           
        if (!$this->servervalidation($server))
            return redirect()->route('personal');

        $video = new Launcher_videos();
        $video->server = $server;
        $video->name = $name;
        $video->description = $description;
		
		if ($request->hasFile('video_source')) {
            
             $this->validate($request, [
            'video_source' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts are allowed.'
                ]
            );
                      
            $video_source = $request->file('video_source');
            $filename = md5(microtime()).'.'. $video_source->getClientOriginalExtension();
            $video_source->move(public_path('admin/videos'), $filename);
			$video->source_url = url('admin/videos/'.$filename);
		}
		
        $video->save();

        return redirect()->route('admin.launcher.videos')->with('status', 'Video was successfully created!');
    }

    public function formupdatevideos($id) {
        $data = Auth::user();
        if ($data->can('update-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $video = Launcher_videos::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
				
        return view('admin.system.launcher.formupdatevideos',compact(['video', 'data']));
    }

    public function updatevideos(Request $request) {
        $data = $request->user();
        if ($data->can('update-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        $name = $request->input('name');
        $description = $request->input('description');
           
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->input('videosid');
        $video = Launcher_videos::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
				
	    if (empty($video))
			return redirect()->route('admin.launcher.videos');
                
        $video->server = $server;
        $video->name = $name;
        $video->description = $description;
		
		if ($request->hasFile('video_source')) {
            
            $this->validate($request, [
            'video_source' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040',
            ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                    'mimes' => 'Only mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts are allowed.'
                ]
            );
                      
            $video_source = $request->file('video_source');
            $filename = md5(microtime()).'.'.$video_source->getClientOriginalExtension();
            $video_source->move(public_path('admin/videos'), $filename);
			$video->source_url = url('admin/videos/'.$filename);
		}
		
        $video->save();

        return redirect()->route('admin.launcher.videos')->with('status', 'Video updated successfully!');
    }

    public function deletevideos(Request $request){
        $data = $request->user();
        if ($data->can('delete-launcher-videos') === false) {
            abort(403);
        }
        
        $server = Cookie::get('server');
        
        if (!$this->servervalidation($server))
            return redirect()->route('personal');
        
        $id = $request->element_id;
        $video = Launcher_videos::where([
                  ['id', '=', $id],
                  ['server', '=', $server],
                ])->first();
        $video->delete();
    }
}
