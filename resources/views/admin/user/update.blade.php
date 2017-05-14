@extends('admin.layouts.master')

@section('title', $user->nameOrUsername())

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Kullanıcıyı Düzenle') }}</div>
			</div>
			<div class="panel-body">
				<form id="form" action="{{ route('admin.user.update', $user->username) }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}
					
					<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
						<label for="username" class="col-sm-2 control-label">{{ __('Kullanıcı Adı') }}</label>
						<div class="col-sm-10">
							<input type="text" id="username" name="username" value="{{ $input->username }}" class="form-control" readonly>
							@if ( $errors->has('username') )
								<span class="help-block">{{ $errors->first('username') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-2 control-label">{{ __('İsim & Soyisim') }}</label>
						<div class="col-sm-10">
							<input type="text" id="name" name="name" value="{{ $input->name }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="email" class="col-sm-2 control-label">{{ __('E-Posta') }}</label>
						<div class="col-sm-10">
							<input type="text" id="email" name="email" value="{{ $input->email }}" class="form-control">
							@if ( $errors->has('email') )
								<span class="help-block">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }}">
						<label for="is_admin" class="col-sm-2 control-label">{{ __('Oyuncu/Admin') }}</label>
						<div class="col-sm-10">
							<select name="is_admin" id="is_admin" class="form-control">
								<option value="false"{{ $input->is_admin === 'false' ? ' selected' : '' }}>{{ __('Oyuncu') }}</option>
								<option value="true"{{ $input->is_admin === 'true' ? ' selected' : '' }}>{{ __('Admin') }}</option>
							</select>
							@if ( $errors->has('is_admin') )
								<span class="help-block">{{ $errors->first('is_admin') }}</span>
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