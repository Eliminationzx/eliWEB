<?php

namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Realms;
use Carbon\Carbon;
use Cookie;
use Mail;
use DB;
use Cache;
use DOMDocument;
use App\Launcher_news;
use App\Launcher_videos;
use App\Launcher_changelogs;
use App\Launcher_versions;

class LauncherController extends Controller
{
    public function getlaunchernews() {       
       return Launcher_news::All();
    }
    
    public function getlaunchervideos() {       
       return Launcher_videos::All();
    }
	
	public function getlauncherchangelogs(Request $request) {	
       return empty($request->launcher_version) ? null : Launcher_changelogs::where('version', '=', $request->launcher_version)->first();
    }
	
	public function getlauncherlatestsversion() {       
       return Launcher_versions::latest('id')->first();
    }
}
