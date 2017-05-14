@extends('admin.layouts.master')

@section('title', $category !== null ? $category->name : __('Yeni Forum Kategorisi'))

@section('head')
	<style>
		#list-category tbody tr td {
			vertical-align: middle;
		}
	</style>
@stop

@section('content')
	@if ( $category !== null )
		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				<h4 class="page-title">{{ __('Kategoriyi Düzenle') }}</h4>
			</div>
			<div class="col-md-4 text-right">
				<a href="{{ route('admin.forum.category.index') }}" class="btn btn-default">{{ __('Geri Dön') }}</a>
			</div>
		</div>
	@endif
	<div class="row">
		<div class="col-md-{{ $category !== null ? '10 col-md-offset-1' : '4' }}">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ $category !== null ? $category->name : __('Yeni Forum Kategorisi') }}</div>
				</div>
				<div class="panel-body">
					<form action="{{ route('admin.forum.category.add') }}" method="post" role="form">
						{{ csrf_field() }}

						@if ( $category !== null )
							<input type="hidden" name="category" value="{{ $category->id }}">
						@endif
						
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="control-label">{{ __('Kategori Başlığı') }}</label>
							<input type="text" id="name" name="name" value="{{ $input->name }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
						<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
							<label for="description" class="control-label">{{ __('Açıklama') }}</label>
							<textarea id="description" name="description" class="form-control" rows="2">{{ $input->description }}</textarea>
							@if ( $errors->has('description') )
								<span class="help-block">{{ $errors->first('description') }}</span>
							@endif
						</div>
						<div class="form-group m-b-0">
							<div class="text-right">
								<button type="submit" class="btn btn-default waves-effect waves-light">{{ __('Kaydet') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		@if ( $category === null )
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">{{ __('Forum Kategorileri') }}</div>
					</div>
					<div id="list-category" class="panel-body">
						<table class="table table-hover m-b-0">
							<thead>
								<tr>
									<th>{{ __('Başlık') }}</th>
									<th>{{ __('Kayıt Tarihi') }}</th>
									<th>{{ __('İşlemler') }}</th>
								</tr>
							</thead>
							<tbody>
								@if ( $categories->count() > 0 )
									@foreach ( $categories as $category )
										<tr id="category-{{ $category->id }}" class="link" data-href="{{ route('admin.forum.category.update', ['id' => $category->id]) }}">
											<td class="clickable">{{ $category->name }}</td>
											<td class="clickable">{{ $category->created_at->diffForHumans() }}</td>
											<td>
												<button @click="deleteCategory({{ $category->id }})" class="btn btn-danger">{{ __('Sil') }}</button>
											</td>
										</tr>
									@endforeach
								@else
									<tr><td colspan="3">{{ __('Hiç kayıtlı kategori yok.') }}</td></tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		@endif
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#list-category',

			methods: {
				deleteCategory(id) {
					swalConfirm().then(() => {
						let delete_url = '{{ route('admin.forum.category.delete', ':id') }}'.replace(':id', id);

						this.$http.post(delete_url, {
							_method: 'DELETE'
						}).then((response) => {
							if ( response.body.status == false ) {
								swalError(response.body.status_message);
								return false;
							}

							$('#category-' + id).remove();

							swalSuccess('{{ __('Kategori başarıyla silindi') }}');
						});
					});
				}
			}
		});
	</script>
@stop