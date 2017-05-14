@extends('admin.layouts.master')

@section('title', __('Forumlar'))

@section('head')
	<style>
		#list-forum tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div id="list-forum" class="col-md-10 col-md-offset-1">
		@foreach ( $categories as $category )
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ $category->name }}</div>
				</div>
				<div class="panel-body">
					<table class="table table-hover m-b-0">
						<thead>
							<tr>
								<th>{{ __('Başlık') }}</th>
								<th>{{ __('Kategori') }}</th>
								<th>{{ __('Konu Sayısı') }}</th>
								<th>{{ __('Kayıt Tarihi') }}</th>
								<th>{{ __('İşlemler') }}</th>
							</tr>
						</thead>
						<tbody>
							@if ( $category->forums->count() > 0 )
								@foreach ( $category->forums as $forum )
									<tr id="forum-{{ $forum->id }}" class="link" data-href="{{ route('admin.forum.update', ['id' => $forum->id]) }}">
										<td class="clickable">{{ $forum->name }}</td>
										<td class="clickable">{{ $forum->category->name }}</td>
										<td class="clickable">{{ $forum->threads->count() }}</td>
										<td class="clickable">{{ $forum->created_at->diffForHumans() }}</td>
										<td>
											<button @click="deleteForum({{ $forum->id }})" class="btn btn-danger">{{ __('Sil') }}</button>
										</td>
									</tr>
								@endforeach
							@else
								<tr><td colspan="5">{{ __('Hiç kayıtlı forum yok.') }}</td></tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		@endforeach

		@if ( $categories->count() <= 0 )
			<div class="alert alert-warning text-center">
				{{ __('Hiç forum eklenmemiş.') }}
				<a href="{{ route('admin.forum.add') }}">{{ __('Yeni bir tane ekleyin.') }}</a>
			</div>
		@endif
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#list-forum',

			methods: {
				deleteForum(id) {
					swalConfirm().then(() => {
						let delete_url = '{{ route('admin.forum.delete', ':id') }}'.replace(':id', id);
						
						this.$http.post(delete_url, {
							_method: 'DELETE'
						}).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#forum-' + id).remove();

							swalSuccess('{{ __('Forum başarıyla silindi') }}');
						});
					});
				}
			}
		});
	</script>
@stop