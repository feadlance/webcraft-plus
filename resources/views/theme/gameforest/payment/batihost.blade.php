@extends('layouts.master')

@section('title', __(':method ile Kredi Yükleme', ['method' => $method['name']]))

@section('canonical', route('payment.method', $method['key']))

@section('head')
	<style>
		#payment_type .col-md-10 {
			padding-top: 9px;
		}

		#payment_type .radio-inline:first-child {
			padding-left: 0;
		}
	</style>
@stop

<?php
	$payment->htmlForm->success_url = 'success';
	$payment->htmlForm->error_url = 'error';
	$payment->htmlForm->vip_name = 'Kredi';
	$payment->htmlForm->report_email = settings('mail.from.address');
	$payment->htmlForm->only_email = settings('mail.from.address');
	#$payment->htmlForm->post_url = route('payment.listener', $method['key']);
	$payment->htmlForm->post_url = '';
?>

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
			
			{!! $payment->openHtmlForm() !!}
				<div class="panel panel-default margin-bottom-30">
					<div class="panel-body">
						<div class="form-group row{{ $errors->has('oyuncu') ? ' has-error' : '' }}">
							<label for="oyuncu" class="col-md-2 control-label">{{ __('Kullanıcı Adınız') }}</label>
							<div class="col-md-10">
								<div class="input-icon-left">
									<i class="fa fa-user"></i>
									<input type="text" class="form-control" id="oyuncu" name="oyuncu" value="{{ old('oyuncu') ?: $user->username }}">
								</div>
								@if ( $errors->has('oyuncu') )
									<span class="help-block">{{ $errors->first('oyuncu') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('amount') ? ' has-error' : '' }}" style="margin-bottom: 10px;">
							<label for="amount" class="col-md-2 control-label">{{ __('Kredi') }}</label>
							<div class="col-md-10">
								<div class="input-icon-left">
									<i class="fa fa-try"></i>
									<input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') ?: '5' }}">
								</div>
								@if ( $errors->has('amount') )
									<span class="help-block">{{ $errors->first('amount') }}</span>
								@else
									<span class="help-block">{{ __('Yüklemek istediğiniz kredi tutarı.') }}</span>
								@endif
							</div>
						</div>
						<div id="payment_type" class="form-group row{{ $errors->has('odemeturu') ? ' has-error' : '' }}">
							<label class="col-md-2 control-label">{{ __('Ödeme Türü') }}</label>
							<div class="col-md-10">
								<div class="radio radio-inline">
									<input type="radio" name="odemeturu" id="payment_type_1" value="mobil"{{ old('odemeturu') !== 'kredikarti' ? ' checked' : '' }}> 
									<label for="payment_type_1">{{ __('Mobil Ödeme') }}</label>
								</div>
								<div class="radio radio-inline">
									<input type="radio" name="odemeturu" id="payment_type_2" value="kredikarti"{{ old('odemeturu') === 'kredikarti' ? ' checked' : '' }}> 
									<label for="payment_type_2">{{ __('Kredi Kartı') }}</label>
								</div>
								@if ( $errors->has('odemeturu') )
									<span class="help-block">{{ $errors->first('odemeturu') }}</span>
								@endif
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Gönder') }}</button>
				</div>
			{!! $payment->closeHtmlForm() !!}
		</div>
	</section>
@stop