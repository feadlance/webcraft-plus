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
			
			<form action="{{ route('payment.post', $method['key']) }}" method="post" role="form">
				{{ csrf_field() }}

				<div class="panel panel-default margin-bottom-30">
					<div class="panel-body">
						<div class="form-group row{{ $errors->has('username') ? ' has-error' : '' }}">
							<label for="username" class="col-md-2 control-label">{{ __('Kullanıcı Adınız') }}</label>
							<div class="col-md-10">
								<div class="input-icon-left">
									<i class="fa fa-user"></i>
									<input type="text" class="form-control" id="username" name="username" value="{{ old('username') ?: $user->username }}">
								</div>
								@if ( $errors->has('username') )
									<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('credit') ? ' has-error' : '' }}" style="margin-bottom: 10px;">
							<label for="credit" class="col-md-2 control-label">{{ __('Kredi') }}</label>
							<div class="col-md-10">
								<div class="input-icon-left">
									<i class="fa fa-try"></i>
									<input type="text" class="form-control" id="credit" name="credit" value="{{ old('credit') ?: '5' }}">
								</div>
								@if ( $errors->has('credit') )
									<span class="help-block">{{ $errors->first('credit') }}</span>
								@else
									<span class="help-block">{{ __('Yüklemek istediğiniz kredi tutarı.') }}</span>
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

	@if ( session('iframe') )
		<div id="paywant-modal" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title"><i class="fa fa-user"></i> {{ __('Ödeme Yap') }}</h3>
					</div>
					<div class="modal-body">
						<iframe width="100%" height="600" src="{{ session('iframe') }}" frameborder="0"></iframe>
					</div>
				</div>
			</div>
		</div>
	@endif
@stop

@section('scripts')
	@if ( session('iframe') )
		<script type="text/javascript">
			$('#paywant-modal').modal('show');
		</script>
	@endif
@stop