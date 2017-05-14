@extends('layouts.master')

@section('title', __('Blog'))

@section('canonical', route('blog.list', $category))

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => 'Blog',
			'active' => true
		])
	@endcomponent
	
	<section>
		<div class="container">
			@if ( $posts->count() > 0 )
				<div class="row sidebar">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 leftside">
						<div class="tags margin-bottom-20">
							<a{!! $category === null ? ' class="active"' : '' !!} href="{{ route('blog.list') }}">{{ __('Tüm Yazılar') }}</a>
							<a{!! $category === 'general' ? ' class="active"' : '' !!} href="{{ route('blog.list', 'general') }}">{{ __('Genel') }}</a>
							@foreach ( $servers as $server )
								<a{!! $category == $server->slug ? ' class="active"' : '' !!} href="{{ route('blog.list', $server->slug) }}">{{ $server->name }}</a>
							@endforeach
						</div>

						<h3 class="margin-bottom-20">{{ $title }}</h3>
						
						@foreach ( $posts as $post )
							<div class="post post-md">
								<div class="row">
									<div class="col-md-4">
										<div class="post-thumbnail">
											<a href="{{ route('blog.detail', $post->slug) }}"><img src="{{ $post->imageUrl('700x460') }}" alt="Thumbnail"></a>
										</div>
									</div>
									<div class="col-md-8">
										<div class="post-header">
											<div class="post-title">
												<h4><a href="{{ route('blog.detail', $post->slug) }}">{{ $post->title }}</a></h4>
												<ul class="post-meta">
													@if ( $post->user !== null )
														<li><a href="{{ route('profile.index', $post->user->username) }}"><i class="fa fa-user"></i> {{ $post->user->nameOrUserName() }}</a></li>
													@endif
													<li><i class="fa fa-calendar-o"></i> {{ $post->created_at->diffForHumans() }}</li>
													<li><i class="fa fa-comments"></i> {{ $post->comments->count() }}</li>
												</ul>
											</div>
										</div>
										<p>{{ str_limit(strip_tags($post->body), 350) }}</p>
									</div>
								</div>
							</div>
						@endforeach

						{{ $posts->links('components.pagination') }}
					</div>

					@include('layouts.sidebar')
				</div>
			@else
				<div class="text-center">
					<div class="margin-bottom-30">
						<h3 class="margin-bottom-10">{{ $title }}</h3>
						{{ __('Bu sorguya ait hiç post bulamadık.') }}
					</div>

					<div class="tags">
						<a href="{{ route('blog.list') }}">{{ __('Tüm Yazılar') }}</a>
						<a href="{{ route('blog.list', 'general') }}">{{ __('Genel') }}</a>
						@foreach ( $servers as $server )
							<a href="{{ route('blog.list', $server->slug) }}">{{ $server->name }}</a>
						@endforeach
					</div>
				</div>
			@endif
		</div>
	</section>
@stop