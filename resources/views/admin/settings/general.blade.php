@extends('admin.layouts.master')

@section('title', __('Genel Ayarlar'))

@section('head')
	<link href="{{ asset('admin-static/plugins/tagsinput/jquery.tagsinput.css') }}" rel="stylesheet">
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Genel Ayarlar') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.general') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}
					
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-2 control-label">{{ __('Site Adı') }}</label>
						<div class="col-sm-10">
							<input type="text" id="name" name="name" value="{{ $input->name }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('server_ip') ? ' has-error' : '' }}">
						<label for="server_ip" class="col-sm-2 control-label">{{ __('Sunucu IP/Host') }}</label>
						<div class="col-sm-10">
							<input type="text" id="server_ip" name="server_ip" value="{{ $input->server_ip }}" class="form-control">
							@if ( $errors->has('server_ip') )
								<span class="help-block">{{ $errors->first('server_ip') }}</span>
							@else
								<span class="help-block">{{ __('Sunucunuzun genel IP/Host adresini yazın.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('server_versions') ? ' has-error' : '' }}">
						<label for="server_versions" class="col-sm-2 control-label">{{ __('Sunucu Versiyonları') }}</label>
						<div class="col-sm-10">
							<input type="text" id="server_versions" name="server_versions" value="{{ $input->server_versions }}" class="form-control">
							@if ( $errors->has('server_versions') )
								<span class="help-block">{{ $errors->first('server_versions') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('teamspeak_ip') ? ' has-error' : '' }}">
						<label for="teamspeak_ip" class="col-sm-2 control-label">{{ __('Teamspeak IP/HOST') }}</label>
						<div class="col-sm-10">
							<input type="text" id="teamspeak_ip" name="teamspeak_ip" value="{{ $input->teamspeak_ip }}" class="form-control">
							@if ( $errors->has('teamspeak_ip') )
								<span class="help-block">{{ $errors->first('teamspeak_ip') }}</span>
							@else
								<span class="help-block">{{ __('Teamspeak adresiniz varsa yazın, yoksa boş bırakın.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('meta.description') ? ' has-error' : '' }}">
						<label for="meta_description" class="col-sm-2 control-label">{{ __('Site Hakkında') }}</label>
						<div class="col-sm-10">
							<textarea id="meta_description" name="meta[description]" class="form-control" rows="4">{{ $input->meta_description }}</textarea>
							@if ( $errors->has('meta.description') )
								<span class="help-block">{{ $errors->first('meta.description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('meta.tags') ? ' has-error' : '' }}">
						<label for="meta_tags" class="col-sm-2 control-label">{{ __('Etiketler') }}</label>
						<div class="col-sm-10">
							<input type="text" id="meta_tags" name="meta[tags]" value="{{ $input->meta_tags }}" class="form-control">
							@if ( $errors->has('meta.tags') )
								<span class="help-block">{{ $errors->first('meta.tags') }}</span>
							@endif
						</div>
					</div>

					<hr>

					<div class="form-group{{ $errors->has('minecraftsunucular') ? ' has-error' : '' }}">
						<label for="minecraftsunucular" class="col-sm-2 control-label">{{ __('MinecraftSunucular.com') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">http://www.minecraftsunucular.com/server/</span>
								<input type="text" id="minecraftsunucular" name="minecraftsunucular" value="{{ $input->minecraftsunucular }}" class="form-control">
							</div>
							@if ( $errors->has('minecraftsunucular') )
								<span class="help-block">{{ $errors->first('minecraftsunucular') }}</span>
							@else
								<span class="help-block">{{ __('Bu sitede bir sayfa oluşturduysanız ID\'sini girin.') }}</span>
							@endif
						</div>
					</div>

					<hr>

					@if ( config('lebby.ads') !== null )
						<div class="form-group{{ $errors->has('ads_field') ? ' has-error' : '' }}">
							<label for="ads_field" class="col-sm-2 control-label">{{ __('Reklam Kodu') }}</label>
							<div class="col-sm-10">
								<textarea id="ads_field" name="ads_field" class="form-control" rows="5">{{ $input->ads_field }}</textarea>
								@if ( $errors->has('ads_field') )
									<span class="help-block">{{ $errors->first('ads_field') }}</span>
								@endif
							</div>
						</div>
					@endif

					<div class="form-group{{ $errors->has('trailer') ? ' has-error' : '' }}">
						<label for="trailer" class="col-sm-2 control-label">{{ __('Anasayfa Tanıtım Videosu') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">https://www.youtube.com/watch?v=</span>
								<input type="text" id="trailer" name="trailer" value="{{ $input->trailer }}" class="form-control">
							</div>
							@if ( $errors->has('trailer') )
								<span class="help-block">{{ $errors->first('trailer') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
						<label for="about" class="col-sm-2 control-label">{{ __('Footer Yazısı') }}</label>
						<div class="col-sm-10">
							<textarea id="about" name="about" class="form-control" rows="4">{{ $input->about }}</textarea>
							@if ( $errors->has('about') )
								<span class="help-block">{{ $errors->first('about') }}</span>
							@endif
						</div>
					</div>

					<hr>

					<div class="form-group{{ $errors->has('encryption') ? ' has-error' : '' }}">
						<label for="encryption" class="col-sm-2 control-label">{{ __('Şifreleme Yöntemi') }}</label>
						<div class="col-sm-10">
							<select id="encryption" name="encryption" class="form-control">
								<option value="sha256"{{ $input->encryption === 'sha256' ? ' selected' : '' }}>SHA256</option>
								<option value="md5"{{ $input->encryption === 'md5' ? ' selected' : '' }}>MD5</option>
								<option value="bcrypt"{{ $input->encryption === 'bcrypt' ? ' selected' : '' }}>BCRYPT</option>
							</select>
							@if ( $errors->has('encryption') )
								<span class="help-block">{{ $errors->first('encryption') }}</span>
							@else
								<span class="help-block">
									{{ __('Kullanıcı şifreleri hangi method ile şifrelensin?') }}<br>
									{{ __('Eğer bunun ne olduğunu bilmiyorsanız lütfen değiştirmeyin.') }}
								</span>
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

@section('scripts')
	<script src="{{ asset('admin-static/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<script>$('#meta_tags').tagsInput({width:'auto'});</script>
@stop