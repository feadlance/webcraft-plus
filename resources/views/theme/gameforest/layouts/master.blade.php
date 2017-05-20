<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
	<head>
	    <!-- META -->
	    <meta charset="utf-8">
	    @if ( settings('lebby.google.search_console') )
<meta name="google-site-verification" content="{{ settings('lebby.google.search_console') }}">
	    @endif
<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	    @foreach ( array_merge($metaTags, isset($tags) ? $tags : []) as $key => $meta )
<meta name="{{ $key }}" content="{{ $meta }}">
	    @endforeach

	    <!-- CANONICAL -->
		<link rel="canonical" href="@yield('canonical')">

		<!-- TITLE -->
	    <title>@yield('title', __('Anasayfa')){{ auth()->check() !== true ? ' - ' . settings('app.name') : null }}</title>

	    <!-- FAVICON -->
	    <link rel="shortcut icon" href="{{ _asset('img/favicon.ico') }}">

	    <!-- CORE CSS -->
	    <link href="{{ _asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	    <link href="{{ _asset('css/theme.min.css') }}" rel="stylesheet">
	    <link href="{{ _asset('css/custom.css') }}" rel="stylesheet">
	    <link href="{{ _asset('css/helpers.min.css') }}" rel="stylesheet">
	    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>

	    <!-- PLUGINS -->
	    <link href="{{ _asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	    <link href="{{ _asset('plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
	    <link href="{{ _asset('plugins/animate/animate.min.css') }}" rel="stylesheet">
	    <link href="{{ _asset('plugins/animate/animate.delay.css') }}" rel="stylesheet">
	    <link href="{{ _asset('plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">

		<!-- CUSTOM -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	    @yield('head')
	</head>

	<body class="fixed-header">
	    <header>
	        <div class="container">
	            <span class="bar hide"></span>
	            <a href="{{ route('home') }}" class="logo"><img src="{{ _asset('img/logo.png') }}" alt="Logo"></a>
	            <nav>
	                <div class="nav-control">
	                    <ul>
	                    	<li>
		                    	<a{{ menu('home') }} href="{{ route('home') }}">
		                    		<i class="fa fa-home margin-right-5"></i> {{ __('Anasayfa') }}
		                    	</a>
	                    	</li>
	                    	@if ( config('lebby.bungeecord') === true )
		                    	<li>
		                    		<a{{ menu('hit.top100') }} href="{{ route('hit.top100') }}">
		                    			<i class="fa fa-trophy margin-right-5"></i> {{ __('Sıralama') }}
		                    		</a>
		                    	</li>
	                    	@endif
	                    	<li>
	                    		<a{{ menu('market.index') }} href="{{ route('market.index') }}">
	                    			<i class="fa fa-shopping-cart margin-right-5"></i> {{ __('Market') }}
	                    		</a>
	                    	</li>
	                    	<li>
	                    		<a{{ menu('blog.list') }} href="{{ route('blog.list') }}">
	                    			<i class="fa fa-newspaper-o margin-right-5"></i> {{ __('Blog') }}
	                    		</a>
	                    	</li>
	                    	<li>
	                    		<a{{ menu('forum') }} href="{{ route('forum.index') }}">
	                    			<i class="fa fa-users margin-right-5"></i> {{ __('Forum') }}
	                    		</a>
	                    	</li>
	                    </ul>
	                </div>
	            </nav>
	            <div class="nav-right">
	           		@if ( auth()->check() === true )
		                <div class="nav-profile dropdown">
		                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ auth()->user()->avatar() }}" alt="User Avatar"> <span>{{ auth()->user()->nameOrUsername() }}</span></a>
		                    <ul class="dropdown-menu">
		                        <li><a href="{{ route('profile.index', auth()->user()->username) }}"><i class="fa fa-user"></i> {{ __('Profil') }}</a></li>
		                        <li><a data-toggle="modal" href="#credit"><i class="fa fa-try"></i> {{ __('Kredi Yükle') }}</a></li>
		                        <li><a href="{{ route('support.list') }}"><i class="fa fa-question"></i> {{ __('Destek Talebi') }}</a></li>
		                        <li class="divider"></li>
		                        @if ( auth()->user()->isAdmin === true )
		                        	<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tasks"></i> {{ __('Yönetim Paneli') }}</a></li>
		                       		<li class="divider"></li>
		                    	@endif
		                        <li>
		                        	<form action="{{ url('/logout') }}" method="post">
		                        		{{ csrf_field() }}
		                        		<a href="#" onclick="parentNode.submit();">
		                        			<i class="fa fa-power-off"></i> {{ __('Oturumu Kapat') }}
		                        		</a>
		                        	</form>
		                        </li>
		                    </ul>
		                </div>
		            @else
		            	<div class="nav-control">
		            		<ul>
		            			<li>
		            				<a href="#signin" data-toggle="modal">
		            					<i class="fa fa-sign-in margin-right-5"></i> {{ __('Oturum Aç') }}
		            				</a>
		            				<a class="hidden-xs" href="{{ route('register') }}" data-toggle="modal">
		            					<i class="fa fa-user-plus margin-right-5"></i> {{ __('Hesap Oluştur') }}
		            				</a>
		            			</li>
		            		</ul>
		            	</div>
	               	@endif
	            </div>
	        </div>
	    </header>
	    <!-- /header -->

	    <!-- wrapper -->
	    <div id="wrapper"{!! isset($bg_gray) && $bg_gray ? ' class="bg-grey-50"' : '' !!}>
	        @yield('content')
	    </div>
	    <!-- /#wrapper -->

	    <!-- footer -->
	    <footer>
	        <div class="container">
	            <div class="widget row">
	            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	                    <h4 class="title">{{ __('Çevrimiçi Oyuncular (:online)', ['online' => $onlineUsers->count()]) }}</h4>
	                	@if ( $onlineUsers->count() > 0 )
		                	<ul class="img-radius-list">
		                		@foreach ( $onlineUsers->limit(21)->get() as $onlineUser )
									@if ( isset($onlineUser->username) )
										<li>
											<a href="{{ route('profile.index', $onlineUser->username) }}">
												<img title="{{ $onlineUser->username . (settings('lebby.bungeecord') === true ? ": {$onlineUser->server()->name}" : null) }}" data-toggle="tooltip" src="{{ $onlineUser->avatar(45) }}" alt="User Avatar">
												<span data-toggle="tooltip" title="{{ __('Çevrimiçi') }}" class="online"></span>
											</a>
										</li>
									@endif
		                		@endforeach
		                	</ul>
		                @else
		                	<p>{{ __('Şuan da sunucuda kimse yok.') }}<br>{{ __('İlk sen girmek ister misin?') }}</p>
	                	@endif
	                </div>

					@if ( settings('lebby.footer_links') && config('lebby.ads') === null )
		                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
		                    <h4 class="title">Sponsorlu Bağlantılar</h4>
		                    <ul class="nav">{!! strip_tags(settings('lebby.footer_links'), '<li><a><span><i><strong>') !!}</ul>
		                </div>
	               	@endif

	                <div class="{{ settings('lebby.footer_links') ? 'col-lg-5 col-md-5 col-sm-5 col-xs-12' : 'col-lg-8 col-md-8 col-sm-8 col-xs-12' }}">
	                    <h4 class="title">{{ __('Sunucumuz Hakkında') }}</h4>
	                    <p>{!! nl2br(e(settings('lebby.about'))) !!}</p>
	                </div>
	            </div>
	        </div>

	        <div class="footer-bottom">
	            <div class="container">
	                <ul class="list-inline">
	                	@foreach ( settings('lebby.social') as $social )
							@if ( $social[2] )
								<li><a target="_blank" href="{{ $social[2] }}" class="btn btn-circle btn-social-icon" data-toggle="tooltip" title="{{ $social[0] }}"><i class="fa fa-{{ $social[1] }}"></i></a></li>
							@endif
	                	@endforeach
	                </ul>
	                &copy; {{ date('Y') }} {{ settings('app.name') }}. {{ __('Hakları mahfuzdur.') }}
	            </div>
	        </div>
	    </footer>
	    <!-- /.footer -->

		@if ( auth()->check() !== true )
		    <div id="signin" class="modal fade" tabindex="-1">
		        <div class="modal-dialog modal-sm">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                    <h3 class="modal-title"><i class="fa fa-user"></i> {{ __('Oturum Aç') }}</h3>
		                </div>
		                <div class="modal-body">
		                    <form action="{{ url('/login') }}" method="post">
		                    	{{ csrf_field() }}

		                        <div class="form-group input-icon-left">
		                            <i class="fa fa-user"></i>
		                            <input type="text" class="form-control" id="username" name="username" placeholder="{{ __('Kullanıcı Adı') }}">
		                        </div>

		                        <div class="form-group input-icon-left">
		                            <i class="fa fa-lock"></i>
		                            <input type="password" class="form-control" name="password" placeholder="{{ __('Şifre') }}">
		                            <small style="display: block; margin-top: 10px;">
										<a href="{{ url('/password/reset') }}">{{ __('Şifremi Unuttum') }}</a>
									</small>
		                        </div>

		                        <button type="submit" class="btn btn-primary btn-block">{{ __('Giriş Yap') }}</button>

		                        <div class="form-actions">
		                            <div class="checkbox">
		                                <input type="checkbox" id="remember" name="remember">
		                                <label for="remember">{{ __('Beni Hatırla') }}</label>
		                            </div>
		                        </div>
		                    </form>
		                </div>
		                <div class="modal-footer text-left">
		                	{{ __('Henüz bir hesabın yok mu?') }} <a href="{{ url('/register') }}">{{ __('Hemen aç') }}</a>
		                </div>
		            </div>
		        </div>
		    </div>
		    <!-- /.modal -->
		@else
			<div id="credit" class="modal fade" tabindex="-1">
		        <div class="modal-dialog modal-sm">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal">&times;</button>
		                    <h3 class="modal-title"><i class="fa fa-try"></i> {{ __('Kredi Yükle') }}</h3>
		                </div>
		                @if ( count(payment_methods()) > 0 )
							<div class="modal-body" style="padding: 0;">
			                    <ul class="list-payments">
			                    	@foreach ( payment_methods() as $key => $method )
										<li>
											<a href="{{ route('payment.method', $key) }}">
												{{ $method['name'] }}
												<span>{{ __($method['description']) }}</span>
											</a>
										</li>
			                    	@endforeach
			                    </ul>
			                </div>
		                @else
							<div class="modal-body">
								{{ __('Kredi yükleyebileceğiniz bir ödeme yöntemi bulunmamaktadır.') }}
							</div>
		                @endif
		            </div>
		        </div>
		    </div>
		    <!-- /.modal -->
		@endif

	    <!-- Javascript -->
	    <script src="{{ _asset('plugins/jquery/jquery-1.11.1.min.js') }}"></script>
	    <script src="{{ asset('js/app.js') }}"></script>
	    @include('components.scripts')
	    <script src="{{ _asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
	    <script src="{{ _asset('plugins/core.min.js') }}"></script>
	    <script>
	        $('#signin').on('shown.bs.modal', function () {
	        	$('#username').focus();
	        });
	    </script>
	    @yield('scripts')
	    @include('components.flash')
	</body>
</html>