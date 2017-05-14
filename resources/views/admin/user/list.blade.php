@extends('admin.layouts.master')

@section('title', __('Oyuncular'))

@section('head')
	<style>
		#list-user tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-border panel-warning">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Oyuncu İsmini Yazın') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.user.list') }}">
					<div class="input-group">
						<input type="text" name="username" value="{{ request('username') ?: $random }}" class="form-control">
						<span class="input-group-btn">
							<button class="btn btn-primary">{{ __('Ara') }}</button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Oyuncular') }}</div>
			</div>
			<div id="list-user" class="panel-body">
				@if ( $users->count() > 0 )
					<table class="table table-hover m-b-0">
						<thead>
							<tr>
								<th>{{ __('Oyuncu') }}</th>
								<th>{{ __('Kayıt Tarihi') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ( $users as $user )
								<tr id="user-{{ $user->id }}" class="link" data-href="{{ route('admin.user.detail', $user->username) }}">
									<td class="clickable">
										<img width="25" height="25" class="m-r-5" src="{{ $user->avatar() }}" alt="User Avatar">
										{!! $user->prefixAndName() !!}
									</td>
									<td class="clickable">{{ $user->created_at->diffForHumans() }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $users->links() }}
				@else
					<span class="help-block">
						@if ( $filter === 'online' )
							@if ( settings('lebby.minecraftsunucular') )
								{{ __('Hiç çevrimiçi oyuncu yok.') }}
							@else
								{!! __('Çevrimiçi oyuncu yok, görünüşe göre reklama ihtiyacın var, dilersen <a target="_blank" href="http://www.minecraftsunucular.com">MinecraftSunucular.com</a> adresinde sunucunu paylaşabilirsin.') !!}
							@endif
						@else
							{{ __('Hiç kayıtlı oyuncu yok.') }}
						@endif
					</span>
				@endif
			</div>
		</div>
	</div>
@stop