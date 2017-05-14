@extends('layouts.master')

@section('title', __('Yeni Konu'))

@section('canonical', route('forum.add', $forum->slug))

@section('head')
	<link href="{{ _asset('plugins/summernote/summernote.css') }}" rel="stylesheet">
@stop

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Forum'),
			'url' => route('forum.index')
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => $forum->name,
			'url' => route('forum.threads', $forum->slug)
		])

		@include('components.breadcrumb.block', [
			'position' => 4,
			'name' => __('Yeni Konu'),
			'active' => true
		])
	@endcomponent

	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4 class="no-padding-top">{{ __('Yeni Konu') }} <small>{{ __('Lütfen yeni bir konu açmadan önce, başkasının açıp açmadığını kontrol edin.') }}</small></h4>
				<div class="pull-right">
					<a href="{{ route('forum.threads', $forum->slug) }}" class="btn btn-default btn-icon-left"><i class="fa fa-angle-left"></i> {{ __('Geri Dön') }}</a>
				</div>
			</div>
			
			<form action="{{ route('forum.add', $forum->slug) }}" method="post" class="form-label">
				{{ csrf_field() }}

				<div class="panel panel-default margin-bottom-30">
					<div class="panel-body">
						<div class="form-group row{{ $errors->has('title') ? ' has-error' : '' }}">
							<label for="title" class="control-label col-md-2">{{ __('Başlık') }}</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
								@if ( $errors->has('title') )
									<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>
						<div class="form-group row{{ $errors->has('body') ? ' has-error' : '' }}">
							<label class="control-label col-md-2">İçerik</label>
							<div class="col-md-10">
								<div class="forum-post no-margin no-shadow">
									<textarea name="body" class="text-editor">{{ old('body') }}</textarea>
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