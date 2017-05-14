@extends('admin.layouts.master')

@section('title', __('Ürünler'))

@section('head')
	<style>
		#list-product tbody tr td {
			vertical-align: middle;
		}

		.d-none {
			display: none;
		}
	</style>
@stop

@section('content')
	<div class="col-md-{{ $server === null ? '10 col-md-offset-1' : '4' }}">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Sunucu Seçimi') }}</div>
			</div>
			<div class="panel-body">
				@if ( $servers->count() > 0 )
					<table class="table table-hover">
						<thead>
							<tr>
								<th>{{ __('Sunucu') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ( $servers as $value )
								<tr class="link" data-href="{{ route('admin.product.list', ['server' => $value->id]) }}">
									<td class="clickable{{ $server !== null && $server->id === $value->id ? ' active' : '' }}">{{ $value->name }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					<span class="help-block">
						{{ __('Hiç sunucu eklenmemiş,') }}
						<a href="{{ route('admin.server.add') }}">{{ __('yeni bir tane ekleyin.') }}</a>
					</span>
				@endif
			</div>
		</div>
	</div>
	@if ( $server !== null )
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Ürünler') }}</div>
				</div>
				<div id="list-product" class="panel-body">
					<table class="table table-hover m-b-0">
						<thead>
							<tr>
								<th>{{ __('İkon') }}</th>
								<th>{{ __('Ürün') }}</th>
								<th>{{ __('Fiyat') }}</th>
								<th>{{ __('Kayıt Tarihi') }}</th>
								<th>{{ __('İşlemler') }}</th>
							</tr>
						</thead>
						<tbody>
							@if ( count($products) > 0 )
								@foreach ( $products as $product )
									<tr id="product-{{ $product->id }}" class="link" data-href="{{ route('admin.product.detail', $product->id) }}">
										<td class="clickable">
											<img src="{{ $product->toImageUrl() }}">
										</td>
										<td class="clickable">{{ $product->name }}</td>
										<td class="clickable">{{ $product->price() }}</td>
										<td class="clickable">{{ $product->created_at->diffForHumans() }}</td>
										<td>
											<a href="{{ route('admin.product.add', ['id' => $product->id]) }}" class="btn btn-primary waves-effect waves-light">{{ __('Güncelle') }}</a>
											<button @click="setProduct({{ $product->id }}, '0')" class="btn btn-danger set-false{{ $product->active !== true ? ' d-none' : '' }}">{{ __('Sil') }}</button>
										</td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="5">{{ __('Hiç kayıtlı ürün yok.') }}</td></tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	@endif
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#list-product',

			methods: {
				setProduct(id, active) {
					swalConfirm().then(() => {
						let set_url = '{{ route('admin.product.set', [':id', ':active']) }}';

						this.$http.post(set_url.replace(':id', id).replace(':active', active)).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#product-' + id).remove();

							swalSuccess('{{ __('Sunucu başarıyla silindi') }}');
						});
					});
				}
			}
		});
	</script>
@stop