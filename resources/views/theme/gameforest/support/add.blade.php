@extends('layouts.master')

@section('title', __('Yeni Destek Talebi'))

@section('canonical', route('support.add'))

@section('head')
	<link href="{{ _asset('plugins/summernote/summernote.css') }}" rel="stylesheet">
@stop

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Destek Taleplerim'),
			'url' => route('support.list')
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => __('Yeni Destek Talebi'),
			'active' => true
		])
	@endcomponent

	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4 class="no-padding-top">{{ __('Yeni Talep') }} <small>{{ __('Bir problem mi var? Yardımcı olmaya hazırız.') }}</small></h4>
				<div class="pull-right">
					<a href="{{ route('support.list') }}" class="btn btn-default btn-icon-left"><i class="fa fa-angle-left"></i> {{ __('Geri Dön') }}</a>
				</div>
			</div>
			
			<form action="{{ route('support.add') }}" method="post" class="form-label">
				{{ csrf_field() }}

				<div class="panel panel-default margin-bottom-30">
					<div class="panel-body">
						<div class="form-group row{{ $errors->has('server_id') ? ' has-error' : '' }}">
							<label for="server_id" class="col-md-2">{{ __('Sunucu') }}</label>
							<div class="col-md-10">
								<select class="form-control" id="server" name="server">
									<option value="0">Genel</option>
									@foreach ( $servers as $server )
										<option value="{{ $server->id }}">{{ $server->name }}</option>
									@endforeach
								</select>
								@if ( $errors->has('server') )
									<span class="help-block">{{ $errors->first('server') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('title') ? ' has-error' : '' }}">
							<label for="title" class="col-md-2">{{ __('Konu Başlığı') }}</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="title" name="title" placeholder="{{ __('Konu başlığı...') }}">
								@if ( $errors->has('title') )
									<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('type') ? ' has-error' : '' }}">
							<label for="type" class="col-md-2">{{ __('Problem nedir?') }}</label>
							<div class="col-md-10">
								<select class="form-control" id="type" name="type">
									@foreach ( $support_types as $key => $type )
										<option value="{{ $key }}">{{ $type }}</option>
									@endforeach
								</select>
								@if ( $errors->has('type') )
									<span class="help-block">{{ $errors->first('type') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('body') ? ' has-error' : '' }}">
							<label class="col-md-2">Mesajınız</label>
							<div class="col-md-10">
								<div class="forum-post no-margin no-shadow">
									<textarea name="body" class="text-editor"></textarea>
								</div>
								@if ( $errors->has('body') )
									<span class="help-block">{{ $errors->first('body') }}</span>
								@endif
							</div>
						</div>
					</div>
				</div>
				
				<div class="text-center">
					<button type="submit" class="btn btn-primary btn-lg btn-rounded btn-shadow">{{ __('Gönder') }}</button>
				</div>
			</form>
		</div>
	</section>
@stop

@section('scripts')
	<script src="{{ _asset('plugins/summernote/summernote.min.js') }}"></script>
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
		});
	</script>
@stop