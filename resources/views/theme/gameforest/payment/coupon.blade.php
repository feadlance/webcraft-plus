@extends('layouts.master')

@section('title', __(':method ile Kredi Yükleme', ['method' => $method['name']]))

@section('canonical', route('payment.method', $method['key']))

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Kredi Yükle'),
			'url' => '#credit',
			'url_toggle' => 'modal'
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => $method['name'],
			'active' => true
		])
	@endcomponent

	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4 class="no-padding-top">{{ __('Kredi Yükle') }} <small>{{ __(':method ile kredinizi hemen yükleyin.', ['method' => $method['name']]) }}</small></h4>
			</div>
			
			<form action="{{ route('payment.post', $method['key']) }}" method="post" role="form" autocomplete="off">
				{{ csrf_field() }}

				<div class="panel panel-default margin-bottom-30">
					<div class="panel-body">
						<div class="form-group row{{ $errors->has('code') ? ' has-error' : '' }}">
							<label for="code" class="col-md-2 control-label">{{ __('Kupon Kodunuz') }}</label>
							<div class="col-md-10">
								<div class="input-icon-left">
									<i class="fa fa-key"></i>
									<input type="text" class="form-control" id="code" name="code" placeholder="...">
								</div>
								@if ( $errors->has('code') )
									<span class="help-block">{{ $errors->first('code') }}</span>
								@endif
							</div>
						</div>
					</div>
				</div>
				
				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Gönder') }}</button>
				</div>
			</form>
		</div>
	</section>
@stop

<?php $bg_gray = true; ?>