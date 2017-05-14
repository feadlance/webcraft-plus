@extends('layouts.master')

@section('title', __('Oyun Sıralaması'))

@section('canonical', route('hit.top100'))

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Hit'),
			'url' => '#'
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => 'Top 100',
			'active' => true
		])
	@endcomponent

	<section class="bg-grey-50 padding-bottom-60">
		<div class="container">
			<h3>{{ __('Sıralama') }}</h3>
			<p>{{ __(' Bu sıralama, oyuncuların tüm sunuculardaki istatistikleriyle oluşturulmuştur.') }}</p>

			<div class="alert alert-warning">
				{{ __('Bu sunucu, sıralama sistemini desteklememektedir.') }}
			</div>
		</div>
	</section>
@stop

<?php $bg_gray = true; ?>