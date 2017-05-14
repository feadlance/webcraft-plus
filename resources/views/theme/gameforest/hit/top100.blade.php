@extends('layouts.master')

@section('title', __('Oyun Sıralaması'))

@section('canonical', route('hit.top100'))

@section('head')
	<style>
		table .iteration {
			font-size: 20px;
			font-weight: bold;
		}

		table td.number {
			font-weight: bold;
			font-size: 15px;
		}
	</style>
@stop

@section('content')
	@component('components.breadcrumb.parent')
		@include('components.breadcrumb.block', [
			'position' => 2,
			'name' => __('Hit'),
			'url' => '#'
		])

		@include('components.breadcrumb.block', [
			'position' => 3,
			'name' => 'Top 100',
			'active' => true
		])
	@endcomponent

	<section class="bg-grey-50 padding-bottom-60">
		<div id="hit-players" class="container">
			<h3>{{ __('Sıralama') }}</h3>
			<p>Sunucunun en iyi katilleri.</p>

			<select v-on:change="listPlayers" v-model="server" name="server" id="server" class="form-control m-b-10">
				<option value="">Genel (Tüm Sunucular)</option>
				@foreach ( $servers as $server )
					<option value="{{ $server->slug }}">{{ $server->name }}</option>
				@endforeach
			</select>

			<div id="loadingField">
				<div class="loader"></div>
				
				<div v-if="items.length > 0" class="panel panel-default">
					<div class="panel-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ __('Oyuncu') }}</th>
									<th>{{ __('Oyuncu Öldürme') }}</th>
									<th>{{ __('Mob Öldürme') }}</th>
									<th>{{ __('Ölme') }}</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="item in items" v-html="item"></tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default" v-else>
					<div class="panel-body">
						{{ __('Kimse kimseyi öldürmemiş, çok barışçıl bir sunucudasın.') }}
					</div>
				</div>
			</div>
		</div>
	</section>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#hit-players',

			data: {
				items: [],
				server: ''
			},

			mounted() {
				this.listPlayers();
			},

			methods: {
				listPlayers: function () {
					$('#loadingField').addClass('loading');

					this.$http.post('{{ route('hit.top100') }}', {
						server: this.server
					}).then((response) => {
						if ( response.data.data.length > 0 ) {
							this.items = response.data.data;
						}

						$('#loadingField').removeClass('loading');
					});
				}
			}
		});
	</script>
@stop

<?php $bg_gray = true; ?>