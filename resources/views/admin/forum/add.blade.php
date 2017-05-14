@extends('admin.layouts.master')

@section('title', __('Yeni Forum'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Yeni Forum') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.forum.add') }}" method="post" role="form" class="form-horizontal">
					{{ csrf_field() }}

					@if ( $forum !== null )
						<input type="hidden" name="forum" value="{{ $forum->id }}">
					@endif
					
					<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
						<label for="category_id" class="col-sm-2 control-label">{{ __('Kategori') }}</label>
						<div class="col-sm-10">
							<select name="category_id" id="category_id" class="form-control">
								@if ( $categories->count() > 0 )
									@foreach ( $categories as $category )
										<option value="{{ $category->id }}"{{ $input->category_id == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
									@endforeach
								@else
									<option value="0">{{ __('Forum Kategorilerinden yeni bir kategori oluşturun.') }}</option>
								@endif
							</select>
							@if ( $errors->has('category_id') )
								<span class="help-block">{{ $errors->first('category_id') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="control-label col-sm-2">{{ __('Başlık') }}</label>
						<div class="col-sm-10">
							<input type="text" id="name" name="name" value="{{ $input->name }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
						<label for="description" class="control-label col-sm-2">{{ __('Açıklama') }}</label>
						<div class="col-sm-10">
							<textarea id="description" name="description" class="form-control" rows="2">{{ $input->description }}</textarea>
							@if ( $errors->has('description') )
								<span class="help-block">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
						<label for="icon" class="control-label col-sm-2">{{ __('İkon') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">fa-</span>
								<input type="text" id="icon" name="icon" value="{{ $input->icon }}" class="form-control">
							</div>
							@if ( $errors->has('icon') )
								<span class="help-block">{{ $errors->first('icon') }}</span>
							@else
								<span class="help-block">
									{{ __('İsteğe bağlı, ikon listesi: ') }}
									<a target="_blank" href="http://fontawesome.io/icons">http://fontawesome.io/icons</a>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group m-b-0">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-default waves-effect waves-light">{{ __('Kaydet') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop