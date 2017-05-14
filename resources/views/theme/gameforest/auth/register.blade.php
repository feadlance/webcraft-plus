<?php $activeRecaptcha = settings('recaptcha.public_key') && settings('recaptcha.private_key'); ?>

@extends('layouts.master')

@section('title', __('Kayıt Ol'))

@section('canonical', url('/register'))

@section('content')
	<section class="hero hero-panel" style="background-image: url({{ slider_image() }});">
		<div class="hero-bg"></div>
		<div class="container relative">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto">
					<div class="panel panel-default panel-login">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-user"></i> {{ __('Kayıt Ol') }}</h3>
						</div>
						<div class="panel-body">
							@if ( $errors->has('g-recaptcha-response') )
								<div class="alert alert-danger">
									{{ $errors->first('g-recaptcha-response') }}
								</div>
							@endif						
							<form id="registerForm" action="{{ url('/register') }}" method="post">
								{{ csrf_field() }}

								<div class="form-group input-icon-left{{ $errors->has('username') ? ' has-error' : '' }}">
									<i class="fa fa-user"></i>
									<input type="text" class="form-control" name="username" placeholder="{{ __('Kullanıcı Adı') }}" value="{{ old('username') }}" required autofocus>
									@if ( $errors->has('username') )
										<span class="help-block">{{ $errors->first('username') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left{{ $errors->has('email') ? ' has-error' : '' }}">
									<i class="fa fa-envelope"></i>
									<input type="email" class="form-control" name="email" placeholder="{{ __('E-Posta') }}" value="{{ old('email') }}" required>
									@if ( $errors->has('email') )
										<span class="help-block">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left{{ $errors->has('password') ? ' has-error' : '' }}">
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" name="password" placeholder="{{ __('Şifre') }}" required>
									@if ( $errors->has('password') )
										<span class="help-block">{{ $errors->first('password') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left">
									<i class="fa fa-check"></i>
									<input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Tekrar Şifre') }}" required>
								</div>
								
								@if ( $activeRecaptcha )
									<button data-sitekey="{{ settings('recaptcha.public_key') }}" data-callback="register" type="submit" class="g-recaptcha btn btn-primary btn-block">{{ __('Kayıt Ol') }}</button>
								@else
									<button type="submit" class="btn btn-primary btn-block">{{ __('Kayıt Ol') }}</button>
								@endif
							</form>
						</div>
						<div class="panel-footer">
							{{ __('Halihazırda bir hesabın varsa') }} <a href="{{ url('/login') }}">{{ __('giriş yap') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop

@if ( $activeRecaptcha )
	@section('scripts')
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script type="text/javascript">
			function register() {
				document.getElementById("registerForm").submit();
			}
		</script>
	@stop
@endif