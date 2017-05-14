@extends('admin.layouts.master')

@section('title', $user->nameOrUsername() . ' - Ceza Detayları')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="page-title">{{ 'Ceza Detayları (' . $user->nameOrUsername() . ')' }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Aktif Cezalar') }}</div>
				</div>
				<div class="panel-body">
					@if ( $punishments->count() > 0 )
						<table class="table table-hover">
							<thead>
								<tr>
									<th>{{ __('Sebep') }}</th>
									<th>{{ __('Başlangıç') }}</th>
									<th>{{ __('Bitiş Zamanı') }}</th>
									<th>{{ __('Tür') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ( $punishments as $punishment )
									<tr>
										<td>{{ $punishment->reason }}</td>
										<td>{{ $punishment->start()->diffForHumans() }}</td>
										<td>{{ $punishment->remaining() ?: __('Sınırsız') }}</td>
										<td><strong>{{ $punishment->type() }}</strong></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						{{ __('Aktif bir cezası yok.') }}
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Geçmiş Cezalar') }}</div>
				</div>
				<div class="panel-body">
					@if ( $punishmentHistory->count() > 0 )
						<table class="table table-hover">
							<thead>
								<tr>
									<th>{{ __('Sebep') }}</th>
									<th>{{ __('Başlangıç') }}</th>
									<th>{{ __('Bitiş') }}</th>
									<th>{{ __('Tür') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ( $punishmentHistory as $punishment )
									<tr>
										<td>{{ $punishment->reason }}</td>
										<td>{{ $punishment->start()->format('d.m.Y H:i:s') }}</td>
										<td>{{ $punishment->end() ? $punishment->end()->diffForHumans() : __('Sınırsız') }}</td>
										<td>{{ $punishment->type() }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
						{{ __('Geçmiş bir cezası yok.') }}
					@endif
				</div>
			</div>
		</div>
	</div>
@stop