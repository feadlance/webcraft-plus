@extends('admin.layouts.master')

@section('title', __('Ödeme Ayarları'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="alert alert-warning">
			{{ __('Yapılandırmak istediğiniz ödeme yöntemini seçin.') }}
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Ödeme Yöntemleri') }}</div>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ __('İsim') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ( $methods as $method )
							<tr class="link" data-href="{{ route('admin.settings.payment', $method['key']) }}">
								<td class="clickable">{{ $method['name'] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop