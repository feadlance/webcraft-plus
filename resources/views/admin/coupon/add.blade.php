@extends('admin.layouts.master')

@section('title', __('Yeni Kupon'))

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Yeni Kupon') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.coupon.add') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
						<label for="code" class="col-sm-2 control-label">{{ __('Kupon Kodu') }}</label>
						<div class="col-sm-10">
							<input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control">
							@if ( $errors->has('code') )
								<span class="help-block">{{ $errors->first('code') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('piece') ? ' has-error' : '' }}">
						<label for="piece" class="col-sm-2 control-label">{{ __('Adet') }}</label>
						<div class="col-sm-10">
							<input type="number" id="piece" name="piece" value="{{ old('piece') }}" class="form-control">
							@if ( $errors->has('piece') )
								<span class="help-block">{{ $errors->first('piece') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('credit') ? ' has-error' : '' }}">
						<label for="credit" class="col-sm-2 control-label">{{ __('Hediye Tutarı') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">₺</span>
								<input type="text" id="credit" name="credit" placeholder="0,00" value="{{ old('credit') }}" class="form-control">
							</div>
							@if ( $errors->has('credit') )
								<span class="help-block">{{ $errors->first('credit') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group m-b-0">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-default waves-effect waves-light">{{ __('Kaydet') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop