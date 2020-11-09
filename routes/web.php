<?php
    Auth::routes();
    
    /* Home */
    Route::get('/', 'Catalog\HomeController@index')->name('home');
	
    /* Admin panel */
    Route::group(['middleware' => ['auth']], function () {

    /*
     *  Home
     */
    Route::get('/personal', 'Admin\PersonalController@index')->name('personal');
    Route::post('/personal/server', 'Admin\PersonalController@setcookie');
    Route::get('/personal/server', 'Admin\PersonalController@setcookie')->name('server');
	Route::post('/personal/switchmodes', 'Admin\PersonalController@switchmodes');
    Route::get('/personal/switchmodes', 'Admin\PersonalController@switchmodes')->name('switchmodes');
    
    /* Try your luck */
    Route::get('/personal/spin', 'Admin\SpinController@index')->name('spin');
	Route::get('/personal/spin/pay', 'Admin\SpinController@payforspin')->name('spin.pay');
	Route::post('/personal/spin/pay', 'Admin\SpinController@payforspin');
	Route::get('/personal/spin/reward', 'Admin\SpinController@reward')->name('spin.reward');
	Route::post('/personal/spin/reward', 'Admin\SpinController@reward');
    
    /*
     *  Account
     */
    Route::get('/personal/donate', 'Admin\DonateController@index')->name('donate');
	Route::post('/personal/donate', 'Admin\DonateController@donatewithpaypal');
	Route::get('/personal/donate/status', 'Admin\DonateController@getDonateStatus')->name('donate.getdonatestatus');
    Route::get('/personal/votes', 'Admin\VotesController@index')->name('votes');
    Route::post('/personal/updateavatar', 'Admin\AccountsController@updateavatar');
    Route::post('/personal/passwords', 'Admin\AccountsController@updatepasswords');
	Route::get('/personal/updateavatar', 'Admin\AccountsController@updateavatar')->name('accounts.avatar.update');
    Route::get('/personal/passwords', 'Admin\AccountsController@passwords')->name('accounts.passwords');
    Route::get('/personal/activity', 'Admin\AccountsController@activity')->name('accounts.activity');
    
    /*
     * Promo codes
     *
     */
    Route::post('/personal/promocodes', 'Admin\PromocodesController@usepromocode');
    Route::get('/personal/promocodes', 'Admin\PromocodesController@index')->name('promocodes');
    
    /*
     *  Character
     */
    Route::get('/personal/characters/race', 'Admin\CharactersController@race')->name('characters.race');
    Route::post('/personal/characters/race', 'Admin\CharactersController@changerace');
    Route::get('/personal/characters/faction', 'Admin\CharactersController@faction')->name('characters.faction');
    Route::post('/personal/characters/faction', 'Admin\CharactersController@changefaction');
    Route::get('/personal/characters/name', 'Admin\CharactersController@name')->name('characters.name');
    Route::post('/personal/characters/name', 'Admin\CharactersController@changename');
    Route::get('/personal/characters/repair', 'Admin\CharactersController@repair')->name('characters.repair');
    Route::post('/personal/characters/repair', 'Admin\CharactersController@dorepair');
    Route::get('/personal/characters/restore', 'Admin\CharactersController@restore')->name('characters.restore');
    Route::post('/personal/characters/restore', 'Admin\CharactersController@dorestore');

    /*
     *  Premium status
     */
    Route::get('/personal/premium', 'Admin\PremiumController@index')->name('premium');
    Route::post('/personal/premium', 'Admin\PremiumController@paypremium');
    Route::get('/personal/premium/senditem', 'Admin\PremiumController@sendpremiumitem')->name('premium.senditem');
    Route::post('/personal/premium/senditem', 'Admin\PremiumController@sendpremiumitem');

    /*
     *  Shop
     */
    Route::get('/personal/shop', 'Admin\AdminShopController@index')->name('shop');
    Route::get('/personal/shop/{category}/{realmid?}', 'Admin\AdminShopController@showcategory')->name('shop.showcategory');
    Route::post('/personal/shop/search', 'Admin\AdminShopController@search');
    Route::get('/personal/shop/search', 'Admin\AdminShopController@search')->name('shop.search');
    Route::post('/personal/shop/formpayment', 'Admin\AdminShopController@formpayment');
    Route::get('/personal/shop/formpayment', 'Admin\AdminShopController@formpayment')->name('shop.formpayment');
	Route::post('/personal/shop/payments', 'Admin\AdminShopController@payments');
    Route::get('/personal/shop/payments', 'Admin\AdminShopController@payments')->name('shop.payments');
    Route::get('/personal/admin/system/shop/formcreate', 'Admin\AdminShopController@formcreateshop')->name('admin.shop.formcreate');
    Route::get('/personal/admin/system/shop/formupdate', 'Admin\AdminShopController@formupdateshop')->name('admin.shop.formupdate');
	Route::get('/personal/admin/system/shop/delete', 'Admin\AdminShopController@deleteshop')->name('admin.shop.delete');
	Route::get('/personal/admin/system/shop/update', 'Admin\AdminShopController@updateshop')->name('admin.shop.update');
    Route::get('/personal/admin/system/shop/create', 'Admin\AdminShopController@createshop')->name('admin.shop.create');
	Route::post('/personal/admin/system/shop/formcreate', 'Admin\AdminShopController@formcreateshop');
    Route::post('/personal/admin/system/shop/formupdate', 'Admin\AdminShopController@formupdateshop');
    Route::post('/personal/admin/system/shop/update', 'Admin\AdminShopController@updateshop');
    Route::post('/personal/admin/system/shop/create', 'Admin\AdminShopController@createshop');
	Route::post('/personal/admin/system/shop/delete', 'Admin\AdminShopController@deleteshop');

    /*
     *  Currency
     */
    Route::get('/personal/currency/gold', 'Admin\CurrencyController@gold')->name('currency.gold');
    Route::post('/personal/currency/gold', 'Admin\CurrencyController@buygold');
    //Route::get('/personal/currency/ether', 'Admin\CurrencyController@ether')->name('currency.ether');
    Route::post('/personal/currency/ether', 'Admin\CurrencyController@buyether');

    /*
    *  Admin->Referals
    */
    Route::get('/personal/referals', 'Admin\ReferalsController@index')->name('referals');
    
    /*
     *  Admin->System->Users
     */
    Route::get('/personal/admin/system/users', 'Admin\AdminUsersController@getallusers')->name('admin.users');
    Route::get('/personal/admin/system/users/{id?}', 'Admin\AdminUsersController@formupdateusers')->name('admin.users.id');
    Route::post('/personal/admin/system/updateusers', 'Admin\AdminUsersController@updateusers');
    Route::post('/personal/admin/system/deleteusers', 'Admin\AdminUsersController@deleteusers');
    Route::get('/personal/admin/system/updateusers', 'Admin\AdminUsersController@updateusers')->name('admin.users.update');
    Route::get('/personal/admin/system/deleteusers', 'Admin\AdminUsersController@deleteusers')->name('admin.users.delete');
	Route::post('/personal/admin/system/users/search', 'Admin\AdminUsersController@search');
    Route::get('/personal/admin/system/users/search', 'Admin\AdminUsersController@search')->name('admin.users.search');
    
    /*
     *  Admin->System->Users->Roles
     */
    Route::get('/personal/admin/system/roles', 'Admin\AdminRolesController@getallroles')->name('admin.roles');
    Route::get('/personal/admin/system/createroles', 'Admin\AdminRolesController@formcreateroles')->name('admin.roles.create');
    Route::post('/personal/admin/system/createroles', 'Admin\AdminRolesController@createroles');
    Route::get('/personal/admin/system/roles/{id}', 'Admin\AdminRolesController@formupdateroles')->name('admin.roles.id');
    Route::post('/personal/admin/system/updateroles', 'Admin\AdminRolesController@updateroles');
    Route::post('/personal/admin/system/deleteroles', 'Admin\AdminRolesController@deleteroles');
    Route::get('/personal/admin/system/updateroles', 'Admin\AdminRolesController@updateroles')->name('admin.roles.update');
    Route::get('/personal/admin/system/deleteroles', 'Admin\AdminRolesController@deleteroles')->name('admin.roles.delete');

    /*
     *  Admin->System->Users->Privileges
     */
    Route::get('/personal/admin/system/permissions', 'Admin\AdminPermissionsController@getallpermissions')->name('admin.permissions');
    Route::get('/personal/admin/system/createpermissions', 'Admin\AdminPermissionsController@formcreatepermissions')->name('admin.permissions.create');
    Route::post('/personal/admin/system/createpermissions', 'Admin\AdminPermissionsController@createpermissions');
    Route::get('/personal/admin/system/permissions/{id}', 'Admin\AdminPermissionsController@formupdatepermissions')->name('admin.permissions.id');
    Route::post('/personal/admin/system/updatepermissions', 'Admin\AdminPermissionsController@updatepermissions');
    Route::post('/personal/admin/system/deletepermissions', 'Admin\AdminPermissionsController@deletepermissions');
    Route::get('/personal/admin/system/updatepermissions', 'Admin\AdminPermissionsController@updatepermissions')->name('admin.permissions.update');
    Route::get('/personal/admin/system/deletepermissions', 'Admin\AdminPermissionsController@deletepermissions')->name('admin.permissions.delete');
    
    /*
     *  Admin->System->Backups
     */
    Route::get('/personal/admin/system/backups', 'Admin\AdminBackupsController@getallbackups')->name('admin.backups');
    Route::get('/personal/admin/system/backups/{file}', 'Admin\AdminBackupsController@downloadbackups')->name('admin.backups.file');
    Route::post('/personal/admin/system/deletebackups', 'Admin\AdminBackupsController@deletebackups');
    Route::post('/personal/admin/system/createbackups', 'Admin\AdminBackupsController@createbackups');
    Route::get('/personal/admin/system/deletebackups', 'Admin\AdminBackupsController@deletebackups')->name('admin.backups.delete');
    Route::get('/personal/admin/system/createbackups', 'Admin\AdminBackupsController@createbackups')->name('admin.backups.create');

    /*
    *  Admin->System->Settings
    */
    Route::get('/personal/admin/system/settings', 'Admin\AdminSettingsController@getallsettings')->name('admin.settings');
    Route::post('/personal/admin/system/settings', 'Admin\AdminSettingsController@updatesettings');   
    
    /*
    *  Admin->System->Shop categories
    */
    Route::get('/personal/admin/system/shop/categories', 'Admin\AdminShopCategoriesController@getallshopcategories')->name('admin.shopcategories');
    Route::get('/personal/admin/system/shop/createcategories', 'Admin\AdminShopCategoriesController@formcreateshopcategories')->name('admin.shopcategories.create');
    Route::post('/personal/admin/system/shop/createcategories', 'Admin\AdminShopCategoriesController@createshopcategories');
    Route::get('/personal/admin/system/shop/categories/{id}', 'Admin\AdminShopCategoriesController@formupdateshopcategories')->name('admin.shopcategories.id');
    Route::post('/personal/admin/system/shop/updatecategories', 'Admin\AdminShopCategoriesController@updateshopcategories');
    Route::post('/personal/admin/system/shop/deletecategories', 'Admin\AdminShopCategoriesController@deleteshopcategories');
    Route::get('/personal/admin/system/shop/updatecategories', 'Admin\AdminShopCategoriesController@updateshopcategories')->name('admin.shopcategories.update');
    Route::get('/personal/admin/system/shop/deletecategories', 'Admin\AdminShopCategoriesController@deleteshopcategories')->name('admin.shopcategories.delete'); 

    /*
     * Admin->System->Promo codes
     */
    Route::get('/personal/admin/system/promocodes', 'Admin\AdminPromocodesController@getallpromocodes')->name('admin.promocodes');
    Route::get('/personal/admin/system/createpromocodes', 'Admin\AdminPromocodesController@formcreatepromocodes')->name('admin.promocodes.create');
    Route::post('/personal/admin/system/createpromocodes', 'Admin\AdminPromocodesController@createpromocodes');
    Route::get('/personal/admin/system/promocodes/{id}', 'Admin\AdminPromocodesController@formupdatepromocodes')->name('admin.promocodes.id');
    Route::post('/personal/admin/system/updatepromocodes', 'Admin\AdminPromocodesController@updatepromocodes');
    Route::post('/personal/admin/system/deletepromocodes', 'Admin\AdminPromocodesController@deletepromocodes');
    Route::get('/personal/admin/system/updatepromocodes', 'Admin\AdminPromocodesController@updatepromocodes')->name('admin.promocodes.update');
    Route::get('/personal/admin/system/deletepromocodes', 'Admin\AdminPromocodesController@deletepromocodes')->name('admin.promocodes.delete'); 

    /*
     * Admin->System->Voting
     */
    Route::get('/personal/admin/system/votes', 'Admin\AdminVotesController@getallvotes')->name('admin.votes');
    Route::get('/personal/admin/system/createvotes', 'Admin\AdminVotesController@formcreatevotes')->name('admin.votes.create');
    Route::post('/personal/admin/system/createvotes', 'Admin\AdminVotesController@createvotes');
    Route::get('/personal/admin/system/votes/{id}', 'Admin\AdminVotesController@formupdatevotes')->name('admin.votes.id');
    Route::post('/personal/admin/system/updatevotes', 'Admin\AdminVotesController@updatevotes');
    Route::post('/personal/admin/system/deletevotes', 'Admin\AdminVotesController@deletevotes');
    Route::get('/personal/admin/system/updatevotes', 'Admin\AdminVotesController@updatevotes')->name('admin.votes.update');
    Route::get('/personal/admin/system/deletevotes', 'Admin\AdminVotesController@deletevotes')->name('admin.votes.delete'); 
	
	/*
     * Admin->Launcher
     */	
	Route::get('/personal/admin/system/launcher/news', 'Admin\AdminLauncherController@getallnews')->name('admin.launcher.news');
    Route::get('/personal/admin/system/launcher/createnews', 'Admin\AdminLauncherController@formcreatenews')->name('admin.launcher.news.create');
    Route::post('/personal/admin/system/launcher/createnews', 'Admin\AdminLauncherController@createnews');
    Route::get('/personal/admin/system/launcher/news/{id}', 'Admin\AdminLauncherController@formupdatenews')->name('admin.launcher.news.id');
    Route::post('/personal/admin/system/launcher/updatenews', 'Admin\AdminLauncherController@updatenews');
    Route::post('/personal/admin/system/launcher/deletenews', 'Admin\AdminLauncherController@deletenews');
    Route::get('/personal/admin/system/launcher/updatenews', 'Admin\AdminLauncherController@updatenews')->name('admin.launcher.news.update');
    Route::get('/personal/admin/system/launcher/deletenews', 'Admin\AdminLauncherController@deletenews')->name('admin.launcher.news.delete'); 	
	Route::get('/personal/admin/system/launcher/videos', 'Admin\AdminLauncherController@getallvideos')->name('admin.launcher.videos');
    Route::get('/personal/admin/system/launcher/createvideos', 'Admin\AdminLauncherController@formcreatevideos')->name('admin.launcher.videos.create');
    Route::post('/personal/admin/system/launcher/createvideos', 'Admin\AdminLauncherController@createvideos');
    Route::get('/personal/admin/system/launcher/videos/{id}', 'Admin\AdminLauncherController@formupdatevideos')->name('admin.launcher.videos.id');
    Route::post('/personal/admin/system/launcher/updatevideos', 'Admin\AdminLauncherController@updatevideos');
    Route::post('/personal/admin/system/launcher/deletevideos', 'Admin\AdminLauncherController@deletevideos');
    Route::get('/personal/admin/system/launcher/updatevideos', 'Admin\AdminLauncherController@updatevideos')->name('admin.launcher.videos.update');
    Route::get('/personal/admin/system/launcher/deletevideos', 'Admin\AdminLauncherController@deletevideos')->name('admin.launcher.videos.delete');
    });


/* SitemapGenerate */
Route::get('sitemap', function () {

    // create new sitemap object
    $sitemap = App::make('sitemap');
    $sitemap->add(URL::to('/'), '2016-11-18T12:30:00+02:00', '1.0');
    $pages = DB::table('pages')->orderBy('updated_at', 'asc')->get();
    foreach ($pages as $page) {
        $sitemap->add(config('app.url') . $page->seo_url,
          $page->updated_at, '0.8');
    }
    return $sitemap->store('xml', 'sitemap');
});
