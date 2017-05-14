@extends('admin.layouts.master')

@section('title', __('Sunucular'))

@section('head')
	<style>
		#list-server tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Sunucular') }}</div>
			</div>
			<div id="list-server" class="panel-body">
				<table class="table table-hover m-b-0">
					<thead>
						<tr>
							<th>{{ __('Sunucu') }}</th>
							<th>{{ __('Slug') }}</th>
							<th>{{ __('IP') }}</th>
							<th>{{ __('Durum') }}</th>
							<th>{{ __('Kayıt Tarihi') }}</th>
							<th>{{ __('İşlemler') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( $servers->count() > 0 )
							@foreach ( $servers as $server )
								<tr id="server-{{ $server->id }}" class="link" data-href="{{ route('admin.server.detail', $server->slug) }}">
									<td class="clickable">{{ $server->name }}</td>
									<td class="clickable">{{ $server->slug }}</td>
									<td class="clickable">{{ $server->host }}:{{ $server->port }}</td>
									<td class="clickable">{{ $server->online_users()->count() }}/{{ $server->slot }}</td>
									<td class="clickable">{{ $server->created_at->diffForHumans() }}</td>
									<td>
										<button @click="deleteServer({{ $server->id }})" class="btn btn-danger">{{ __('Sil') }}</button>
									</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="5">{{ __('Hiç kayıtlı sunucu yok.') }}</td></tr>
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
			el: '#list-server',

			methods: {
				deleteServer(id) {
					swalConfirm().then(() => {
						var href = '{{ route('admin.server.delete', ':id') }}';

						this.$http.post(href.replace(':id', id), {
							_method: 'DELETE'
						}).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#server-' + id).remove();

							swalSuccess('{{ __('Sunucu başarıyla silindi') }}');
						});
					});
				}
			}
		});
	</script>
@stop