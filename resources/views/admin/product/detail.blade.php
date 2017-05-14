@extends('admin.layouts.master')

@section('title', $product->name)

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="page-title">{{ $product->name }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Ürünü Satın Alanlar') }}</div>
				</div>
				<div class="panel-body">
					@if ( $product->sales->count() > 0 )		
						@component('admin.components.inbox.parent')
							@foreach ( $product->sales as $sale )
								@include('admin.components.inbox.block', [
									'title' => $sale->user ? $sale->user->nameOrUsername() : __('Bilinmeyen Kullanıcı'),
									'description' => "{$sale->price()}",
									'date' => $sale->created_at->diffForHumans(),
									'image' => $sale->product->toImageUrl(),
									'image_radius' => false
								])
							@endforeach
						@endcomponent
					@else
						<p class="color-default">{{ __('Kimse bu üründen satın almamış.') }}</p>
					@endif
				</div>
			</div>
		</div>
		@if ( $product->sales->count() > 0 )
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="mini-stat clearfix bx-shadow bg-success">
			                <span class="mini-stat-icon"><i class="fa fa-try"></i></span>
			                <div class="mini-stat-info text-right">
			                    <span class="counter">₺{{ $thisMonthPrices }}</span>
			                    {{ __('Bu Ayki Satış') }}
			                </div>
			                <div class="tiles-progress">
			                    <div class="m-t-20">
			                        <h5 class="text-uppercase text-white m-0">{{ __('Toplam Kazanç') }} <span class="pull-right">₺{{ $allPrices }}</span></h5>
			                    </div>
			                </div>
			            </div>
					</div>
				</div>
			</div>
		@endif
	</div>
@stop