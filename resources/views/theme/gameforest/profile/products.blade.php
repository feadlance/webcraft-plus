@extends('profile.master')

@section('profile-title', __('Ürünler'))

@section('profile-content')
	@include('profile.navigation-left')
	
	<div class="col-md-9 col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Satın Alınan Ürünler') }}</div>
			</div>
			<div class="panel-body">
				@if ( $sales->count() > 0 )
					<table class="table table-striped">
						<thead>
							<tr>
								<th>{{ __('Ürün') }}</th>
								<th>{{ __('Fiyat') }}</th>
								<th>{{ __('Bitiş Tarihi') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ( $sales as $sale )
								<tr>
									<td>
										@if ( $sale->product )
											<img style="margin-right: 10px;" src="{{ $sale->product->toImageUrl() }}" alt="Product Icon">
											{{ $sale->product->name }}
										@else
											{{ __('Silinmiş Ürün') }}
										@endif
									</td>
									<td>{{ $sale->price() }}</td>
									<td>
										@if ( $sale->ended_at && Carbon\Carbon::now() > $sale->ended_at )
											<span class="text-danger">{{ __('Süresi Bitti') }}</span>
										@elseif ( $sale->ended_at )
											{{ $sale->ended_at->format('d.m.Y') }}
											<small>({{ $sale->ended_at->diffForHumans() }})</small>
										@else
											<span class="text-success">{{ __('Sınırsız') }}</span>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@else
					{{ __(':username, hiç bir şey satın almamış.', ['username' => $user->nameOrUsername()]) }}
				@endif
			</div>
		</div>
	</div>
@stop