@extends('profile.master')

@section('profile-title', __('Ayarlar'))

@section('profile-content')
	<div class="col-md-12">
		<div class="panel panel-default margin-bottom-40">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Kişisel') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('profile.settings.general', $user->username) }}" method="post" class="form-label">
					{{ csrf_field() }}

					<div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label col-md-2">{{ __('Adınız & Soyadınız') }}</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?: $user->name }}">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row{{ $errors->has('biography') ? ' has-error' : '' }}">
						<label class="control-label col-md-2">{{ __('Hakkınızda') }}</label>
						<div class="col-md-10">
							<div class="forum-post no-margin no-shadow">
								<textarea class="form-control" name="biography" rows="3">{{ old('biography') ?: $user->biography }}</textarea>
							</div>
							@if ( $errors->has('biography') )
								<span class="help-block">{{ $errors->first('biography') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row{{ $errors->has('birthday') ? ' has-error' : '' }}">
						<label for="birthday" class="control-label col-md-2">{{ __('Doğum Tarihiniz') }}</label>
						<div class="col-md-10">
							<input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') ?: $user->birthday }}">
							@if ( $errors->has('birthday') )
								<span class="help-block">{{ $errors->first('birthday') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group row{{ $errors->has('location') ? ' has-error' : '' }}">
						<label for="location" class="control-label col-md-2">{{ __('Konum') }}</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="location" name="location" value="{{ old('location') ?: $user->location }}">
							@if ( $errors->has('location') )
								<span class="help-block">{{ $errors->first('location') }}</span>
							@else
								<span class="help-block">{{ __('Örnek: "İstanbul, Türkiye"') }}</span>
							@endif
						</div>
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Kaydet') }}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-default margin-bottom-40">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Sosyal') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('profile.settings.social', $user->username) }}" method="post" class="form-label">
					{{ csrf_field() }}

					<div class="form-group row{{ $errors->has('social_facebook') ? ' has-error' : '' }}">
						<label for="social_facebook" class="control-label col-md-2">{{ __('Facebook') }}</label>
						<div class="col-md-10">
							<div class="input-icon-left">
								<i class="fa fa-facebook"></i>
								<input type="text" class="form-control" id="social_facebook" name="social_facebook" value="{{ old('social_facebook') ?: $user->social_facebook }}" placeholder="{{ __('Kullanıcı adı...') }}">
							</div>
							@if ( $errors->has('social_facebook') )
								<span class="help-block">{{ $errors->first('social_facebook') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group row{{ $errors->has('social_youtube') ? ' has-error' : '' }}">
						<label for="social_youtube" class="control-label col-md-2">{{ __('Youtube') }}</label>
						<div class="col-md-10">
							<div class="input-icon-left">
								<i class="fa fa-youtube"></i>
								<input type="text" class="form-control" id="social_youtube" name="social_youtube" value="{{ old('social_youtube') ?: $user->social_youtube }}" placeholder="{{ __('Kullanıcı adı...') }}">
							</div>
							@if ( $errors->has('social_youtube') )
								<span class="help-block">{{ $errors->first('social_youtube') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group row{{ $errors->has('social_steam') ? ' has-error' : '' }}">
						<label for="social_steam" class="control-label col-md-2">{{ __('Steam') }}</label>
						<div class="col-md-10">
							<div class="input-icon-left">
								<i class="fa fa-steam"></i>
								<input type="text" class="form-control" id="social_steam" name="social_steam" value="{{ old('social_steam') ?: $user->social_steam }}" placeholder="{{ __('Kullanıcı adı...') }}">
							</div>
							@if ( $errors->has('social_steam') )
								<span class="help-block">{{ $errors->first('social_steam') }}</span>
							@endif
						</div>
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Kaydet') }}</button>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-default margin-bottom-40">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Şifre Değiştirme') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('profile.settings.password', $user->username) }}" method="post" class="form-label">
					{{ csrf_field() }}

					<div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="control-label col-md-2">{{ __('Mevcut Şifreniz') }}</label>
						<div class="col-md-10">
							<input type="password" class="form-control" id="password" name="password">
							@if ( $errors->has('password') )
								<span class="help-block">{{ $errors->first('password') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group row{{ $errors->has('new_password') ? ' has-error' : '' }}">
						<label for="new_password" class="control-label col-md-2">{{ __('Yeni Şifreniz') }}</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-md-6">
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="{{ __('Yeni şifre...') }}">
								</div>
								<div class="col-md-6">
									<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="{{ __('Yeni şifre tekrarı...') }}">
								</div>
							</div>
							@if ( $errors->has('new_password') )
								<span class="help-block">{{ $errors->first('new_password') }}</span>
							@endif
						</div>
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Kaydet') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop