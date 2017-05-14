@extends('admin.layouts.master')

@section('title', __('Yönetim Paneli'))

@section('head')
	<style>
		.statistic > div {
			text-align: center;
		}

		.statistic > .left {
			border-right: 1px solid rgba(0, 0, 0, .07);
		}

		.statistic > div > .price {
			display: block;
			font-size: 50px;
			font-weight: bold;
		}

		.statistic .col-md-6 small {
			font-weight: normal;
			font-size: 33px !important;
		}

		.statistic > div > .text {
			text-transform: uppercase;
			margin-top: 5px;
			display: block;
		}
	</style>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="page-title">{{ __('Özet') }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-border panel-warning">
						<div class="panel-heading">
							<div class="panel-title">
								{{ __('Son Destek Talepleri') }}
								<a data-toggle="tooltip" title="{{ __('Tüm Destek Talepleri') }}" href="{{ route('admin.support.list') }}">
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="panel-body">
							@if ( $lastSupports->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $lastSupports as $support )
										@include('admin.components.inbox.block', [
											'title' => $support->title,
											'url' => route('admin.support.reply', $support->id),
											'description' => $support->category() . ' / ' . $support->subject(),
											'date' => $support->created_at->diffForHumans(),
											'image' => $support->user->avatar(40),
											'image_radius' => true
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">{{ __('Henüz hiç destek talebi oluşturulmamış.') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-border">
						<div class="panel-heading">
							<div class="panel-title">{{ __('Son Yorumlar') }}</div>
						</div>
						<div class="panel-body">
							@if ( $lastComments->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $lastComments as $comment )
										@include('admin.components.inbox.block', [
											'title' => str_limit($comment->body, 100),
											'url' => route('blog.detail', "{$comment->commentable->slug}#comment-{$comment->commentable->id}"),
											'description' => $comment->commentable->title,
											'date' => $comment->created_at->diffForHumans(),
											'image' => $comment->user->avatar(40),
											'image_radius' => true
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">
									{{ __('Hiç yorum yok.') }}
								</span>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-border panel-primary">
						<div class="panel-heading">
							<div class="panel-title">
								{{ __('Son Kayıt Olanlar') }}
								<a data-toggle="tooltip" title="{{ __('Tüm Oyuncular') }}" href="{{ route('admin.user.list') }}">
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="panel-body">
							@if ( $lastUsers->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $lastUsers as $user )
										@include('admin.components.inbox.block', [
											'title' => $user->nameOrUsername(),
											'url' => route('admin.user.detail', $user->username),
											'description' => $user->is_online() ? ($user->server() === null && $user->statistic() === null ? __('Şuan çevrimiçi') : __('Şuan :name sunucusunda oynuyor', ['name' => $user->server() ? $user->server()->name : $user->statistic()->server])) : __('Oyunda değil'),
											'date' => $user->created_at->diffForHumans(),
											'image' => $user->avatar(40),
											'image_radius' => true
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">{{ __('Kayıtlı hiç oyuncu yok.') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-border panel-info">
						<div class="panel-heading">
							<div class="panel-title">
								{{ __('Çevrimiçi Oyuncular') }}
								<a data-toggle="tooltip" title="{{ __('Tüm Çevrimiçi Oyuncular') }}" href="{{ route('admin.user.list', 'online') }}">
									<i class="fa fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
						<div class="panel-body">
							@if ( $onlineUsers->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $onlineUsers as $user )
										@include('admin.components.inbox.block', [
											'title' => $user->nameOrUsername(),
											'url' => route('admin.user.detail', $user->username),
											'description' => $user->statistic() === null && $user->server() === null ? __('Şuan çevrimiçi') : __(':name sunucusunda', ['name' => $user->server() ? $user->server()->name : $user->statistic()->server]),
											'date' => null,
											'image' => $user->avatar(40),
											'image_radius' => true
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">
									@if ( settings('lebby.minecraftsunucular') )
										{{ __('Hiç çevrimiçi oyuncu yok.') }}
									@else
										{!! __('Çevrimiçi oyuncu yok, görünüşe göre reklama ihtiyacın var, dilersen <a target="_blank" href="http://www.minecraftsunucular.com">MinecraftSunucular.com</a> adresinde sunucunu paylaşabilirsin.') !!}
									@endif
								</span>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-border panel-success">
						<div class="panel-heading">
							<div class="panel-title">
								{{ __('Toplam Kazanç') }}
								<i style="margin-left: 3px; color: #525050;" data-toggle="tooltip" title="{{ __('Kazançlar, oyuncuların yüklediği kredilerin toplamıdır. Yani net kazanç değildir, ödeme yapılan şirket tarafından vergi kesintisi olabilir.') }}" class="fa fa-info-circle"></i>
							</div>
						</div>
						<div class="panel-body">
							<div class="statistic row">
								<div class="left col-md-6">
									<span class="price"><small>₺</small>{{ $thisMonthPrice }}</span>
									<span class="text">{{ __('Bu Ay') }}</span>
								</div>
								<div class="right col-md-6">
									<span class="price"><small>₺</small>{{ $lastMonthPrice }}</span>
									<span class="text">{{ __('Geçen Ay') }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-border panel-success">
						<div class="panel-heading">
							<div class="panel-title">{{ __('Son Alınan Krediler') }}</div>
						</div>
						<div class="panel-body">
							@if ( $lastPaymentPayloads->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $lastPaymentPayloads as $payload )
										@include('admin.components.inbox.block', [
											'title' => $payload->user->nameOrUsername(),
											'description' => $payload->money(),
											'date' => $payload->created_at->diffForHumans(),
											'image' => $payload->user->avatar(40),
											'image_radius' => true
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">
									{{ __('Hiç kredi alınmamış.') }}
								</span>
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-border panel-success">
						<div class="panel-heading">
							<div class="panel-title">{{ __('Son Satılan Ürünler') }}</div>
						</div>
						<div class="panel-body">
							@if ( $lastSales->count() > 0 )
								@component('admin.components.inbox.parent')
									@foreach ( $lastSales as $sale )
										@include('admin.components.inbox.block', [
											'title' => $sale->product ? $sale->product->name : __('Ürün'),
											'url' => $sale->product ? route('admin.product.detail', $sale->product->id) : null,
											'description' => ($sale->product && $sale->product->server ? $sale->product->server->name . ' / ' : null) . $sale->user->nameOrUsername(),
											'date' => $sale->created_at->diffForHumans(),
											'image' => $sale->product ? $sale->product->toImageUrl() : null,
											'image_radius' => false
										])
									@endforeach
								@endcomponent
							@else
								<span class="help-block m-b-0">
									{{ __('Hiç satış olmamış.') }}
								</span>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop