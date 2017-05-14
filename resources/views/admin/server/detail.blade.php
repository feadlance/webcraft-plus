@extends('admin.layouts.master')

@section('title', $server->name)

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h4 class="page-title">{{ $server->name }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Konsol') }}</div>
				</div>
				<div id="console" class="panel-body" style="padding: 0">
					<div class="rcon-console">
						<pre class="console-body" v-html="log">{{ __('Yükleniyor...') }}</pre>
						<div class="input-group">
							<input v-on:keyup.enter="sendCommand()" v-model="command" type="text" class="form-control">
							<span class="input-group-addon" style="padding: 0;">
								<button @click="sendCommand()" class="btn btn-default waves-light waves-effect">
									<i class="fa fa-send"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Çevrimiçi Oyuncular') }} <small>({{ $onlinePlayers->count() }})</small></div>
				</div>
				<div class="panel-body">
					@component('admin.components.inbox.parent')
						@if ( $onlinePlayers->count() > 0 )
							@foreach ( $onlinePlayers as $player )
								<a style="display: block; margin-bottom: 5px;" href="{{ route('admin.user.detail', $player->user->username) }}">
									@include('admin.components.inbox.block', [
										'title' => $player->user->username,
										'description' => $player->user->name,
										'image' => $player->user->avatar(40)
									])
								</a>
							@endforeach
						@else
							<span class="color-default">{{ __('Çevrimiçi oyuncu yok') }}</span>
						@endif
					@endcomponent
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Ürünler') }}</div>
				</div>
				<div class="panel-body">
					@if ( $products->count() > 0 )		
						@component('admin.components.inbox.parent')
							@foreach ( $products as $product )
								@include('admin.components.inbox.block', [
									'title' => $product->name,
									'description' => $product->description,
									'date' => $product->price(),
									'image' => $product->toImageUrl(),
									'image_radius' => false
								])
							@endforeach

							@if ( $allProducts > 5 )
								<a href="{{ route('admin.product.list', ['server' => $server->id]) }}" class="btn btn-default waves-effect waves-light m-t-20">Tüm Ürünler</a>
							@endif
						@endcomponent
					@else
						<p class="color-default">{{ __('Markete hiç ürün eklenmemiş') }}</p>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-6">
					<div class="mini-stat clearfix bx-shadow bg-success">
                        <span class="mini-stat-icon"><i class="fa fa-try"></i></span>
                        <div class="mini-stat-info text-right">
                            <span class="counter">₺{{ $thisMonthPrices }}</span>
                            {{ __('Bu Ayki Satış') }}
                        </div>
                        <div class="tiles-progress">
                            <div class="m-t-20">
                                <h5 class="text-uppercase text-white m-0">{{ __('Geçen Ay') }} <span class="pull-right">₺{{ $lastMonthPrices }}</span></h5>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-md-6">
					<div class="mini-stat clearfix bx-shadow bg-info">
                        <span class="mini-stat-icon"><i class="fa fa-shopping-basket"></i></span>
                        <div class="mini-stat-info text-right">
                            <span class="counter">{{ $thisMonthSales }}</span>
                            {{ __('Bu Ay Market Satışları') }}
                        </div>
                        <div class="tiles-progress">
                            <div class="m-t-20">
                                <h5 class="text-uppercase text-white m-0">{{ __('Geçen Ay') }} <span class="pull-right">{{ $lastMonthSales }}</span></h5>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">Son Satışlar</div>
						</div>
						<div class="panel-body">
							@if ( $sales->count() > 0 )		
								@component('admin.components.inbox.parent')
									@foreach ( $sales as $sale )
										@include('admin.components.inbox.block', [
											'title' => $sale->user->nameOrUsername(),
											'description' => ($sale->product ? $sale->product->name : __('Ürün')) . " ({$sale->price()})",
											'date' => $sale->created_at->diffForHumans(),
											'image' => $sale->product ? $sale->product->toImageUrl() : null,
											'image_radius' => false
										])
									@endforeach
								@endcomponent
							@else
								<p class="color-default">{{ __('Kimse bir şey satın almamış.') }}</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#console',

			data: {
				log: null,
				command: null,
				server: {{ $server->id }}
			},

			mounted() {
				this.fetchLog();
			},

			methods: {
				sendCommand() {
					if ( !this.command ) {
						return false;
					}

					this.$http.post('{{ route('admin.server.console') }}', {
						server: this.server,
						command: this.command
					}).then((response) => {
						this.command = null;

						if ( response.body.status == false ) {
							swal('Hata!', response.body.status_message, 'error');
							return false;
						}

						this.fetchLog();
					});
				},

				fetchLog() {
					var href = '{{ route('admin.server.console.log', ':id') }}';

					this.$http.post(href.replace(':id', this.server)).then((response) => {
						if ( response.body.status == false ) {
							this.log = response.body.status_message;
							return false;
						}

						this.log = response.body.data;

						this.scrollBottom();
					});
				},

				scrollBottom() {
					var cbody = document.getElementsByClassName('console-body')[0];
					cbody.scrollTop = cbody.scrollHeight;
				}
			}
		});
	</script>
@stop