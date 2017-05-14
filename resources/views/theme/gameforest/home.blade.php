@extends('layouts.master')

@section('canonical', route('home'))

@section('content')
	<div id="full-carousel" class="ken-burns carousel slide full-carousel carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#full-carousel" data-slide-to="0" class="active"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active inactiveUntilOnLoad">
                <img src="{{ slider_image() }}" alt="Slider Image">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 data-animation="animated animate1 bounceInDown">{{ __('Burası Çok Farklı') }}</h1>
                        <p data-animation="animated animate7 fadeInUp">{{ __('Kalitemiz sizce de yeterince açık değil mi?') }}</p>
                        <a href="{{ url('/register') }}" class="btn btn-primary btn-lg btn-rounded" data-animation="animated animate10 fadeInDown">{{ __('Hemen Kayıt Ol') }}</a>
                    </div>
                </div>
            </div>

            <a class="left carousel-control" href="#full-carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#full-carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    @if ( $posts->count() > 0 )
        <section class="bg-grey-50 border-bottom-1 border-grey-200 relative">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="title outline">
                            <h4><i class="fa fa-rss"></i> {{ __('Blog') }}</h4>
                            <p>{{ __('Sunucumuza gelen yenilikleri, önemli güncellemeleri ve daha bir çoğunu bloğumuzdan takip edebilirsiniz.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach( $posts as $post )
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="card card-hover">
                                <div class="card-img">
                                    <a href="{{ route('blog.detail', $post->slug) }}">
                                        <img src="{{ $post->imageUrl('700x460') }}" alt="Post Thumbnail">
                                        <div class="category"><span class="label label-{{ $post->color() }}">{{ $post->category() }}</span></div>
                                    </a>
                                </div>
                                <div class="caption">
                                    <h3 class="card-title"><a href="{{ route('blog.detail', $post->slug) }}">{{ $post->title }}</a></h3>
                                    <ul>
                                        <li>{{ $post->created_at->diffForHumans() }}</li>
                                    </ul>
                                    <p>{{ str_limit(strip_tags($post->body), 200) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center"><a href="{{ route('blog.list') }}" class="btn btn-primary btn-lg btn-shadow btn-rounded btn-icon-right margin-top-10 margin-bottom-20">{{ __('Daha Fazla') }} <i class="fa fa-angle-right"></i></a></div>
            </div>
        </section>
    @endif

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="title outline">
                        <h4><i class="fa fa-star"></i> {{ __('Oyun Türleri') }}</h4>
                        <p>{{ __('Sizlere sunduğumuz oyunların tamamına buradan göz atabilirsiniz.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row slider">
                <div class="owl-carousel">
	            	@foreach ( $servers as $server )
						<div class="card card-list">
	                        <div class="card-img">
	                        	<img src="{{ $server->imageUrl('270x300') }}" alt="Blog Thumbnail">
	                            <span class="label label-{{ $server->onlineStatusColor() }}">{{ $server->online_users()->count() }} / {{ $server->slot }}</span>
	                        </div>
	                        <div class="caption">
	                            <h4 class="card-title"><a href="{{ route('blog.list', $server->slug) }}">{{ $server->name }}</a></h4>
	                            <p>{{ str_limit($server->description, 50) }}</p>
	                        </div>
	                    </div>
	            	@endforeach
                </div>
                <a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
                <a href="#" class="next"><i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </section>

    @if ( settings('lebby.trailer') )
		<div class="background-image margin-top-40" style="background-image: url(//img.youtube.com/vi/{{ settings('lebby.trailer') }}/maxresdefault.jpg);">
	        <span class="background-overlay"></span>
	        <div class="container">
	            <div class="embed-responsive embed-responsive-16by9">
	                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ settings('lebby.trailer') }}?rel=0&amp;showinfo=0" allowfullscreen></iframe>
	            </div>
	        </div>
	    </div>
    @endif

    @if ( auth()->check() !== true )
        <section class="bg-success subtitle-lg">
            <div class="container">
                <h2>{{ __('Oynamak ister misin? Hemen kayıt ol.') }}</h2>
                <a href="{{ url('/register') }}" class="btn btn-white btn-outline"><i class="fa fa-user-plus margin-right-10"></i>{{ __('Devam et') }}</a>
            </div>
        </section>
    @endif
@stop

@section('scripts')
    <script src="{{ _asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            var owl = $(".owl-carousel");

            owl.owlCarousel({
                items: 4, //4 items above 1000px browser width
                itemsDesktop: [1000, 3], //3 items between 1000px and 0
                itemsTablet: [600, 1], //1 items between 600 and 0
                itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
            });

            $(".next").click(function() {
                owl.trigger('owl.next');
                return false;
            })
            $(".prev").click(function() {
                owl.trigger('owl.prev');
                return false;
            })
        })(jQuery);
    </script>
@stop