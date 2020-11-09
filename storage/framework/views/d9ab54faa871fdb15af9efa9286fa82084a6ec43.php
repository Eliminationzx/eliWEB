<?php if(!Auth::guest()): ?>
    <?php if(!in_array(Cookie::get('server'), explode(',', env('APP_GAME_SERVER_LIST')))): ?>
        <div class="modal inmodal show" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content animated flipInX">
                    <div class="modal-header">
                        <h4 class="modal-title">SELECT A GAME SERVER</h4>
                        <small class="font-bold">To continue working in your personal cabinet, you must select the server.</small>
                    </div>

                    <div class="modal-footer">
                        <?php $__currentLoopData = explode(',', env('APP_GAME_SERVER_LIST')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form method="POST" action="<?php echo e(route('server')); ?>"
                              class="form-horizontal" enctype="multipart/form-data">

                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="server" value="<?php echo e($server); ?>">
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-block btn-outline btn-primary"><?php echo e(strtoupper($server)); ?></button>
                            </div>                   
                        </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<div class="modal inmodal" id="changecurrentservernmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title">SELECT A GAME SERVER</h4>
				<small class="font-bold">To continue working in your personal cabinet you must select a server.</small>
            </div>

            <div class="modal-footer">
						<?php $__currentLoopData = explode(',', env('APP_GAME_SERVER_LIST')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $server): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<form method="POST" action="<?php echo e(route('server')); ?>"
							  class="form-horizontal" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
							<input type="hidden" name="server" value="<?php echo e($server); ?>">
								<div class="col-sm-3">
									<button type="submit" class="btn btn-block btn-outline btn-primary"><?php echo e(strtoupper($server)); ?></button>
								</div>              					
						</form>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="profile-element profile-element-avatar">
							<input title="Upload image" type="image" id="upload_avatar" onclick="document.getElementById('user_avatar').click();" style="width: 170px; height: 170px;" class="img-circle" src="<?php echo e(URL::asset('storage/app/public/uploads/avatars/'.$data['avatar'])); ?>">
							<form enctype="multipart/form-data" action="<?php echo e(route('accounts.avatar.update')); ?>" method="POST">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                <input type="file" name="avatar" id="user_avatar" onchange="this.form.submit();" style="display: none;" />
                            </form>
                        </div>                    
                        <div class="logo-element">
                            <?php echo e(config('app.name_short')); ?><i class="fa fa-plus"></i>
                        </div>
                    </li>
                    <li class="<?php echo e((Route::currentRouteName() == 'home') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('personal')); ?>"><i class="fa fa-home"></i> <span class="nav-label">Home
                        </span> </a>
                    </li>
                    <li class="<?php echo e((Route::currentRouteName() == 'donate' or 
                               Route::currentRouteName() == 'accounts.passwords' or 
                               Route::currentRouteName() == 'accounts.activity' or
                               Route::currentRouteName() == 'votes') ? 'active' : null); ?>">
                        <a href="#"><i class="fa fa-cog"></i>
                            <span class="nav-label">Account</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">

                            <li class="<?php echo e((Route::currentRouteName() == 'donate') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('donate')); ?>">Donation</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'votes') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('votes')); ?>">Voting</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'accounts.passwords') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('accounts.passwords')); ?>">Password change</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'accounts.activity') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('accounts.activity')); ?>">History of activity</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo e((Route::currentRouteName() == 'promocodes') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('promocodes')); ?>"><i class="fa fa-smile-o"></i> <span class="nav-label">Promo Codes</span>  </a>
                    </li>
                    <li class="<?php echo e((Route::currentRouteName() == 'premium') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('premium')); ?>"><i class="fa fa-star"></i> <span class="nav-label">Premium status</span>  </a>
                    </li>
                    <?php if(Cookie::get('server') != 'vanilla'): ?>
                    <li class="<?php echo e((Route::currentRouteName() == 'characters.race' or 
								Route::currentRouteName() == 'characters.name' or 
								Route::currentRouteName() == 'characters.repair' or 
								Route::currentRouteName() == 'characters.faction') ? 'active' : null); ?>">
                        <a href="#"><i class="fa fa-users"></i>
                            <span class="nav-label">Character</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                                <li class="<?php echo e((Route::currentRouteName() == 'characters.race') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('characters.race')); ?>">Change race</a>
                                </li>

                                <li class="<?php echo e((Route::currentRouteName() == 'characters.name') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('characters.name')); ?>">Change name</a>
                                </li>

                                <li class="<?php echo e((Route::currentRouteName() == 'characters.faction') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('characters.faction')); ?>">Change fraction</a>
                                </li>
                                <li class="<?php echo e((Route::currentRouteName() == 'characters.repair') ? 'active' : null); ?>">
                                    <a href="<?php echo e(route('characters.repair')); ?>">Repair</a>
                                </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                    <li class="<?php echo e((Route::currentRouteName() == 'shop' or Route::currentRouteName() == 'shop.showcategory' ) ? 'active' : null); ?>">
                        <a href="<?php echo e(route('shop')); ?>"><i class="fa fa-shopping-bag"></i> <span class="nav-label">Shop</span>  </a>
                    </li>    
                    
                    <li class="<?php echo e(Route::currentRouteName() == 'currency.gold' ? 'active' : null); ?>">
                        <a href="#"><i class="fa fa-dollar"></i>
                            <span class="nav-label">Game currency</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">

                            <li class="<?php echo e((Route::currentRouteName() == 'gold') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('currency.gold')); ?>">Gold</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php echo e((Route::currentRouteName() == 'referals') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('referals')); ?>"><i class="fa fa-user-plus"></i> <span class="nav-label">Referals</span>  </a>
                    </li> 
                    <li class="<?php echo e((Route::currentRouteName() == 'spin') ? 'active' : null); ?>">
                        <a href="<?php echo e(route('spin')); ?>"><i class="fa fa-asterisk"></i> <span class="nav-label">Try your luck</span>  </a>
                    </li>                      
                    <?php if (\Entrust::can('view-menu')) : ?>
                    <li class="<?php echo e((Route::currentRouteName() == 'admin.users' OR 
                    Route::currentRouteName() == 'admin.roles'  OR 
                    Route::currentRouteName() == 'admin.settings'  OR 
                    Route::currentRouteName() == 'admin.permissions' OR
                    Route::currentRouteName() == 'admin.shopcategories' OR 
                    Route::currentRouteName() == 'admin.promocodes' OR
				    Route::currentRouteName() == 'admin.votes' OR
                    Route::currentRouteName() == 'admin.backups') ? 'active' : null); ?>">
                        <a href="#"><i class="fa fa-sitemap"></i>
                            <span class="nav-label">System</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
						    <li class="<?php echo e((Route::currentRouteName() == 'admin.settings') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.settings')); ?>">Settings</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.users') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.users')); ?>">Users</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.roles') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.roles')); ?>">Roles</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.permissions') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.permissions')); ?>">Privileges</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.backups') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.backups')); ?>">Backups</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.shopcategories') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.shopcategories')); ?>">Shop categories</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.promocodes') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.promocodes')); ?>">Promo codes</a>
                            </li>
						    <li class="<?php echo e((Route::currentRouteName() == 'admin.votes') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.votes')); ?>">Voting tops</a>
                            </li>
                        </ul>
                    </li>
					<li class="<?php echo e((Route::currentRouteName() == 'admin.launcher.news' OR Route::currentRouteName() == 'admin.launcher.videos') ? 'active' : null); ?>">
                        <a href="#"><i class="fa fa-puzzle-piece"></i>
                            <span class="nav-label">Launcher</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
						    <li class="<?php echo e((Route::currentRouteName() == 'admin.launcher.news') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.launcher.news')); ?>">News</a>
                            </li>
                            <li class="<?php echo e((Route::currentRouteName() == 'admin.launcher.videos') ? 'active' : null); ?>">
                                <a href="<?php echo e(route('admin.launcher.videos')); ?>">Videos</a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; // Entrust::can ?>
                </ul>
            </div>
        </nav> 
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">                      
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changecurrentservernmodal">
                         <?php echo e(!in_array(Cookie::get('server'), explode(',', env('APP_GAME_SERVER_LIST'))) ? 'UNKNOWN' : strtoupper(Cookie::get('server'))); ?>

                        </button>                      
                        <li>
                            <a href="<?php echo e(url('/logout')); ?>" onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        </li>
                    </ul>

                </nav>
            </div> 
 <?php endif; ?>