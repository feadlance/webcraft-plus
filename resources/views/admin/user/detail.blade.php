@extends('admin.layouts.master')

@section('title', $user->nameOrUsername())

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
				<a href="{{ route('admin.user.update', $user->username) }}" class="btn btn-default">{{ __('Profili Düzenle') }}</a>
			</div>
			<h4 class="page-title">{!! $user->prefixAndName() !!}</h4>
		</div>
	</div>
	<div id="user" class="row">
		<div class="col-md-5">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Hızlı İşlemler') }}</div>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<a href="#sendMoney" data-toggle="modal" class="btn btn-success" style="width: 100%;">{{ __('Türk Lirası Gönder') }}</a>
							</div>
							<div class="col-md-3">
								<a href="#sendMessage" data-toggle="modal" class="btn btn-default" style="width: 100%;">{{ __('Mesaj Gönder') }}</a>
							</div>
							<div class="col-md-3">
								<a href="#sendItem" data-toggle="modal" class="btn btn-default" style="width: 100%;">{{ __('Eşya Gönder') }}</a>
							</div>
						</div>
					</div>
					<div class="form-group m-b-0">
						<div class="row">
							<div class="col-md-4">
								<a href="#ban" data-toggle="modal" class="btn btn-danger" style="width: 100%;">{{ __('Ban At') }}</a>
							</div>
							<div class="col-md-4">
								<a href="#warn" data-toggle="modal" class="btn btn-warning" style="width: 100%;">{{ __('Uyarı Gönder') }}</a>
							</div>
							<div class="col-md-4">
								<a href="#kick" data-toggle="modal" class="btn btn-default" style="width: 100%;">{{ __('Kick At') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title">{{ __('Son Aktif Uyarılar/Cezalar') }}</div>
				</div>
				<div class="panel-body">
					@if ( $punishments->count() > 0 )
						@component('admin.components.inbox.parent')
							@foreach ( $punishments as $punishment )
								@include('admin.components.inbox.block', [
									'title' => $punishment->type(),
									'description' => 'Bitiş: ' . ($punishment->remaining() ?: 'Sınırsız'),
									'date' => $punishment->start()->diffForHumans(),
									'image' => null
								])
							@endforeach
						@endcomponent
					@else
						<span class="help-block">{{ __('Hiç uyarı ya da cezası yok.') }}</span>
					@endif
				</div>
			</div>
		</div>

		<div id="sendMoney" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Türk Lirası Gönder') }}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							{{ __('Dikkat! Göndermek istediğiniz para, oyun parası değildir. Gerçek paradır.') }}
						</div>
						<div class="input-group">
							<span class="input-group-addon">₺</span>
							<input v-on:keyup.enter="sendMoney" type="text" id="money" v-model="money" placeholder="0,00" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button @click="sendMoney()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div id="sendMessage" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Mesaj Gönder') }}</h4>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon">{{ __('Mesajınız') }}</span>
							<input v-on:keyup.enter="sendMessage" type="text" id="message" v-model="message" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button @click="sendMessage()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div id="sendItem" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Eşya Gönder') }}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							{{ __('Eşya gönderebilmek için seçtiğiniz sunucuda /i komutunun çalışması gerekmektedir.') }}
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Sunucu') }}</span>
								<select v-model="server" class="form-control">
									@foreach ( $servers as $server )
										<option value="{{ $server->id }}">{{ $server->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Eşya Kodu') }}</span>
								<input type="text" v-model="item" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Adet') }}</span>
								<input v-on:keyup.enter="sendItem" type="text" v-model="piece" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button @click="sendItem()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div id="ban" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Ban At') }}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Süre') }}</span>
								<input type="text" id="ban_time" v-model="ban_time" class="form-control">
							</div>
							<span class="help-block">
								{{ __('Örnek: 1h = 1 saat, 1m = 1 dakika') }}<br>
								{{ __('Süresiz olmasını istiyorsanız boş bırakın.') }}
							</span>
						</div>
						<div class="form-group m-b-0">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Sebep') }}</span>
								<input v-on:keyup.enter="ban" type="text" id="ban_reason" v-model="ban_reason" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button @click="ban()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div id="warn" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Uyarı Gönder') }}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							{{ __('Uyarı, AdvancedBan plugininin bir özelliğidir. Örneğin üç uyarıdan sonra kick, 10 uyarıdan sonra ban gibi özellikleri vardır. Bu özellikleri pluginin config ayarlarından yapılandırabilirsiniz.') }}
						</div>

						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Süre') }}</span>
								<input type="text" id="warn_time" v-model="warn_time" class="form-control">
							</div>
							<span class="help-block">
								{{ __('Örnek: 1h = 1 saat, 1m = 1 dakika') }}<br>
								{{ __('Süresiz olmasını istiyorsanız boş bırakın.') }}
							</span>
						</div>
						<div class="form-group m-b-0">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Sebep') }}</span>
								<input v-on:keyup.enter="warn" type="text" id="warn_reason" v-model="warn_reason" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button @click="warn()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>

		<div id="kick" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">{{ __('Kick At') }}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group m-b-0">
							<div class="input-group">
								<span class="input-group-addon">{{ __('Sebep') }}</span>
								<input v-on:keyup.enter="kick" type="text" id="kick_reason" v-model="kick_reason" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button @click="kick()" class="btn btn-default">{{ __('Gönder') }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		new Vue({
			el: '#user',

			data: {
				money: null,
				message: null,
				item: null,
				piece: 1,
				server: {{ $firstServerId }},
				ban_reason: null,
				ban_time: null,
				warn_reason: null,
				warn_time: null,
				kick_reason: null
			},

			methods: {
				sendMoney() {
					this.post({
						type: 'sendMoney',
						money: this.money
					}, function (vue) {
						vue.money = null;
					});
				},

				sendMessage() {
					this.post({
						type: 'sendMessage',
						message: this.message
					}, function (vue) {
						vue.message = null;
					});
				},

				sendItem() {
					this.post({
						type: 'sendItem',
						server: this.server,
						item: this.item,
						piece: this.piece
					}, function (vue) {
						vue.item = null;
						vue.piece = 1;
						vue.server = {{ $firstServerId }};
					});
				},

				ban() {
					this.post({
						type: 'ban',
						time: this.ban_time,
						reason: this.ban_reason
					}, function (vue) {
						vue.ban_time = null;
						vue.ban_reason = null;
					});
				},

				warn() {
					this.post({
						type: 'warn',
						time: this.warn_time,
						reason: this.warn_reason
					}, function (vue) {
						vue.warn_time = null;
						vue.warn_reason = null;
					});
				},

				kick() {
					this.post({
						type: 'kick',
						reason: this.kick_reason
					}, function (vue) {
						vue.kick_reason = null;
					});
				},

				post(fields, callback = null) {
					this.$http.post('{{ route('admin.user.action', $user->username) }}', fields).then((response) => {
						if ( response.body.status == false ) {
							swalError(response.body.status_message);
							return false;
						}

						$('#' + fields['type']).modal('hide');

						swalSuccess(response.body.status_message);
						
						if ( callback != null ) {
							callback(this);
						}
					});
				}
			}
		});

		$('#sendMoney').on('shown.bs.modal', function () {
	    	$('#money').focus();
	    });

	    $('#sendMessage').on('shown.bs.modal', function () {
	    	$('#message').focus();
	    });

	    $('#ban').on('shown.bs.modal', function () {
	    	$('#ban_time').focus();
	    });

	    $('#warn').on('shown.bs.modal', function () {
	    	$('#warn_time').focus();
	    });

	    $('#kick').on('shown.bs.modal', function () {
	    	$('#kick_reason').focus();
	    });
	</script>
@stop