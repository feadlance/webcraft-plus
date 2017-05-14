@extends('layouts.master')

@section('title')
	{{ $user->nameOrUsername() }} - @yield('profile-title')
@stop

@section('canonical', route('profile.index', $user->username))

@section('content')
	<section class="hero cover hidden-xs" style="background-image: url({{ $user->cover() }});">
		<div class="hero-bg"></div>
		<div class="container relative">
			<div class="page-header">
				<div class="page-title">{!! $user->prefixAndName() !!}</div>	
				<div class="profile-avatar">
					<div class="thumbnail" data-toggle="tooltip" title="{{ $user->nameOrUsername() }}">
						<a href="{{ route('profile.index', $user->username) }}">
							<img src="{{ $user->avatar(160) }}">
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="profile-nav height-50 border-bottom-1 border-grey-300  hidden-xs">
		<div class="tab-select sticky">
			<div class="container">
				<ul class="nav nav-tabs" role="tablist">
					<li{{ menu('profile.index') }}><a href="{{ route('profile.index', $user->username) }}">{{ __('Anasayfa') }}</a></li>
					<li{{ menu('profile.products') }}><a href="{{ route('profile.products', $user->username) }}">{{ __('Ürünler') }}</a></li>
					@if ( auth()->user() && $user->id === auth()->user()->id )
						<li{{ menu('profile.settings') }}><a href="{{ route('profile.settings', $user->username) }}">{{ __('Ayarlar') }}</a></li>
					@endif
				</ul>
			</div>
		</div>
	</section>
	
	<section class="bg-grey-50 padding-top-60 padding-top-sm-30">
		<div class="container">
			<div class="row">
				@yield('profile-content')
			</div>
		</div>
	</section>
@stop