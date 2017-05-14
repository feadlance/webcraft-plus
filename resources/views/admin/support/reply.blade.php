@extends('admin.layouts.master')

@section('title', __('Mesajı Yanıtla'))

@section('content')
	<div id="support">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="col-md-7">
						<h4 class="page-title">
							{{ $support->title }} <small class="color-default" style="margin-top: 5px; display: block;">{{ $support->category() }}, {{ $support->subject() }}</small>
						</h4>
					</div>
					<div class="col-md-5">
						<div class="text-right" style="margin-top: 20px">
							<a href="{{ route('admin.support.list') }}" class="btn btn-default waves-light waves-effect">{{ __('Geri Dön') }}</a>
							
							@if ( $support->closed_at === null )
								<form style="display: inline-block;" action="{{ route('support.close', $support->id) }}" method="post">
									{{ csrf_field() }}
									<button class="btn btn-danger waves-light waves-effect">{{ __('Talebi Kapat') }}</button>
								</form>
							@else
								<p class="color-default">
									{{ __('Talep Kapatıldı.') }}
								</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				@foreach ( $support->messages as $message )
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">{{ $message->user->nameOrUsername() }} || {{ $message->admin ? __('Temsilci') : __('Oyuncu') }}</div>
						</div>
						<div class="panel-body">
							<p class="color-default">
								{{ $message->created_at->diffForHumans() }}
							</p>
							<p>{!! allow_html_tags($message->body) !!}</p>
						</div>
					</div>
				@endforeach
				@if ( $support->closed_at === null )
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">{{ __('Yanıtla') }}</div>
						</div>
						<div class="panel-body">
							<form action="{{ route('admin.support.reply', $support->id) }}" method="post">
								{{ csrf_field() }}

								<div class="form-group">
									<textarea class="form-control" placeholder="{{ __('Yanıtınız...') }}" name="body" rows="6">{{ old('body') }}</textarea>
								</div>
								<div class="form-group m-b-0">
									<div class="pull-right">
										<button class="btn btn-default waves-effect waves-light">{{ __('Yanıtla') }}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop