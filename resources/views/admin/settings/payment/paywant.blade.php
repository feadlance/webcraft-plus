@extends('admin.layouts.master')

@section('title', __(':name API Ayarları', ['name' => $method['name']]))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __(':name API Ayarları', ['name' => $method['name']]) }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.payment', $method['key']) }}" method="post" class="form-horizontal" role="form" autocomplete="off">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
						<label for="active" class="col-sm-2 control-label">{{ __('Aktif/Pasif') }}</label>
						<div class="col-sm-10">
							<select name="active" id="active" class="form-control">
								<option value="true"{{ $input->active === true ? ' selected' : '' }}>{{ __('Aktif') }}</option>
								<option value="false"{{ $input->active === false ? ' selected' : '' }}>{{ __('Pasif') }}</option>
							</select>
							@if ( $errors->has('active') )
								<span class="help-block">{{ $errors->first('active') }}</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
						<label for="key" class="col-sm-2 control-label">{{ __('Key') }}</label>
						<div class="col-sm-10">
							<input type="text" id="key" name="key" value="{{ $input->key }}" class="form-control">
							@if ( $errors->has('key') )
								<span class="help-block">{{ $errors->first('key') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('secret') ? ' has-error' : '' }}">
						<label for="secret" class="col-sm-2 control-label">{{ __('Secret') }}</label>
						<div class="col-sm-10">
							<input type="text" id="secret" name="secret" value="{{ $input->secret }}" class="form-control">
							@if ( $errors->has('secret') )
								<span class="help-block">{{ $errors->first('secret') }}</span>
							@endif
						</div>
					</div>

					<hr>

					<div class="form-group{{ $errors->has('api_url') ? ' has-error' : '' }}">
						<label for="api_url" class="col-sm-2 control-label">{{ __('API URL') }}</label>
						<div class="col-sm-10">
							<input type="text" id="api_url" name="api_url" value="{{ $input->api_url }}" class="form-control">
							@if ( $errors->has('api_url') )
								<span class="help-block">{{ $errors->first('api_url') }}</span>
							@else
								<span class="help-block">{{ __('Bunun ne olduğunu bilmiyorsanız, lütfen değiştirmeyin.') }}</span>
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