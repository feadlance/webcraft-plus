<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>@yield('title', __('Anasayfa')) - {{ settings('app.name') }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta content="Davutabi" name="author" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="shortcut icon" href="{{ asset('admin-static/images/favicon_1.ico') }}">
		<link href="{{ asset('admin-static/css/admin.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-static/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-static/css/admin-theme.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('admin-static/css/custom.css') }}" rel="stylesheet" type="text/css">
		<script src="{{ asset('admin-static/js/modernizr.min.js') }}"></script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		@yield('head')
	</head>
	<body>
		@include('admin.layouts.navigation')
		<div id="app" class="wrapper">
			<div class="container">
				@yield('content')
				<!-- Footer -->
				<footer class="footer text-right">
					<div class="container">
						<div class="row">
							<div class="col-xs-6">
								{{ date('Y') }} © {{ settings('app.name') }}.
							</div>
							<div class="col-xs-6">
								<ul class="pull-right list-inline m-b-0">
									<li>
										<a target="_blank" href="https://www.weblebby.com/webcraft-plus">{{ __('Hakkında') }}</a>
									</li>
									<li>
										<a target="_blank" rel="nofollow" href="https://www.youtube.com/davutabi">Davutabi</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</footer>
				<!-- End Footer -->
			</div>
			<!-- end container -->
		</div>
		<!-- jQuery  -->
		<script src="{{ asset('admin-static/js/jquery.min.js') }}"></script>
		@include('admin.layouts.scripts')
		<script src="{{ asset('admin-static/js/admin.js') }}"></script>
		<script src="{{ asset('admin-static/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('admin-static/js/detect.js') }}"></script>
		<script src="{{ asset('admin-static/js/fastclick.js') }}"></script>
		<script src="{{ asset('admin-static/js/jquery.blockUI.js') }}"></script>
		<script src="{{ asset('admin-static/js/waves.js') }}"></script>
		<script src="{{ asset('admin-static/js/wow.min.js') }}"></script>
		<script src="{{ asset('admin-static/js/jquery.nicescroll.js') }}"></script>
		<script src="{{ asset('admin-static/js/jquery.scrollTo.min.js') }}"></script>
		<!-- App js -->
		<script src="{{ asset('admin-static/js/jquery.app.js') }}"></script>
		<!-- Custom -->
		@include('components.flash')
		@yield('scripts')
	</body>
</html>