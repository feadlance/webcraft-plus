@extends('admin.layouts.master')

@section('title', __('Kuponu Kullananlar'))

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="alert alert-warning">
				{{ __('Kupon Kodu:') }}
				<strong>{{ $coupon->code }}</strong>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">
						{{ __('Kuponu Kullanan Oyuncular') }}
						<small>({{ $payloads->count() }})</small>
					</div>
				</div>
				<div class="panel-body">
					<table class="table table-hover m-b-0">
						<thead>
							<tr>
								<th>{{ __('Oyuncu') }}</th>
								<th>{{ __('Kullanım Tarihi') }}</th>
							</tr>
						</thead>
						<tbody>
							@if ( $payloads->count() > 0 )
								@foreach ( $payloads as $payload )
									<tr>
										<td>
											<img style="margin-right: 10px;" src="{{ $payload->user->avatar(35) }}" alt="User Avatar">
											{{ $payload->user->nameOrUsername() }}
										</td>
										<td style="vertical-align: middle;">{{ $payload->created_at->diffForHumans() }}</td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="2">{{ __('Kimse kupon kullanmamış.') }}</td></tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop 