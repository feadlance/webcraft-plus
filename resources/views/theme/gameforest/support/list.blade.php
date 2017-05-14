@extends('layouts.master')

@section('title', __('Destek Taleplerim'))

@section('canonical', route('support.list'))

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Destek Taleplerim'),
			'active' => true
		])
	@endcomponent
	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<div class="headline">
				<h4 class="no-padding-top">{{ __('Destek Taleplerim') }} <small>{{ __('Oluşturduğunuz destek taleplerine buradan göz atabilirsiniz.') }}</small></h4>
				<div class="pull-right">
					<a href="{{ route('support.add') }}" class="btn btn-primary btn-icon-left"><i class="fa fa-plus"></i> {{ __('Yeni Talep') }}</a>
				</div>
			</div>
			
			@if ( $supports->count() > 0 )
				<div class="forum">
					@foreach ( $supports as $support )
						<div class="forum-group{{ $support->closed_at !== null ? ' lock' : '' }}">
							<div class="forum-icon">
								<i class="fa fa-{{ $support->closed_at === null ? 'comment' : 'lock' }}"></i>
							</div>
							<div class="forum-title">
								<h4><a href="{{ route('support.view', $support->id) }}">{{ $support->title ?: 'Konu: ' . $support->subject() }}</a></h4>
								<p title="{{ strip_tags($support->lastBody()) }}" style="{{ $support->unViewedMessages(true)->count() > 0 ? 'color: #ef5757' : '' }}">
									{{ str_limit(strip_tags($support->lastBody()), 60) }}
								</p>
							</div>
							<div class="forum-meta">{{ __(':count mesaj', ['count' => $support->messages->count()]) }}</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="alert alert-warning text-center">
					{{ __('Henüz hiç talebiniz olmamış.') }}
				</div>
			@endif
		</div>
	</section>
@stop

<?php $bg_gray = true; ?>