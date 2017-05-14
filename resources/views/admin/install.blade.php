<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{{ __(':name Kurulumu', ['name' => 'Webcraft+']) }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta content="Davutabi" name="author" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="{{ asset('admin-static/images/favicon_1.ico') }}">
	<link href="{{ asset('admin-static/css/admin.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin-static/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin-static/css/admin-theme.css') }}" rel="stylesheet" type="text/css">
	<style>
		.page-title h4 {
			margin: 0;
		}

		.container {
			margin-top: 70px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-10 col-md-offset-1">
			<div class="page-title">
				<h4>{{ __('Webcraft+ Kurulum Sayfası') }}</h4>
				<p>{{ __('Temel ayarları doldurup admin paneline giriş yapabilirsiniz.') }}</p>
			</div>

			@if ( session('flash.error') )
				<div class="alert alert-danger">
					{{ session('flash.error') }}
				</div>
			@endif

			<div class="panel panel-border panel-warning">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Kurulum') }}</div>
				</div>
				<div class="panel-body">
					@if ( $step === 1 )
						<form class="form-horizontal" action="{{ route('admin.installation') }}" method="post" role="form" autocomplete="off">
							{{ csrf_field() }}

							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="name">{{ __('Site Adı') }}</label>
								<div class="col-md-10">
									<input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" autofocus>
									@if ( $errors->has('name') )
										<span class="help-block">{{ $errors->first('name') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="url">{{ __('Site Linki') }}</label>
								<div class="col-md-10">
									<input type="text" id="url" name="url" value="{{ old('url') ?: url('/') }}" class="form-control">
									@if ( $errors->has('url') )
										<span class="help-block">{{ $errors->first('url') }}</span>
									@else
										<span class="help-block">{{ __('Sitenin linkini yazın.') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('encryption') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="encryption">{{ __('Şifreleme Methodu') }}</label>
								<div class="col-md-10">
									<select name="encryption" id="encryption" class="form-control">
										<option value="sha256"{{ old('encryption') === 'sha256' ? ' selected' : '' }}>SHA256</option>
										<option value="md5"{{ old('encryption') === 'md5' ? ' selected' : '' }}>MD5</option>
										<option value="bcrypt"{{ old('encryption') === 'bcrypt' ? ' selected' : '' }}>BCRYPT</option>
									</select>
									@if ( $errors->has('encryption') )
										<span class="help-block">{{ $errors->first('encryption') }}</span>
									@else
										<span class="help-block">{{ __('AuthMe ve bu sitenin şifreleme türü.') }}</span>
									@endif
								</div>
							</div>

							<hr>

							<div class="form-group{{ $errors->has('host') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="host">{{ __('DB Host') }}</label>
								<div class="col-md-10">
									<input type="text" id="host" name="host" value="{{ old('host') ?: '127.0.0.1' }}" class="form-control">
									@if ( $errors->has('host') )
										<span class="help-block">{{ $errors->first('host') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="port">{{ __('DB Port') }}</label>
								<div class="col-md-10">
									<input type="text" id="port" name="port" value="{{ old('port') ?: '3306' }}" class="form-control">
									@if ( $errors->has('port') )
										<span class="help-block">{{ $errors->first('port') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('database') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="database">{{ __('Veritabanı') }}</label>
								<div class="col-md-10">
									<input type="text" id="database" name="database" value="{{ old('database') }}" class="form-control">
									@if ( $errors->has('database') )
										<span class="help-block">{{ $errors->first('database') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="username">{{ __('DB Kullanıcı Adı') }}</label>
								<div class="col-md-10">
									<input type="text" id="username" name="username" value="{{ old('username') ?: 'root' }}" class="form-control">
									@if ( $errors->has('username') )
										<span class="help-block">{{ $errors->first('username') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="password">{{ __('DB Şifre') }}</label>
								<div class="col-md-10">
									<input type="text" id="password" name="password" value="{{ old('password') }}" class="form-control">
									@if ( $errors->has('password') )
										<span class="help-block">{{ $errors->first('password') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group m-b-0">
								<div class="col-md-12 text-right">
									<button class="btn btn-default">{{ __('Kaydet') }}</button>
								</div>
							</div>
						</form>
					@else
						<form action="{{ route('admin.continue') }}" method="post" role="form" class="form-horizontal">
							{{ csrf_field() }}

							<div class="form-group{{ $errors->has('admin_username') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="admin_username">{{ __('Admin Kullanıcı Adı') }}</label>
								<div class="col-md-10">
									<input type="text" id="admin_username" name="admin_username" value="{{ old('admin_username') }}" class="form-control" autofocus>
									@if ( $errors->has('admin_username') )
										<span class="help-block">{{ $errors->first('admin_username') }}</span>
									@else
										<span class="help-block">{{ __('Minecraft kullanıcı adınızı yazın.') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('admin_email') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="admin_email">{{ __('Admin E-Posta') }}</label>
								<div class="col-md-10">
									<input type="text" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" class="form-control">
									@if ( $errors->has('admin_email') )
										<span class="help-block">{{ $errors->first('admin_email') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group{{ $errors->has('admin_password') ? ' has-error' : '' }}">
								<label class="control-label col-md-2" for="admin_password">{{ __('Admin Şifre') }}</label>
								<div class="col-md-10">
									<input type="text" id="admin_password" name="admin_password" value="{{ old('admin_password') }}" class="form-control">
									@if ( $errors->has('admin_password') )
										<span class="help-block">{{ $errors->first('admin_password') }}</span>
									@endif
								</div>
							</div>

							<div class="form-group m-b-0">
								<div class="col-md-12 text-right">
									<button class="btn btn-default">{{ __('Devam Et') }}</button>
								</div>
							</div>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
</body>
</html>