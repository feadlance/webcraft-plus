@extends('layouts.master')

@section('title', $support->title)

@section('canonical', route('support.view', $support->id))

@section('head')
	<link href="{{ _asset('plugins/summernote/summernote.css') }}" rel="stylesheet">

	<style>
		.forum-body__info {
			margin-bottom: 10px !important;
			padding-bottom: 5px;
			font-size: 13px;
			border-bottom: 1px solid rgba(0, 0, 0, .07);
		}
	</style>
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
			'name' => $support->title,
			'active' => true
		])
	@endcomponent
	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4>{{ $support->title }} <small>{{ $support->category() }}, {{ $support->subject() }}</small></h4>
				<div class="pull-right" style="margin-top: 5px;">
					<a href="{{ route('support.list') }}" class="btn btn-default btn-icon-left"><i class="fa fa-angle-left"></i> {{ __('Geri Dön') }}</a>
					@if ( $support->closed_at === null )
						<form style="display: inline-block;" action="{{ route('support.close', $support->id) }}" method="post">
							{{ csrf_field() }}
							<button type="submit" class="btn btn-primary btn-icon-left"><i class="fa fa-lock"></i> {{ __('Talebi Kapat') }}</button>
						</form>
					@else
						<span class="color-default" style="margin-left: 10px; display: inline-block;">
							{{ __('Talep Kapatıldı.') }}
						</span>
					@endif
				</div>
			</div>
			
			@foreach ( $support->messages as $message )
				<div class="forum-post">
					<div class="forum-panel">
						<div class="forum-user">
							<a href="{{ route('profile.index', $message->user->username) }}" class="avatar"><img src="{{ $message->user->avatar(60) }}" alt="User Avatar"></a>
							<div>
								<a href="{{ route('profile.index', $message->user->username) }}">{{ $message->user->nameOrUsername() }}</a>
								<span>{{ __('Üyelik Tarihi') }}</span>
								<span class="date">{{ $message->user->created_at->diffForHumans() }}</span>
							</div>
						</div>
						<div class="forum-body">
							<p class="forum-body__info">
								@if ( $message->admin )
									<span style="color: #2776dc;">{{ __('Temsilci') }}</span>,
								@else
									<span>{{ auth()->user()->id === $message->user->id ? __('Ben') : __('Oyuncu') }}</span>,
								@endif
								{{ $message->created_at->diffForHumans() }}
							</p>
							{!! allow_html_tags($message->body) !!}
						</div>
					</div>
				</div>
			@endforeach
			
			@if ( $support->closed_at === null )
				<form action="{{ route('support.reply', $support->id) }}" method="post">
					{{ csrf_field() }}

					<div class="forum-post">
						<textarea name="body" id="body" class="text-editor"></textarea>
					</div>
					<button type="submit" class="btn btn-primary btn-rounded btn-lg btn-shadow pull-right">{{ __('Yanıtla') }}</button>
				</form>
			@endif
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

<?php $bg_gray = true; ?>