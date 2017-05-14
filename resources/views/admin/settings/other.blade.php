@extends('admin.layouts.master')

@section('title', __('Diğer Ayarlar'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Diğer Ayarlar') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.other') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}
					
					<div class="form-group{{ $errors->has('analytics') ? ' has-error' : '' }}">
						<label for="analytics" class="col-sm-2 control-label">{{ __('Ekstra Script Kodları') }}</label>
						<div class="col-sm-10">
							<textarea name="analytics" id="analytics" class="form-control" rows="5">{{ $input->analytics }}</textarea>
							@if ( $errors->has('analytics') )
								<span class="help-block">{{ $errors->first('analytics') }}</span>
							@else
								<span class="help-block">Google Analytics, Canlı Destek gibi ekstra script kodlarını buraya yapıştırabilirsiniz.</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('search_console') ? ' has-error' : '' }}">
						<label for="search_console" class="col-sm-2 control-label">{{ __('Google Search Console') }}</label>
						<div class="col-sm-10">
							<input type="text" id="search_console" name="search_console" value="{{ $input->search_console }}" class="form-control">
							@if ( $errors->has('search_console') )
								<span class="help-block">{{ $errors->first('search_console') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group m-b-0">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-default waves-effect waves-light">{{ __('Kaydet') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop