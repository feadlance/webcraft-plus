@extends('layouts.master')

@section('title', $post->title)

@section('canonical', route('blog.detail', $post->slug))

@section('head')
	<style>
		.deleteCommentButton {
			width: 25px;
			height: 25px;
		}
	</style>
@stop

@section('content')
	<!--<section class="hero hero-parallax height-450 parallax" style="background-image: url({{ $post->imageUrl('1920x800') }});"></section>-->

	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Blog'),
			'url' => route('blog.list')
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => $post->title,
			'active' => true
		])
	@endcomponent

	<section class="padding-top-50 padding-bottom-50">
	    <div class="container">
	        <div class="row sidebar">
	            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 leftside">
	                <div class="post post-single">
	                    <div class="post-header post-author">
	                        @if ( $post->user !== null )
	                        	<a href="{{ route('profile.index', $post->user->username) }}" class="author" data-toggle="tooltip" title="{{ $post->user->nameOrUsername() }}"><img src="{{ $post->user->avatar(56) }}" alt="User Avatar" /></a>
	                        @endif
	                        <div class="post-title"{!! $post->user === null ? ' style="padding-left: 0;"' : '' !!}>
	                            <h3>{{ $post->title }}</h3>
	                            <ul class="post-meta">
	                                @if ( $post->user !== null )
	                                	<li><a href="{{ route('profile.index', $post->user->username) }}"><i class="fa fa-user"></i> {!! $post->user->prefixAndName() !!}</a></li>
	                                @endif
	                                <li><i class="fa fa-calendar-o"></i> {{ $post->created_at->diffForHumans() }}</li>
	                                <li><i class="fa fa-comments"></i> {{ $post->comments->count() }}</li>
	                            </ul>
	                        </div>
	                    </div>

	                    {!! allow_html_tags($post->body) !!}

		                <div class="row margin-top-40">
		                	<div class="col-md-8">
			                	<div class="tags margin-bottom-10">
		                        	@foreach ( $post->tags as $tag )
										<a href="#">{{ $tag['name'] }}</a>
		                        	@endforeach
		                        </div>
		                	</div>
	                        <div class="col-md-4 hidden-xs hidden-sm">
                        		<ul id="social-share" class="share">
                        	        <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-social-icon btn-facebook" data-toggle="tooltip" title="{{ __("Facebook'ta paylaş") }}"><i class="fa fa-facebook"></i></a></li>
                        	        <li><a target="_blank" href="https://twitter.com/intent/tweet?text={{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-social-icon btn-twitter" data-toggle="tooltip" title="{{ __("Twitter'da paylaş") }}"><i class="fa fa-twitter"></i></a></li>
                        	        <li><a target="_blank" href="https://plus.google.com/share?url={{ route('blog.detail', $post->slug) }}" class="btn btn-sm btn-social-icon btn-google-plus" data-toggle="tooltip" title="{{ __("Google+'da paylaş") }}"><i class="fa fa-google-plus"></i></a></li>
                        	    </ul>
	                        </div>
		                </div>
	                </div>

	                <div id="comments" class="comments">
	                    <h4 class="page-header"><i class="fa fa-comment-o"></i> {{ __('Yorumlar (:count)', ['count' => $post->comments->count()]) }}</h4>
	                    
	                    @foreach ( $post->comments()->latest()->get() as $comment )
							<div id="comment-{{ $comment->id }}" class="media">
		                        <a class="media-left" href="{{ route('profile.index', $comment->user->username) }}">
		                            <img src="{{ $comment->user->avatar() }}" alt="User Avatar" />
		                        </a>
		                        <div class="media-body">
		                            <div style="border: 0;" class="media-content">
		                                <a href="{{ route('profile.index', $comment->user->username) }}" class="media-heading">{!! $comment->user->prefixAndName() !!}</a>
		                                <span class="date">{{ $comment->created_at->diffForHumans() }}</span>
		                                <p>{{ $comment->body }}</p>
		                            </div>
		                        </div>
		                       	
			                        <div class="media-right">
			                        	<form action="{{ route('comment.delete', $comment->id) }}" method="post">
			                        		{{ csrf_field() }}

			                        		<input type="hidden" name="_method" value="DELETE">

			                        		<button type="button" class="btn btn-danger btn-circle deleteCommentButton"><i class="fa fa-trash"></i></button>
			                        	</form>
			                        </div>
			                   	
		                    </div>
	                    @endforeach

	                    <hr>

	                    <div class="comment-form">
	                        <h4 class="page-header">{{ __('Bir yorum yazın') }}</h4>
		                    @if ( auth()->check() === true )
		                    	<form action="{{ route('blog.comment', $post->id) }}" method="post">
		                        	{{ csrf_field() }}

		                            <div class="form-group">
		                                <textarea class="form-control" name="body" rows="6" placeholder="{{ __('Yorumunuz') }}"></textarea>
		                            </div>
		                            <button type="submit" class="btn btn-primary btn-rounded btn-shadow pull-right">{{ __('Gönder') }}</button>
		                        </form>
		                    @else
								<p>{!! __('Yorum yapabilmek için <a href="#signin" data-toggle="modal"><i class="fa fa-sign-in"></i> giriş</a> yapmalısınız.') !!}</p>
		                    @endif
	                    </div>
	                </div>
	            </div>

	            @include('layouts.sidebar')
	        </div>
	    </div>
	</section>
@stop

@section('scripts')
	<script>
		$('.deleteCommentButton').on('click', function () {
			swalConfirm().then(() => {
				$(this).parent().submit();
			});
		});
	</script>
@stop