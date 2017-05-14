@extends('admin.layouts.master')

@section('title', __('Yeni Ürün'))

@section('content')
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">{{ __('Yeni Ürün') }}</div>
			</div>
			<div class="panel-body">
				<form id="form" action="{{ route('admin.product.add') }}" method="post" class="form-horizontal" role="form">
					{{ csrf_field() }}

					@if ( $product !== null )
						<input type="hidden" name="product" value="{{ $product->id }}">
					@endif
					
					<div class="form-group{{ $errors->has('server_id.*') ? ' has-error' : '' }}">
						<label for="server_id" class="col-sm-2 control-label">{{ __('Sunucular') }}</label>
						<div class="col-sm-10">
							<select name="server_id[]" id="server_id" class="form-control select2" multiple>
								@foreach ( $servers as $key => $server )
									<option value="{{ $server->id }}"{{ in_array($server->id, $form->server_id) ? ' selected' : '' }}>{{ $server->name }}</option>
								@endforeach
							</select>
							@if ( $errors->has('server_id.*') )
								<span class="help-block">{{ $errors->first('server_id.*') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('command_type') ? ' has-error' : '' }}">
						<div class="radio radio-primary">
							<div class="col-sm-10 col-sm-offset-2 m-b-5">
								<input type="radio" name="command_type" id="command_type_1" value="single"{{ $form->command_type !== 'multiple' ? ' checked' : '' }}>
								<label title="Üye, bir ürün satın aldığında komut sadece seçtiği sunucuya gönderilir." for="command_type_1">
									{{ __('Komutları sadece satın alınan sunucuya gönder.') }}
								</label>
							</div>
							<div class="col-sm-10 col-sm-offset-2">
								<input type="radio" name="command_type" id="command_type_2" value="multiple"{{ $form->command_type === 'multiple' ? ' checked' : '' }}>
								<label title="Üye, bir ürün satın aldığında komut yukarıda seçilen tüm sunuculara gönderilir." for="command_type_2">
									{{ __('Komutları, seçilen tüm sunuculara gönder.') }}
								</label>
							</div>
						</div>
					</div>
					<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
						<label for="type" class="col-sm-2 control-label">{{ __('Kategori') }}</label>
						<div class="col-sm-10">
							<select v-model="type" name="type" id="type" class="form-control">
								<option value="vip"{{ $form->type === 'vip' ? ' selected' : '' }}>VIP</option>
								<option value="item"{{ $form->type === 'item' ? ' selected' : '' }}>Eşya</option>
							</select>
							@if ( $errors->has('type') )
								<span class="help-block">{{ $errors->first('type') }}</span>
							@endif
						</div>
					</div>
					<div v-if="show_prefix" class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
						<label for="prefix" class="col-sm-2 control-label">{{ __('VIP Prefix') }}</label>
						<div class="col-sm-10">
							<input onkeyup="color()" type="text" id="prefix" name="prefix" value="{{ $form->prefix }}" class="form-control">
							@if ( $errors->has('prefix') )
								<span class="help-block">{{ $errors->first('prefix') }}</span>
							@else
								<span class="help-block">
									<span id="prefixExample">{!! $prefix !!}</span><br>
									{{ __('Kullanıcı bu VIP ürününü satın aldıktan sonra sitede görünecek prefix.') }}<br>
									{{ __('Renk kodlarınıda kullanabilirsiniz.') }}
								</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label for="name" class="col-sm-2 control-label">{{ __('Ürün Adı') }}</label>
						<div class="col-sm-10">
							<input type="text" id="name" name="name" value="{{ $form->name }}" class="form-control">
							@if ( $errors->has('name') )
								<span class="help-block">{{ $errors->first('name') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('given_commands') ? ' has-error' : '' }}">
						<label for="given_commands" class="col-sm-2 control-label">{{ __('Ürün Komutları') }}</label>
						<div class="col-sm-10">
							<textarea id="given_commands" name="given_commands" class="form-control" placeholder="{{ __('Örnek: ') }} /manuadd @p vip" rows="4">{{ $form->given_commands }}</textarea>
							@if ( $errors->has('given_commands') )
								<span class="help-block">{{ $errors->first('given_commands') }}</span>
							@else
								<span class="help-block">{{ __('Ürün satın aldığında işlenecek olan kodları yazın.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('day') ? ' has-error' : '' }}">
						<label for="day" class="col-sm-2 control-label">{{ __('Ürün Süresi') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<input v-model="day" type="text" id="day" name="day" value="{{ $form->day }}" class="form-control">
								<span class="input-group-addon">{{ __('gün') }}</span>
							</div>
							@if ( $errors->has('day') )
								<span class="help-block">{{ $errors->first('day') }}</span>
							@else
								<span class="help-block">{{ __('Boş bırakırsanız sınırsız olacaktır.') }}</span>
							@endif
						</div>
					</div>
					<div v-if="received_commands" class="form-group{{ $errors->has('received_commands') ? ' has-error' : '' }}">
						<label for="received_commands" class="col-sm-2 control-label">{{ __('Süre Sonu Komutları') }}</label>
						<div class="col-sm-10">
							<textarea id="received_commands" name="received_commands" class="form-control" placeholder="{{ __('Örnek: ') }} /manuadd @p default" rows="4">{{ $form->received_commands }}</textarea>
							@if ( $errors->has('received_commands') )
								<span class="help-block">{{ $errors->first('received_commands') }}</span>
							@else
								<span class="help-block">{{ __('Ürün süresi bittiğinde işlenecek olan kodları yazın.') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
						<label for="icon" class="col-sm-2 control-label">{{ __('İkon') }}</label>
						<div class="col-sm-10">
							<select name="icon" id="icon" class="form-control select2-image">
								@foreach ( $icons as $key => $icon )
									<option value="{{ $key }}" data-image="{{ asset("images/minecraft/{$key}.png") }}"{{ $form->icon === $key ? ' selected' : '' }}>{{ $icon ?: $key }}</option>
								@endforeach
							</select>
							@if ( $errors->has('icon') )
								<span class="help-block">{{ $errors->first('icon') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
						<label for="description" class="col-sm-2 control-label">{{ __('Ürün Hakkında') }}</label>
						<div class="col-sm-10">
							<textarea id="description" name="description" class="form-control" rows="2">{{ $form->description }}</textarea>
							@if ( $errors->has('description') )
								<span class="help-block">{{ $errors->first('description') }}</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
						<label for="price" class="col-sm-2 control-label">{{ __('Fiyat') }}</label>
						<div class="col-sm-10">
							<div class="input-group">
								<span class="input-group-addon">₺</span>
								<input type="text" id="price" name="price" placeholder="0,00" value="{{ $form->price }}" class="form-control">
							</div>
							@if ( $errors->has('price') )
								<span class="help-block">{{ $errors->first('price') }}</span>
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

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#form',

			data: {
				day: '{{ $form->day ?: '0' }}',
				type: '{{ $form->type ?: 'item' }}'
			},

			computed: {
				received_commands() {
					if ( this.day > 0 ) {
						return true;
					}

					return false;
				},

				show_prefix() {
					if ( this.type === 'vip' ) {
						return true;
					}

					return false;
				}
			}
		});

		function color() {
			var val = $('#prefix').val();

			if ( val == null || val == '' ) {
				val = '{!! $prefix !!}';
			} else {
				val = val.replaceColorCodes();
			}

			$('#prefixExample').html(val);
		}
	</script>
	<script type="text/javascript" src="{{ asset('js/minecraft-color.js') }}"></script>
@stop