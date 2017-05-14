@extends('layouts.master')

@section('title', $forum->name)

@section('canonical', route('forum.threads', $forum->slug))

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
			'active' => true
		])
	@endcomponent
	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4 class="no-padding-top">
					{{ $forum->name }}
					<small>{{ $forum->description ? str_limit($forum->description, 70) : __('açıklaması çok boş.') }}</small>
				</h4>
				<div class="pull-right">
					@if ( $forum->closed() !== true )
						<a href="{{ route('forum.add', $forum->slug) }}" class="btn btn-primary btn-icon-left"><i class="fa fa-plus"></i> {{ __('Yeni Konu') }}</a>
					@else
						<div style="margin-top: 7px;">{{ __('Konu Kapatılmış.') }}</div>
					@endif
				</div>
			</div>
			
			@if ( $threads->count() > 0 )
				<div class="forum forum-thread">
					@foreach ( $threads as $thread )
						<div class="forum-group">
							<div class="forum-icon"><i class="fa fa-{{ $thread->closed() ? 'lock' : 'comment' }}"></i></div>
							<div class="forum-title">
								<h4><a href="{{ route('forum.thread', [$forum->slug, $thread->slug]) }}">{{ $thread->title }}</a></h4>
								<p>{{ $thread->user ? $thread->user->nameOrUsername() . ',' : null }} {{ $thread->created_at->diffForHumans() }}</p>
							</div>
							@if ( $thread->posts->count() > 0 )
								<?php $lastPost = $thread->posts->last(); ?>
								<div class="forum-activity">
									@if ( $lastPost->user )
										<a href="{{ route('profile.index', $lastPost->user->username) }}"><img src="{{ $lastPost->user->avatar(30) }}" alt="User Avatar"></a>
									@endif
									<div>
										@if ( $lastPost->user )
											<h4><a href="{{ route('profile.index', $lastPost->user->username) }}">{{ $lastPost->user->nameOrUsername() }}</a></h4>
										@else
											<h4>{{ __('Bilinmeyen Kullanıcı') }}</h4>
										@endif
										<span>{{ str_limit(strip_tags($lastPost->body), 20) }}</span>
									</div>
								</div>
								<div class="forum-meta">{{ __(':count mesaj', ['count' => $thread->posts->count()]) }}</div>
							@endif
							@if ( $thread->views_count )
								<div class="forum-meta">{{ __(':count görüntüleme', ['count' => $thread->views_count]) }}</div>
							@endif
						</div>
					@endforeach
				</div>

				{{ $threads->links('components.pagination') }}
			@else
				<div class="alert alert-warning text-center">
					{{ __('Bu foruma hiç konu açılmamış.') }}
				</div>
			@endif  
		</div>
	</section>
@stop

<?php $bg_gray = true ?>