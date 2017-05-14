@extends('admin.layouts.master')

@section('title', __('Tüm Yazılar'))

@section('head')
	<style>
		#list-post tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Tüm Yazılar') }}</div>
			</div>
			<div id="list-post" class="panel-body">
				<table class="table table-hover m-b-0">
					<thead>
						<tr>
							<th>{{ __('Başlık') }}</th>
							<th>{{ __('Kategori') }}</th>
							<th>{{ __('Yorum Sayısı') }}</th>
							<th>{{ __('Kayıt Tarihi') }}</th>
							<th>{{ __('İşlemler') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( count($posts) > 0 )
							@foreach ( $posts as $post )
								<tr id="post-{{ $post->id }}" class="link" data-href="{{ route('admin.blog.update', ['id' => $post->id]) }}">
									<td class="clickable">{{ $post->title }}</td>
									<td class="clickable">{{ $post->category() }}</td>
									<td class="clickable">{{ $post->comments->count() }}</td>
									<td class="clickable">{{ $post->created_at->diffForHumans() }}</td>
									<td>
										<button @click="deletePost({{ $post->id }})" class="btn btn-danger">{{ __('Sil') }}</button>
									</td>
								</tr>
							@endforeach
						@else
							<tr><td colspan="5">{{ __('Hiç kayıtlı yazı yok.') }}</td></tr>
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
			el: '#list-post',

			methods: {
				deletePost(id) {
					swalConfirm().then(() => {
						let delete_url = '{{ route('admin.blog.delete', ':id') }}'.replace(':id', id);
						
						this.$http.post(delete_url, {
							_method: 'DELETE'
						}).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#post-' + id).remove();

							swalSuccess('{{ __('Yazı başarıyla silindi') }}');
						});
					});
				}
			}
		});
	</script>
@stop