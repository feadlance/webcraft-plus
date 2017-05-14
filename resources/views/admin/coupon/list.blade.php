@extends('admin.layouts.master')

@section('title', __('Kuponlar'))

@section('head')
	<style>
		#list-coupon tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Kuponlar') }}</div>
			</div>
			<div id="list-coupon" class="panel-body">
				<table class="table table-hover m-b-0">
					<thead>
						<tr>
							<th>{{ __('Kupon Kodu') }}</th>
							<th>{{ __('Hediye Tutarı') }}</th>
							<th>{{ __('Kalan Adet') }}</th>
							<th>{{ __('İşlemler') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( $coupons->count() > 0 )
							@foreach ( $coupons as $coupon )
								<tr id="coupon-{{ $coupon->id }}" class="link" data-href="{{ route('admin.coupon.detail', $coupon->id) }}">
									<td class="clickable">{{ $coupon->code }}</td>
									<td class="clickable">{{ $coupon->price() }}</td>
									<td class="clickable">{{ $coupon->piece }}</td>
									<td>
										<button @click="deleteCoupon({{ $coupon->id }})" class="btn btn-danger">{{ __('Sil') }}</button>
									</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="5">{{ __('Hiç kayıtlı kupon yok.') }}</td></tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#list-coupon',

			methods: {
				deleteCoupon(id) {
					let delete_url = '{{ route('admin.coupon.delete', [':id']) }}';

					this.$http.post(delete_url.replace(':id', id)).then((response) => {
						if ( response.body.status == false ) {
							swalError(response.body.status_message);
							return false;
						}

						$('#coupon-' + id).remove();
					});
				}
			}
		});
	</script>
@stop