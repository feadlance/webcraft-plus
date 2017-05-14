@extends('layouts.master')

@section('title', $thread->title)

@section('canonical', route('forum.thread', [$forum->slug, $thread->slug]))

@section('head')
	<link href="{{ _asset('plugins/summernote/summernote.css') }}" rel="stylesheet">
	<style>
		.forum-post .forum-user div span {
			color: inherit;
			display: inline;
		}
	</style>
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
			'name' => $thread->title,
			'active' => true
		])
	@endcomponent
	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4><i class="fa fa-comments"></i> {{ $thread->title }}</h4>
			</div>
			
			@foreach ( $posts as $post )
				<div class="forum-post">
					<div class="forum-panel">
						<div class="forum-user">
							@if ( $post->user )
								<a href="{{ route('profile.index', $post->user->username) }}" class="avatar"><img src="{{ $post->user->avatar(60) }}" alt="User Avatar"></a>
								<div>
									<a class="span-inline" href="{{ route('profile.index', $post->user->username) }}">{!! $post->user->prefixAndName() !!}</a>
									<span>{{ __('Üyelik Tarihi') }}</span>
									<span class="date">{{ $post->user->created_at->diffForHumans() }}</span>
								</div>
							@else
								{{ __('Bilinmeyen Kullanıcı') }}
							@endif
						</div>
						<div class="forum-body">
							<p style="margin-bottom: 5px; font-size: 13px;">{{ $post->created_at->diffForHumans() }}</p>
							{!! allow_html_tags($post->body) !!}
						</div>
					</div>
				</div>
			@endforeach
			
			{{ $posts->links('components.pagination') }}
			
			<div class="headline">
				<h4><i class="fa fa-comment"></i> {{ __('Bir yanıt yazın') }}</h4>
			</div>
			@if ( $forum->closed() !== true )
				@if ( auth()->check() === true )
					<form action="{{ route('forum.reply', [$forum->slug, $thread->slug]) }}" method="post">
						{{ csrf_field() }}

						<div class="forum-post">
							<textarea name="body" id="text-editor"></textarea>
						</div>
						<button type="submit" class="btn btn-primary btn-rounded btn-lg btn-shadow pull-right">{{ __('Gönder') }}</button>
					</form>
				@else
					<p>{!! __('Yorum yapabilmek için <a href="#signin" data-toggle="modal"><i class="fa fa-sign-in"></i> giriş</a> yapmalısınız.') !!}</p>
				@endif
			@else
				<p>{!! __('Forumun bu kısmı kapatıldığı için konularına yanıt veremezsiniz.') !!}</p>
			@endif
		</div>
	</section>
@stop

@section('scripts')
	<script src="{{ _asset('plugins/summernote/summernote.min.js') }}"></script>
	<script>
		$(document).ready(function() {
		  $('#text-editor').summernote({
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