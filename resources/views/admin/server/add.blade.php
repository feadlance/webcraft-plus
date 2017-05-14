@extends('admin.layouts.master')

@section('title', __('Yeni Sunucu'))

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Yeni Sunucu') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.server.add') }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
					{{ csrf_field() }}
					
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-2 control-label">{{ __('Sunucu Adı') }}</label>
						<div class="col-sm-10">
							<input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
						<label for="image" class="col-sm-2 control-label">{{ __('Resim') }}</label>
						<div class="col-sm-10">
							<input type="file" id="image" name="image" class="form-control">
							@if ( $errors->has('image') )
								<span class="help-block">{{ $errors->first('image') }}</span>
							@else
								<span class="help-block">{{ __('İsteğe bağlı, sunucunun resmini yükleyebilirsiniz.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
						<label for="description" class="col-sm-2 control-label">{{ __('Açıklama') }}</label>
						<div class="col-sm-10">
							<textarea type="text" id="description" name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
							@if ( $errors->has('description') )
								<span class="help-block">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('ip') || $errors->has('port') ? ' has-error' : '' }}">
						<label for="ip" class="col-sm-2 control-label">{{ __('IP Adresi') }}</label>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-8">
									<input type="text" id="ip" name="ip" value="{{ old('ip') }}" class="form-control{{ !$errors->has('ip') ? ' no-error' : '' }}" placeholder="play.example.com">
								</div>
								<div class="col-sm-4">
									<input type="text" id="port" name="port" value="{{ old('port') }}" class="form-control{{ !$errors->has('port') ? ' no-error' : '' }}" placeholder="25565">
								</div>
							</div>
							@if ( $errors->has('ip') )
								<span class="help-block">{{ $errors->first('ip') }}</span>
							@elseif ( $errors->has('port') )
								<span class="help-block">{{ $errors->first('port') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('rcon.key') || $errors->has('rcon.port') ? ' has-error' : '' }}">
						<label for="websend_key" class="col-sm-2 control-label">{{ __('Rcon') }}</label>
						<div class="col-sm-10">
							<div class="row">
								<div class="col-sm-8">
									<input type="text" id="websend_key" name="rcon[key]" value="{{ old('rcon.key') }}" class="form-control{{ !$errors->has('rcon.key') ? ' no-error' : '' }}" placeholder="{{ __('Şifre') }}">
								</div>
								<div class="col-sm-4">
									<input type="text" id="websend_port" name="rcon[port]" value="{{ old('rcon.port') }}" class="form-control{{ !$errors->has('rcon.port') ? ' no-error' : '' }}" placeholder="25575">
								</div>
							</div>
							@if ( $errors->has('rcon.key') )
								<span class="help-block">{{ $errors->first('rcon.key') }}</span>
							@elseif ( $errors->has('rcon.port') )
								<span class="help-block">{{ $errors->first('rcon.port') }}</span>
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