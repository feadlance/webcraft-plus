@extends('admin.layouts.master')

@section('title', __('Aktif Cezalar'))

@section('head')
	<style>
		#list-punishment tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Aktif Cezalar') }}</div>
			</div>
			<div id="list-punishment" class="panel-body">
				<table class="table table-hover m-b-0">
					<thead>
						<tr>
							<th>{{ __('Oyuncu') }}</th>
							<th>{{ __('Sebep') }}</th>
							<th>{{ __('Başlangıç') }}</th>
							<th>{{ __('Bitiş Zamanı') }}</th>
							<th>{{ __('Tür') }}</th>
							<th>{{ __('İşlemler') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( $punishments->count() > 0 )
							@foreach ( $punishments as $punishment )
								<tr id="punishment-{{ $punishment->id }}" class="link" data-href="{{ route('admin.punishment.detail', ['id' => $punishment->user->id]) }}">
									<td class="clickable">{{ $punishment->user->nameOrUsername() }}</td>
									<td class="clickable">{{ $punishment->reason }}</td>
									<td class="clickable">{{ $punishment->start()->diffForHumans() }}</td>
									<td class="clickable">{{ $punishment->remaining() ?: __('Sınırsız') }}</td>
									<td class="clickable"><strong>{{ $punishment->type() }}</strong></td>
									<td>
										<button @click="deletePunishment({{ $punishment->id }})" class="btn btn-danger">{{ __('Cezayı Kaldır') }}</button>
									</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="6">{{ __('Hiç cezalı oyuncu yok.') }}</td></tr>
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
			el: '#list-punishment',

			methods: {
				deletePunishment(id) {
					swalConfirm(null, '{{ __('Bu cezayı kaldırmak istiyor musunuz?') }}', '{{ __('Evet') }}').then(() => {
						let delete_url = '{{ route('admin.punishment.delete', ':id') }}'.replace(':id', id);
						
						this.$http.post(delete_url, {
							_method: 'DELETE'
						}).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#punishment-' + id).remove();

							swalSuccess('{{ __('Oyuncunun cezası başarıyla kaldırıldı.') }}');
						});
					});
				}
			}
		});
	</script>
@stop