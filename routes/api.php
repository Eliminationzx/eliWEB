<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/* Server stats info */
Route::get('serverinfo/{server?}', 'Catalog\GameStatisticsController@getserverinfo')->name('serverinfo');
Route::get('serverinfos', 'Catalog\GameStatisticsController@getserverinfos')->name('serverinfos');   

/* Launcher API */
Route::get('launcher/news', 'Catalog\LauncherController@getlaunchernews')->name('launcher.news');
Route::get('launcher/videos', 'Catalog\LauncherController@getlaunchervideos')->name('launcher.videos');
Route::get('launcher/version', 'Catalog\LauncherController@getlauncherlatestsversion')->name('launcher.latestsversion');
Route::get('launcher/changelogs', 'Catalog\LauncherController@getlauncherchangelogs')->name('launcher.changelogs');

/* Sync voting logs */
Route::get('votes/sync-logs', 'Admin\VotesController@synclogs')->name('votes.synclogs'); 
Route::post('votes/sync-logs', 'Admin\VotesController@synclogs');  
Route::get('votes/callback/{voteid?}', 'Admin\VotesController@callback')->name('votes.callback'); 
Route::post('votes/callback/{voteid?}', 'Admin\VotesController@callback'); 

/* Shop random discount */
Route::get('shop/rnd-discount', 'Admin\AdminShopController@updaterandomdiscount')->name('shop.rnddiscount'); 
Route::post('shop/rnd-discount', 'Admin\AdminShopController@updaterandomdiscount'); 

/* Auto cleanup history of activity */
Route::get('account/cleanup-activities', 'Admin\AccountsController@cleanupactivities')->name('accounts.activity.cleanup'); 
Route::post('account/cleanup-activities', 'Admin\AccountsController@cleanupactivities'); 
