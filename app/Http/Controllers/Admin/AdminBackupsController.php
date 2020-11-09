<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Response;
use Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBackupsController extends Controller
{
    public function getallbackups() {
        $data = Auth::user();
        if ($data->can('view-backups') === false) {
            abort(403);
        }
        $dir = storage_path('app/'.config('app.name'));
		if(!file_exists($dir)){
            mkdir($dir, 0775);
        }
		
        $backups = scandir($dir);
        unset($backups[0], $backups[1]);
		
        return view('admin.system.backup.getallbackup',compact(['backups', 'data']));
    }

    public function createbackups(Request $request) {
        $data = $request->user();
        if ($data->can('create-backups') === false) {
            abort(403);
        }
        Artisan::call('backup:run');
    }

    public function downloadbackups($file) {
        $data = Auth::user();
        if ($data->can('downloads-backups') === false) {
            abort(403);
        }
        $backup= storage_path('app/'.config('app.name').'/') . $file;
        $headers = array(
          'Content-Type: application/zip',
        );

        return Response::download($backup, $file, $headers);
    }

    public function deletebackups(Request $request) {
        $data = $request->user();
        if ($data->can('delete-backups') === false) {
            abort(403);
        }
        $DeleteBackup = storage_path('app/'.config('app.name').'/') . $request->element_id;
        unlink($DeleteBackup);
    }
}
