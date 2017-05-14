@extends('layouts.master')

@section('title', __('Giriş'))

@section('canonical', url('/login'))

@section('content')
	<section class="hero hero-panel" style="background-image: url({{ slider_image() }});">
		<div class="hero-bg"></div>
		<div class="container relative">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto">
					<div class="panel panel-default panel-login">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-user"></i> {{ __('Oturum Aç') }}</h3>
						</div>
						<div class="panel-body">							
							<form action="{{ url('/login') }}" method="post">
								{{ csrf_field() }}

								<div class="form-group input-icon-left{{ $errors->has('username') ? ' has-error' : '' }}">
									<i class="fa fa-user"></i>
									<input type="text" class="form-control" name="username" placeholder="{{ __('Kullanıcı Adı') }}" value="{{ old('username') }}" autofocus>
									@if ( $errors->has('username') )
										<span class="help-block">{{ $errors->first('username') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left{{ $errors->has('password') ? ' has-error' : '' }}">
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" name="password" placeholder="{{ __('Şifre') }}">
									@if ( $errors->has('password') )
										<span class="help-block">{{ $errors->first('password') }}</span>
									@endif
									<small style="display: block; margin-top: 10px;">
										<a href="{{ url('/password/reset') }}">{{ __('Şifremi Unuttum') }}</a>
									</small>
								</div>

								<button type="submit" class="btn btn-primary btn-block">{{ __('Giriş Yap') }}</button>
								
								<div class="form-actions">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" name="remember" id="remember"{{ old('remember') === 'on' ? ' checked' : '' }}> 
										<label for="remember">{{ __('Beni Hatırla') }}</label>
									</div>
								</div>
							</form>
						</div>
						<div class="panel-footer">
							{{ __('Henüz bir hesabın yok mu?') }} <a href="{{ url('/register') }}">{{ __('Hemen aç') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop