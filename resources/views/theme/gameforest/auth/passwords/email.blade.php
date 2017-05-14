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
							<form action="{{ url('/password/email') }}" method="post">
								{{ csrf_field() }}
								<div class="form-group input-icon-left{{ $errors->has('email') ? ' has-error' : '' }}">
									<i class="fa fa-user"></i>
									<input type="email" class="form-control" name="email" placeholder="{{ __('E-Posta Adresi') }}" value="{{ old('email') }}" autofocus>
									@if ( $errors->has('email') )
										<span class="help-block">{{ $errors->first('email') }}</span>
									@endif
								</div>
								<button type="submit" class="btn btn-primary btn-block">{{ __('Gönder') }}</button>
							</form>
						</div>
						<div class="panel-footer">
							{{ __('Şifreni biliyor musun?') }} <a href="{{ url('/login') }}">{{ __('Hemen giriş yap') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop