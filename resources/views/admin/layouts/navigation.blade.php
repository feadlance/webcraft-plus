<!-- Navigation Bar -->
<header id="topnav">
	<div class="topbar-main navbar m-b-0 b-0" style="border-radius: 0;">
		<div class="container">
			<!-- LOGO -->
			<div class="topbar-left">
				<a href="{{ route('admin.dashboard') }}" class="logo"><i class="md md-terrain"></i> <span>{{ settings('app.name') }}</span></a>
				<a target="_blank" class="view-site" href="{{ route('home') }}">Siteyi Görüntüle</a>
			</div>
			<!-- End Logo container-->
			<div class="menu-extras">
				<ul class="nav navbar-nav navbar-right pull-right">
					<li class="dropdown user-box">
						<a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
							<img src="{{ auth()->user()->avatar(36) }}" alt="user-img" class="img-circle user-img">
							<div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{ route('admin.user.detail', auth()->user()->username) }}"><i class="md md-face-unlock"></i> {{ __('Profil') }}</a></li>
							<li><a href="{{ route('admin.settings.general') }}"><i class="md md-settings"></i> {{ __('Ayarlar') }}</a></li>
							<li>
								<a href="#" onclick="logoutForm.submit();"><i class="md md-settings-power"></i> {{ __('Çıkış') }}</a>
								<form id="logoutForm" action="{{ url('/logout') }}" method="post">{{ csrf_field() }}</form>
							</li>
							
						</ul>
					</li>
				</ul>
				<div class="menu-item">
					<!-- Mobile menu toggle-->
					<a class="navbar-toggle">
						<div class="lines">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</a>
					<!-- End mobile menu toggle-->
				</div>
			</div>
		</div>
	</div>
	<div class="navbar-custom">
		<div class="container">
			<div id="navigation">
				<!-- Navigation Menu-->
				<ul class="navigation-menu">
					<li{!! menu('admin.dashboard') !!}>
						<a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> <span> {{ __('Anasayfa') }} </span> </a>
					</li>
					<li{!! menu('admin.user.list', false) !!}>
						<a href="{{ route('admin.user.list') }}"><i class="fa fa-users"></i><span> {{ __('Oyuncular') }} </span> </a>
					</li>
					<li{!! menu('admin.blog', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-newspaper-o"></i><span> {{ __('Blog') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.blog.add') !!}><a href="{{ route('admin.blog.add') }}">{{ __('Yeni Yazı') }}</a></li>
							<li{!! menu('admin.blog.list') !!}><a href="{{ route('admin.blog.list') }}">{{ __('Tüm Yazılar') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.forum', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-comments-o"></i><span> {{ __('Forum') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.forum.add') !!}><a href="{{ route('admin.forum.add') }}">{{ __('Yeni Forum') }}</a></li>
							<li{!! menu('admin.forum.list') !!}><a href="{{ route('admin.forum.list') }}">{{ __('Forumlar') }}</a></li>
							<li{!! menu('admin.forum.category.index') !!}><a href="{{ route('admin.forum.category.index') }}">{{ __('Kategoriler') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.server', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-server"></i><span> {{ __('Sunucular') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.server.add') !!}><a href="{{ route('admin.server.add') }}">{{ __('Yeni Sunucu') }}</a></li>
							<li{!! menu('admin.server.list') !!}><a href="{{ route('admin.server.list') }}">{{ __('Tüm Sunucular') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.product', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-shopping-cart"></i><span> {{ __('Market') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.product.add') !!}><a href="{{ route('admin.product.add') }}">{{ __('Yeni Ürün') }}</a></li>
							<li{!! menu('admin.product.list') !!}><a href="{{ route('admin.product.list') }}">{{ __('Tüm Ürünler') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.support', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-question-circle"></i><span> {{ __('Destek') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.support.list', false) !!}><a href="{{ route('admin.support.list') }}">{{ __('Yeni Mesajlar') }}</a></li>
							<li{!! menu('admin.support.list.archive') !!}><a href="{{ route('admin.support.list.archive') }}">{{ __('Arşiv') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.coupon', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-money"></i><span> {{ __('Kuponlar') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.coupon.add', false) !!}><a href="{{ route('admin.coupon.add') }}">{{ __('Yeni Kupon') }}</a></li>
							<li{!! menu('admin.coupon.list', false) !!}><a href="{{ route('admin.coupon.list') }}">{{ __('Aktif Kuponlar') }}</a></li>
						</ul>
					</li>
					<li{!! menu('admin.punishment.list', false) !!}>
						<a href="{{ route('admin.punishment.list') }}"><i class="fa fa-ban"></i><span> {{ __('Cezalar') }} </span> </a>
					</li>
					<li{!! menu('admin.settings', true, 'has-submenu') !!}>
						<a href="#"><i class="fa fa-cog"></i><span> {{ __('Ayarlar') }} </span> </a>
						<ul class="submenu">
							<li{!! menu('admin.settings.general', false) !!}><a href="{{ route('admin.settings.general') }}">{{ __('Genel Ayarlar') }}</a></li>
							<li{!! menu('admin.settings.payment', false) !!}><a href="{{ route('admin.settings.payment') }}">{{ __('Ödeme Ayarları') }}</a></li>
							<li{!! menu('admin.settings.social', false) !!}><a href="{{ route('admin.settings.social') }}">{{ __('Sosyal Medya Ayarları') }}</a></li>
							<li{!! menu('admin.settings.mail', false) !!}><a href="{{ route('admin.settings.mail') }}">{{ __('Mail Ayarları') }}</a></li>
							<li{!! menu('admin.settings.recaptcha', false) !!}><a href="{{ route('admin.settings.recaptcha') }}">{{ __('ReCaptcha Ayarları') }}</a></li>
							<li{!! menu('admin.settings.other', false) !!}><a href="{{ route('admin.settings.other') }}">{{ __('Diğer Ayarlar') }}</a></li>
						</ul>
					</li>
				</ul>
				<!-- End navigation menu -->
			</div>
		</div>
	</div>
</header>
<!-- End Navigation Bar -->