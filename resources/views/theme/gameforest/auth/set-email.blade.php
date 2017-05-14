@extends('layouts.master')

@section('title', __('Yeni e-Posta'))

@section('canonical', url('/login/email'))

@section('content')
	<section class="hero hero-panel" style="background-image: url({{ slider_image() }});">
		<div class="hero-bg"></div>
		<div class="container relative">
			<div style="padding-bottom: 250px;" class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto">
					<div class="panel panel-default panel-login">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-user"></i> {{ __('Yeni e-Posta') }}</h3>
						</div>
						<div class="panel-body">							
							<form action="{{ url('/login/email') }}" method="post">
								{{ csrf_field() }}

								<div class="form-group input-icon-left{{ $errors->has('email') ? ' has-error' : '' }}">
									<i class="fa fa-user"></i>
									<input type="email" class="form-control" name="email" placeholder="{{ __('Yeni e-Posta') }}" value="{{ old('email') }}" autofocus required>
									@if ( $errors->has('email') )
										<span class="help-block">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<button type="submit" class="btn btn-primary btn-block">{{ __('Kaydet ve Devam et') }}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop