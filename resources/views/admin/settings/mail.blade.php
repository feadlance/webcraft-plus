@extends('admin.layouts.master')

@section('title', __('Mail Ayarları'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Genel Ayarlar') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.mail') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="email" class="col-sm-2 control-label">{{ __('E-Mail Adresiniz') }}</label>
						<div class="col-sm-10">
							<input type="email" id="email" name="email" value="{{ $input->email }}" class="form-control">
							@if ( $errors->has('email') )
								<span class="help-block">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>

					<hr>

					<div class="form-group{{ $errors->has('host') ? ' has-error' : '' }}">
						<label for="host" class="col-sm-2 control-label">{{ __('SMTP Host') }}</label>
						<div class="col-sm-10">
							<input type="text" id="host" name="host" value="{{ $input->host }}" class="form-control">
							@if ( $errors->has('host') )
								<span class="help-block">{{ $errors->first('host') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
						<label for="port" class="col-sm-2 control-label">{{ __('SMTP Port') }}</label>
						<div class="col-sm-10">
							<input type="text" id="port" name="port" value="{{ $input->port }}" class="form-control">
							@if ( $errors->has('port') )
								<span class="help-block">{{ $errors->first('port') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
						<label for="username" class="col-sm-2 control-label">{{ __('SMTP Kullanıcı Adı') }}</label>
						<div class="col-sm-10">
							<input type="text" id="username" name="username" value="{{ $input->username }}" class="form-control">
							@if ( $errors->has('username') )
								<span class="help-block">{{ $errors->first('username') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-sm-2 control-label">{{ __('SMTP Şifresi') }}</label>
						<div class="col-sm-10">
							<input type="text" id="password" name="password" value="{{ $input->password }}" class="form-control">
							@if ( $errors->has('password') )
								<span class="help-block">{{ $errors->first('password') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('encryption') ? ' has-error' : '' }}">
						<label for="encryption" class="col-sm-2 control-label">{{ __('SMTP Güvenliği') }}</label>
						<div class="col-sm-10">
							<select id="encryption" name="encryption" class="form-control">
								<option value="ssl"{{ $input->encryption === 'ssl' ? ' selected' : '' }}>{{ __('SSL') }}</option>
								<option value="tls"{{ $input->encryption === 'tls' ? ' selected' : '' }}>{{ __('TLS') }}</option>
							</select>
							@if ( $errors->has('encryption') )
								<span class="help-block">{{ $errors->first('encryption') }}</span>
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