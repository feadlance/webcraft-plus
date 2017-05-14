@extends('layouts.master')

@section('title', __('Şifremi Unuttum'))

@section('canonical', url('/password/reset'))

@section('content')
	<section class="hero hero-panel" style="background-image: url({{ slider_image() }});">
		<div class="hero-bg"></div>
		<div class="container relative">
			<div class="row">
				<div style="padding-bottom: 96px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto">
					<div class="panel panel-default panel-login">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-user"></i> {{ __('Şifremi Unuttum') }}</h3>
						</div>
						<div class="panel-body">							
							<form action="{{ url('/password/reset') }}" method="post">
								{{ csrf_field() }}

								<input type="hidden" name="token" value="{{ $token }}">

								<div class="form-group input-icon-left{{ $errors->has('email') ? ' has-error' : '' }}">
									<i class="fa fa-user"></i>
									<input type="email" class="form-control" name="email" placeholder="{{ __('E-Posta Adresi') }}" value="{{ old('email') }}" autofocus>
									@if ( $errors->has('email') )
										<span class="help-block">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left{{ $errors->has('password') ? ' has-error' : '' }}">
									<i class="fa fa-lock"></i>
									<input type="password" class="form-control" name="password" placeholder="{{ __('Yeni Şifreniz') }}">
									@if ( $errors->has('password') )
										<span class="help-block">{{ $errors->first('password') }}</span>
									@endif
								</div>

								<div class="form-group input-icon-left{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<i class="fa fa-refresh"></i>
									<input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Şifrenizin Tekrarı') }}">
									@if ( $errors->has('password_confirmation') )
										<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
									@endif
								</div>

								<button type="submit" class="btn btn-primary btn-block">{{ __('Şifreyi Sıfırla') }}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop