@extends('admin.layouts.master')

@section('title', __('Sosyal Medya Ayarları'))

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Sosyal Medya Ayarları') }}</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admin.settings.social') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}
					
					@foreach ( $socials as $key => $social )
						<div class="form-group{{ $errors->has("social.{$key}") ? ' has-error' : '' }}">
							<label for="social_{{ $key }}" class="col-sm-2 control-label">{{ $social[0] }}</label>
							<div class="col-sm-10">
								<input type="text" id="social_{{ $key }}" name="social[{{ $key }}]" value="{{ old("social.{$key}") ?: settings("lebby.social.{$key}.2") }}" class="form-control">
								@if ( $errors->has("social.{$key}") )
									<span class="help-block">{{ $errors->first("social.{$key}") }}</span>
								@endif
							</div>
						</div>
					@endforeach

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