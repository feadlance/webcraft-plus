@extends('admin.layouts.master')

@section('title', __('ReCaptcha Ayarları'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('ReCaptcha Ayarları') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.recaptcha') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('public_key') ? ' has-error' : '' }}">
						<label for="public_key" class="col-sm-2 control-label">{{ __('Site Key') }}</label>
						<div class="col-sm-10">
							<input type="text" id="public_key" name="public_key" value="{{ $input->public_key }}" class="form-control">
							@if ( $errors->has('public_key') )
								<span class="help-block">{{ $errors->first('public_key') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('private_key') ? ' has-error' : '' }}">
						<label for="private_key" class="col-sm-2 control-label">{{ __('Secret Key') }}</label>
						<div class="col-sm-10">
							<input type="text" id="private_key" name="private_key" value="{{ $input->private_key }}" class="form-control">
							@if ( $errors->has('private_key') )
								<span class="help-block">{{ $errors->first('private_key') }}</span>
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