@extends('layouts.master')

@section('canonical', route('home'))

@section('head')
    <style>
        #online-users-top li {
            margin-right: 5px;
        }
    </style>
@stop

@section('content')
    <div id="home-auth">
        @if ( $topPosts->count() > 3 )
        	<div class="owl-carousel">
                @foreach ( $topPosts as $post )
                    <div class="post-carousel">
                        <a href="{{ route('blog.detail', $post->slug) }}" class="link">
                            <img src="{{ $post->imageUrl('700x460') }}" alt="Blog Post Image">
                            <div class="overlay">
                                <div class="caption">
                                    <span class="label label-{{ $post->color() }}">{{ $post->category() }}</span>
                                    <div class="comments"><i class="fa fa-eye margin-right-10"></i> <span>{{ $post->views_count }}</span></div>
                                    <div class="post-title">
                                        <h4>{{ $post->title }}</h4>
                                    </div>
                                    <p>{{ str_limit(strip_tags($post->body), 100) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        <section class="bg-grey-50 border-bottom-1 border-grey-200 padding-top-15 padding-bottom-20">
            <div class="container">
                <div class="row">
                    <div class="padding-top-10 col-sm-6">
                        <h4>{{ __('Sunucu Bilgileri') }}</h4>
                        <p>{{ __('Aşağıda ki bilgiler bir gün hayatını kurtarabilemez, ama eğlendirir.') }}</p>

                        @if ( $onlineUserCount > 0 )
                            <span class="label label-success">{{ __(':users çevrimiçi', ['users' => $onlineUserCount]) }}</span>
                        @endif
                        @if ( settings('lebby.server.ip') )
                            <span class="label label-info">
                                @if ( settings('lebby.minecraftsunucular') )
                                    <a style="color: #fff;" target="_blank" href="http://www.minecraftsunucular.com/server/{{ settings('lebby.minecraftsunucular') }}">{{ settings('lebby.server.ip') }}</a>
                                @else
                                    {{ settings('lebby.server.ip') }}
                                @endif
                            </span>
                        @else
                            <span class="label label-danger">
                                {{ __('Sunucu adresi yok') }}

                                @if ( auth()->user() && auth()->user()->isAdmin )
                                    <a style="color: white;" href="{{ route('admin.settings.general') }}">{{ __('Genel Ayarlar\'dan ekleyin') }}</a>
                                @endif
                            </span>
                        @endif
                        @if ( settings('lebby.server.versions') )
                            <span class="label label-warning">{{ settings('lebby.server.versions') }}</span>
                        @endif
                        @if ( settings('lebby.server.teamspeak') )
                            <span class="label label-primary">{{ settings('lebby.server.teamspeak') }}</span>
                        @endif
                    </div>
                    <div class="padding-top-10 col-sm-6">
                        <h4>{{ __('Ban Sorgula') }}</h4>
                        <p>{{ __('Ban sorgulamak mı istiyorsun? Alt tarafa kullanıcı adını yazabilirsin.') }}</p>
                        
                        <div class="input-group">
                            <input v-model="ban.username" type="text" class="form-control" />
                            <div class="input-group-btn">
                                <button @click="checkBan()" class="btn btn-primary btn-lg">{{ __('Sorgula') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-top-40 padding-bottom-40">
            <div class="container">
                <div class="row sidebar">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 leftside">
                        @if ( $posts->count() > 0 )
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="headline">
                                        <h4>{{ __('Blog') }}</h4>
                                    </div>
                                </div>
                            </div>
                            @foreach ( $posts as $post )
                                <div class="post post-md">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="post-thumbnail">
                                                <a href="{{ route('blog.detail', $post->slug) }}"><img src="{{ $post->imageUrl('700x460') }}" alt="Blog Post Image"></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="post-header">
                                                <div class="post-title">
                                                    <h4><a href="{{ route('blog.detail', $post->slug) }}">{{ $post->title }}</a></h4>
                                                    <ul class="post-meta">
                                                        @if ( $post->user !== null )
                                                            <li><a href="{{ route('profile.index', $post->user->username) }}"><i class="fa fa-user"></i> {!! $post->user->prefixAndName() !!}</a></li>
                                                        @endif
                                                        <li><i class="fa fa-calendar-o"></i> {{ $post->created_at->diffForHumans() }}</li>
                                                        <li><i class="fa fa-comments"></i> {{ $post->comments->count() }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p>{{ str_limit(strip_tags($post->body), 150) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center"><a href="{{ route('blog.list') }}" class="btn btn-primary btn-lg btn-shadow btn-rounded btn-icon-right">{{ __('Daha Fazlası') }}</a></div>
                        @else
                            <p>{{ __('Hiç blog yazısı yok.') }}</p>
                        @endif
                    </div>
                    @include('layouts.sidebar')
                </div>
            </div>
        </section>
    </div>
@stop

@section('scripts')
    <script src="{{ _asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script>
        new Vue({
            el: '#home-auth',

            data: {
                ban: {
                    username: '{{ auth()->user() ? auth()->user()->username : null }}'
                }
            },

            methods: {
                checkBan() {
                    this.$http.post('{{ route('check_ban') }}', { username: this.ban.username }).then((response) => {
                        if ( response.body.status == false ) {
                            swalError(response.body.status_message, '{{ __('Durum Kötü') }}');
                            return false;
                        }

                        swalSuccess(response.body.status_message, '{{ __('Yaşasın!') }}');
                    });
                }
            }
        });

        $(function () {
            $(".owl-carousel").owlCarousel({
                autoPlay: true,
                items : 4,
                itemsDesktop : [1600,3],
                itemsTablet: [940,1],
                itemsMobile : false
            });
        });
    </script>
@stop