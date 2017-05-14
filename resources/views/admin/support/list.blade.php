<?php $title = __($type !== 'closed' ? 'Yeni Destek Talepleri' : 'Arşiv'); ?>

@extends('admin.layouts.master')

@section('title', $title)

@section('head')
	<style>
		.column-active {
			color: #fff;
			background-color: #6e8cd7;
		}

		.column-active:hover {
			background-color: #5475c5 !important;
		}
	</style>
@stop

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ $title }}</div>
			</div>
			<div class="panel-body">
				<table class="table table-hover m-b-0">
					<thead>
						<tr>
							<th>{{ __('Başlık') }}</th>
							<th>{{ __('Oyuncu') }}</th>
							<th>{{ __('Sunucu') }}</th>
							<th>{{ __('Konu') }}</th>
							<th>{{ __('Tarih') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( $supports->count() > 0 )
							@foreach ( $supports as $support )
								<tr class="link{{ $type !== 'closed' && $support->unViewedMessages(false)->count() > 0 ? ' column-active' : '' }}" data-href="{{ route('admin.support.reply', $support->id) }}">
									<td class="clickable">{{ str_limit($support->title, 100) }}</td>
									<td class="clickable">{{ $support->user->nameOrUsername() }}</td>
									<td class="clickable">{{ $support->category() }}</td>
									<td class="clickable">{{ $support->subject() }}</td>
									<td class="clickable">{{ $support->created_at->diffForHumans() }}</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="3">{{ __($type !== 'closed' ? 'Yeni destek talebi yok.' : 'Arşiv temiz.') }}</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop