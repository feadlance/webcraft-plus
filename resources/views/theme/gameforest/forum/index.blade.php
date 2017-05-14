@extends('layouts.master')

@section('title', __('Forum'))

@section('canonical', route('forum.index'))

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Forum'),
			'active' => true
		])
	@endcomponent
	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			@if ( $categories->count() > 0 )
				@foreach ( $categories as $category )
					<div class="headline">
						<h4 class="no-padding-top">
							{{ $category->name }}
							<small>{{ $category->description ? str_limit($category->description, 70) : __('açıklaması çok boş.') }}</small>
						</h4>
					</div>
					<div class="forum">
						@foreach ( $category->forums()->orderBy('order', 'asc')->get() as $forum )
							<div class="forum-group{{ $forum->closed() ? ' lock' : '' }}">
								@if ( $forum->closed() || $forum->icon )
									<div class="forum-icon"><i class="fa fa-{{ $forum->closed() ? 'lock' : $forum->icon }}"></i></div>
								@endif
								<div class="forum-title">
									<h4><a href="{{ route('forum.threads', $forum->slug) }}">{{ $forum->name }}</a></h4>
									<p>{{ $forum->description ? str_limit($forum->description, 70) : 'açıklaması boş.' }}</p>
								</div>
								@if ( $forum->threads->count() > 0 )
									<?php $lastThread = $forum->threads->last(); ?>

									<div class="forum-activity">
										@if ( $lastThread->user )
											<a href="{{ route('profile.index', $lastThread->user->username) }}"><img src="{{ $lastThread->user->avatar(30) }}" alt="User Avatar"></a>
										@endif
										<div>
											<h4><a href="{{ route('forum.thread', [$forum->slug, $lastThread->slug]) }}">{{ str_limit($lastThread->title, 22) }}</a></h4>
											<span>
												@if ( $lastThread->user )
													<a href="{{ route('profile.index', $lastThread->user->username) }}">{{ $lastThread->user->nameOrUsername() }}</a>,
												@endif
												{{ $lastThread->created_at->diffForHumans() }}
											</span>
										</div>
									</div>
									<div class="forum-meta">{{ __(':count konu', ['count' => $forum->threads->count()]) }}</div>
								@endif
							</div>
						@endforeach
					</div>
				@endforeach
			@else
				<div class="text-center margin-top-20">
					<h3 class="margin-bottom-10">{{ __('Forum') }}</h3>
					<p>{{ __('Bu forumda hiç konu başlığı yok.') }}</p>
				</div>

				<div class="tags text-center">
					<a href="{{ url()->previous() }}">{{ __('geri dön') }}</a>
				</div>
			@endif
		</div>
	</section>
@stop

<?php $bg_gray = true ?>