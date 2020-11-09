@if (!Auth::guest())
    @if (!in_array(Cookie::get('server'), explode(',', env('APP_GAME_SERVER_LIST'))))
        <div class="modal inmodal show" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content animated flipInX">
                    <div class="modal-header">
                        <h4 class="modal-title">SELECCIONA UN SERVIDOR DE JUEGOS</h4>
                        <small class="font-bold">Para ingresar al panel de usuario, debe seleccionar un servidor.</small>
                    </div>

                    <div class="modal-footer">
                        @foreach (explode(',', env('APP_GAME_SERVER_LIST')) as $server)
                        <form method="POST" action="{{ route('server') }}"
                              class="form-horizontal" enctype="multipart/form-data">

                            <input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="server" value="{{$server}}">
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-block btn-outline btn-primary">{{strtoupper($server)}}</button>
                            </div>                   
                        </form>
                        @endforeach                
                    </div>
                </div>
            </div>
        </div>
    @endif

<div class="modal inmodal" id="changecurrentservernmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header">
                <h4 class="modal-title">SELECCIONA UN SERVIDOR DE JUEGOS</h4>
				<small class="font-bold">Para ingresar al panel de usuario, debe seleccionar un servidor.</small>
            </div>

            <div class="modal-footer">
						@foreach (explode(',', env('APP_GAME_SERVER_LIST')) as $server)
						<form method="POST" action="{{ route('server') }}"
							  class="form-horizontal" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="token" value="<?php echo csrf_token(); ?>">
							<input type="hidden" name="server" value="{{$server}}">
								<div class="col-sm-3">
									<button type="submit" class="btn btn-block btn-outline btn-primary">{{strtoupper($server)}}</button>
								</div>              					
						</form>
						@endforeach
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
							<input title="Upload image" type="image" id="upload_avatar" onclick="document.getElementById('user_avatar').click();" style="width: 170px; height: 170px;" class="img-circle" src="{{ URL::asset('storage/uploads/avatars/'.$data['avatar']) }}">
							<form enctype="multipart/form-data" action="{{ route('accounts.avatar.update') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="file" name="avatar" id="user_avatar" onchange="this.form.submit();" style="display: none;" />
                            </form>
                        </div>                    
                        <div class="logo-element">
                            {{config('app.name_short')}}<i class="fa fa-plus"></i>
                        </div>
                    </li>
                    <li class="{{ (Route::currentRouteName() == 'home') ? 'active' : null}}">
                        <a href="{{ route('personal') }}"><i class="fa fa-home"></i> <span class="nav-label">Inicio
                        </span> </a>
                    </li>
                    <li class="{{ (Route::currentRouteName() == 'donate' or 
                               Route::currentRouteName() == 'accounts.passwords' or 
                               Route::currentRouteName() == 'accounts.activity' or
                               Route::currentRouteName() == 'votes') ? 'active' : null}}">
                        <a href="#"><i class="fa fa-cog"></i>
                            <span class="nav-label">Cuenta</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">

                            <li class="{{ (Route::currentRouteName() == 'donate') ? 'active' : null}}">
                                <a href="{{ route('donate') }}">Donación</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'votes') ? 'active' : null}}">
                                <a href="{{ route('votes') }}">Votación</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'accounts.passwords') ? 'active' : null}}">
                                <a href="{{ route('accounts.passwords') }}">Cambiar contraseña</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'accounts.activity') ? 'active' : null}}">
                                <a href="{{ route('accounts.activity') }}">Historial de actividad</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ (Route::currentRouteName() == 'promocodes') ? 'active' : null}}">
                        <a href="{{ route('promocodes') }}"><i class="fa fa-smile-o"></i> <span class="nav-label">Códigos promocionales</span>  </a>
                    </li>
                    <!--
                    <li class="{{ (Route::currentRouteName() == 'premium') ? 'active' : null}}">
                        <a href="{{ route('premium') }}"><i class="fa fa-star"></i> <span class="nav-label">Estado premium</span>  </a>
                    </li>
                    -->
                    @if (Cookie::get('server') != 'vanilla')
                    <li class="{{ (Route::currentRouteName() == 'characters.race' or 
								Route::currentRouteName() == 'characters.name' or 
								Route::currentRouteName() == 'characters.repair' or 
								Route::currentRouteName() == 'characters.faction') ? 'active' : null}}">
                        <a href="#"><i class="fa fa-users"></i>
                            <span class="nav-label">Personaje</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                                <li class="{{ (Route::currentRouteName() == 'characters.race') ? 'active' : null}}">
                                    <a href="{{ route('characters.race') }}">Cambio de raza</a>
                                </li>

                                <li class="{{ (Route::currentRouteName() == 'characters.name') ? 'active' : null}}">
                                    <a href="{{ route('characters.name') }}">Cambiar nombre</a>
                                </li>

                                <li class="{{ (Route::currentRouteName() == 'characters.faction') ? 'active' : null}}">
                                    <a href="{{ route('characters.faction') }}">Cambiar facción</a>
                                </li>
                                <li class="{{ (Route::currentRouteName() == 'characters.repair') ? 'active' : null}}">
                                    <a href="{{ route('characters.repair') }}">Reparar</a>
                                </li>
                        </ul>
                    </li>
                    @endif
                                      
                    <li class="{{ (Route::currentRouteName() == 'shop' or Route::currentRouteName() == 'shop.showcategory' ) ? 'active' : null}}">
                        <a href="{{ route('shop') }}"><i class="fa fa-shopping-bag"></i> <span class="nav-label">Tienda</span>  </a>
                    </li>    
                    
                    <li class="{{ Route::currentRouteName() == 'currency.gold' ? 'active' : null}}">
                        <a href="#"><i class="fa fa-dollar"></i>
                            <span class="nav-label">Monedas del juego</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">

                            <li class="{{ (Route::currentRouteName() == 'gold') ? 'active' : null}}">
                                <a href="{{ route('currency.gold') }}">Oro</a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ (Route::currentRouteName() == 'referals') ? 'active' : null}}">
                        <a href="{{ route('referals') }}"><i class="fa fa-user-plus"></i> <span class="nav-label">Reclutar amigo</span>  </a>
                    </li> 
                    <li class="{{ (Route::currentRouteName() == 'spin') ? 'active' : null}}">
                        <a href="{{ route('spin') }}"><i class="fa fa-asterisk"></i> <span class="nav-label">Prueba tu suerte</span>  </a>
                    </li>                      
                    @permission('view-menu')
                    <li class="{{ (Route::currentRouteName() == 'admin.users' OR 
                    Route::currentRouteName() == 'admin.roles'  OR 
                    Route::currentRouteName() == 'admin.settings'  OR 
                    Route::currentRouteName() == 'admin.permissions' OR
                    Route::currentRouteName() == 'admin.shopcategories' OR 
                    Route::currentRouteName() == 'admin.promocodes' OR
				    Route::currentRouteName() == 'admin.votes' OR
                    Route::currentRouteName() == 'admin.backups') ? 'active' : null}}">
                        <a href="#"><i class="fa fa-sitemap"></i>
                            <span class="nav-label">Sistema</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
						    <li class="{{ (Route::currentRouteName() == 'admin.settings') ? 'active' : null}}">
                                <a href="{{ route('admin.settings') }}">Configuraciones</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.users') ? 'active' : null}}">
                                <a href="{{ route('admin.users') }}">Usuarios</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.roles') ? 'active' : null}}">
                                <a href="{{ route('admin.roles') }}">Roles</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.permissions') ? 'active' : null}}">
                                <a href="{{ route('admin.permissions') }}">Privilegios</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.backups') ? 'active' : null}}">
                                <a href="{{ route('admin.backups') }}">Backups</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.shopcategories') ? 'active' : null}}">
                                <a href="{{ route('admin.shopcategories') }}">Categorías de tienda</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.promocodes') ? 'active' : null}}">
                                <a href="{{ route('admin.promocodes') }}">Códigos promocionales</a>
                            </li>
						    <li class="{{ (Route::currentRouteName() == 'admin.votes') ? 'active' : null}}">
                                <a href="{{ route('admin.votes') }}">Tops de votación</a>
                            </li>
                        </ul>
                    </li>
					<li class="{{ (Route::currentRouteName() == 'admin.launcher.news' OR Route::currentRouteName() == 'admin.launcher.videos') ? 'active' : null}}">
                        <a href="#"><i class="fa fa-puzzle-piece"></i>
                            <span class="nav-label">Launcher</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
						    <li class="{{ (Route::currentRouteName() == 'admin.launcher.news') ? 'active' : null}}">
                                <a href="{{ route('admin.launcher.news') }}">Noticias</a>
                            </li>
                            <li class="{{ (Route::currentRouteName() == 'admin.launcher.videos') ? 'active' : null}}">
                                <a href="{{ route('admin.launcher.videos') }}">Videos</a>
                            </li>
                        </ul>
                    </li>
                    @endpermission
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
                         {{ !in_array(Cookie::get('server'), explode(',', env('APP_GAME_SERVER_LIST'))) ? 'UNKNOWN' : strtoupper(Cookie::get('server'))}}
                        </button>                      
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();
													 document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                                Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>

                </nav>
            </div> 
 @endif