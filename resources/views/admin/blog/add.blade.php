@extends('admin.layouts.master')

@section('title', __('Yeni Yazı'))

@section('head')
	<link href="{{ asset('admin-static/plugins/tagsinput/jquery.tagsinput.css') }}" rel="stylesheet">
	<link href="{{ asset('admin-static/plugins/summernote/dist/summernote.css') }}" rel="stylesheet">

	<style>
		.note-editor.panel.panel-default {
			margin-bottom: 0;
		}
	</style>
@stop

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Yeni Yazı') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.blog.add') }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
					{{ csrf_field() }}

					@if ( $post !== null )
						<input type="hidden" name="post" value="{{ $post->id }}">
					@endif
					
					<div class="form-group{{ $errors->has('server') ? ' has-error' : '' }}">
						<label for="server" class="col-sm-2 control-label">{{ __('Sunucu (Kategori)') }}</label>
						<div class="col-sm-10">
							<select name="server" id="server" class="form-control">
								<option value="0">Genel</option>
								@foreach ( $servers as $server )
									<option value="{{ $server->id }}"{{ $input->server_id == $server->id ? ' selected' : '' }}>{{ $server->name }}</option>
								@endforeach
							</select>
							@if ( $errors->has('server') )
								<span class="help-block">{{ $errors->first('server') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
						<label for="title" class="col-sm-2 control-label">{{ __('Başlık') }}</label>
						<div class="col-sm-10">
							<input type="text" id="title" name="title" value="{{ $input->title }}" class="form-control">
							@if ( $errors->has('title') )
								<span class="help-block">{{ $errors->first('title') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
						<label for="image" class="col-sm-2 control-label">{{ __('Resim') }}</label>
						<div class="col-sm-10">
							@if ( $input->image )
								<img style="margin-bottom: 10px;" width="250" src="{{ $post->imageUrl() }}">
							@endif
							<input type="file" id="image" name="image" class="form-control">
							@if ( $errors->has('image') )
								<span class="help-block">{{ $errors->first('image') }}</span>
							@else
								<span class="help-block">{{ __($input->image ? 'Resmi değiştirmek istemiyorsanız boş bırakın.' : 'İsteğe bağlı, sunucunun resmini yükleyebilirsiniz.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
						<label for="body" class="col-sm-2 control-label">{{ __('Ürün Hakkında') }}</label>
						<div class="col-sm-10">
							<textarea id="body" name="body" class="form-control text-editor" rows="2">{{ $input->body }}</textarea>
							@if ( $errors->has('body') )
								<span class="help-block">{{ $errors->first('body') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
						<label for="tags" class="col-sm-2 control-label">{{ __('Etiketler') }}</label>
						<div class="col-sm-10">
							<input type="text" id="tags" name="tags" value="{{ $input->tags }}" class="form-control">
							@if ( $errors->has('tags') )
								<span class="help-block">{{ $errors->first('tags') }}</span>
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
	<script src="{{ asset('admin-static/plugins/summernote/dist/summernote.min.js') }}"></script>
	<script>
		$(document).ready(function() {
		  $('.text-editor').summernote({
			height: 250,
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['picture', ['picture', 'video']],
			  ]
			});

		  	$('#tags').tagsInput({width:'auto'});
		});
	</script>
@stop