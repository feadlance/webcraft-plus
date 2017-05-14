@extends('layouts.master')

@section('title', __('Market'))

@section('canonical', route('market.index'))

@section('content')
	<section class="hero hero-games height-300" style="background-image: url({{ asset('images/sliders/05.jpg') }});">
		<div class="hero-bg"></div>
		<div class="container">
			<div class="page-header">
				<div class="page-title bold">{{ __('Market') }}</div>
				<p>{{ __('Daha güçlü olmak için ihtiyacın olan tüm ürünleri buradan temin et.') }}</p>
			</div>
		</div>
	</section>
	<div id="product">
		<section class="padding-top-25 no-padding-bottom border-bottom-1 border-grey-300">
			<div class="container">
				<div id="selectedDropdown" class="headline">
					<h4>{{ __('Ürünler') }}</h4>
					<input type="text" class="form-control hidden-xs" v-model="filters.search" placeholder="{{ __('Ürün ara...') }}">
					<div class="dropdowns">
						<div class="dropdown">
							<a href="#" class="btn btn-default btn-icon-left btn-icon-right dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sort-amount-desc"></i> <span>{{ __('Sırala') }}</span> <i class="ion-android-arrow-dropdown"></i></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" @click="setFilter('orderby', null)">{{ __('Normal Sıralama') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('orderby', 'price|asc')">{{ __('Ucuzdan Pahalıya') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('orderby', 'price|desc')">{{ __('Pahalıdan Ucuza') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('orderby', 'created_at|asc')">{{ __('Önce Son Eklenen') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('orderby', 'created_at|desc')">{{ __('Önce İlk Eklenen') }}</a></li>
							</ul>
						</div>
						<div class="dropdown">
							<a href="#" class="btn btn-default btn-icon-left btn-icon-right dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tag"></i> <span>{{ __('Tür') }}</span> <i class="ion-android-arrow-dropdown"></i></a>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" @click="setFilter('type', null)" data-text="{{ __('Tür') }}">{{ __('Her İkiside') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('type', 'vip')">{{ __('VIP') }}</a></li>
								<li><a href="javascript:;" @click="setFilter('type', 'item')">{{ __('Eşya') }}</a></li>
							</ul>
						</div>
						<div class="dropdown">
							<a href="#" class="btn btn-default btn-icon-left btn-icon-right dropdown-toggle" data-toggle="dropdown"><i class="fa fa-server"></i> <span>{{ __('Sunucu') }}</span> <i class="ion-android-arrow-dropdown"></i></a>
							<ul class="dropdown-menu">
								@foreach ( $servers as $server )
									<li><a href="javascript:;" @click="setFilter('server', {{ $server->id }})">{{ $server->name }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="bg-grey-50">
			<div class="container">
				<div v-if="filteredProducts.length > 0">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-for="productView in filteredProducts" v-html="productView.view"></div>
					</div>
					<div v-if="pagination" v-html="pagination"></div>
				</div>
				<div v-else>
					<h4>{{ __('Bu sayfada hiç ürün yok.') }}</h4>
				</div>
			</div>
		</section>
		<div id="buy" class="modal fade" tabindex="-1">
		    <div class="modal-dialog modal-sm">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h3 class="modal-title">
		                	<span v-if="loadingDetail">
		                		<i class="fa fa-eye" title="Illumemati"></i> ...
		                	</span>
		                	<div v-else>
		                		<img class="margin-right-5" v-bind:src="product.imageUrl" alt="Product Icon">
		                		<span>@{{ product.name }}</span>
		                	</div>
		                </h3>
		            </div>
		            <div v-if="loadingDetail" class="modal-body">
		            	{{ __('Yükleniyor...') }}
		            </div>
		            <div v-else>
			            <div class="modal-body">
			            	<h4 v-if="product.day" class="margin-bottom-20">@{{ product.dayString }}</h4>

			            	<div v-if="product.description" class="margin-bottom-20">
			            		<span>@{{ product.description }}</span>
			            	</div>

			            	<div class="pre pre-primary margin-bottom-20">
			            		<div class="pre-header">{{ __('Satın Alındığında İşlenecek Kodlar') }}</div>
			            		<div class="pre-body" v-html="product.givenCommands"></div>	
			            	</div>

			            	<div v-if="product.receivedCommands" class="margin-bottom-20">
			            		<div class="pre pre-danger">
			            			<div class="pre-header">{{ __('Süresi Bittiğinde İşlenecek Kodlar') }}</div>
			            			<div class="pre-body" v-html="product.receivedCommands"></div>	
			            		</div>
			            		<small style="padding: 5px; display: block;">{{ __('Bu ürün sürelidir, süresi bittiğinde yukarıda ki kodlar çalışacaktır.') }}</small>
			            	</div>

			            	<div style="margin-top: -20px;"></div>
			            </div>
			            <div class="modal-footer text-left">
			            	<button id="buyButton" @click="buyProduct()" class="btn btn-primary btn-block">{{ __('Satın Al') }} (@{{ product.priceFormat }})</button>
			            </div>
			    	</div>
		        </div>
		    </div>
		</div>
	</div>
@stop

@section('scripts')
	<script>
		var Product = new Vue({
			el: '#product',

			data: {
				id: null,
				filters: {
					search: null
				},
				product: {
					id: null,
					name: null,
					description: null,
					imageUrl: null,
					givenCommands: null,
					receivedCommands: null,
					day: null,
					dayString: null
				},
				products: [],
				pagination: null,
				loadingDetail: true
			},

			mounted() {
				this.fetchProducts();
			},

			computed: {
				filteredProducts() {
					var products = this.products,
						searchString = this.filters.search;

					if ( !searchString ) {
						return products;
					}

					searchString = searchString.trim().toLowerCase();

		            return this.products.filter((item) => {
		                if ( item.searchQuery.toLowerCase().indexOf(searchString) !== -1 ){
		                	return item;
		                }
		            });
				}
			},

			methods: {
				fetchProducts() {
					this.$http.post('{{ route('market.list') }}', this.filters).then((response) => {
						if ( response.body.status == false ) {
							swalError(response.body.status_message);
							return false;
						}

						this.products = response.body.data.viewProducts;
						this.pagination = response.body.data.pagination;
					});
				},

				loadProductDetail(id) {
					this.loadingDetail = true;

					this.$http.post('{{ route('market.detail', ':id') }}'.replace(':id', id)).then((response) => {
						if ( response.body.status == false ) {
							swalError(response.body.status_message);
							$('#buy').modal('hide');
							this.fetchProducts();
							return false;
						}

						this.product = response.body.data;
						this.loadingDetail = false;
					});
				},

				buyProduct() {
					document.getElementById('buyButton').disabled = true;

					this.$http.post('{{ route('market.buy', ':id') }}'.replace(':id', this.product.id)).then((response) => {
						document.getElementById('buyButton').disabled = false;
						
						if ( response.body.status === false ) {
							swalError(response.body.status_message);
							return false;
						}

						this.fetchProducts();
						swalSuccess(response.body.status_message);
						$('#buy').modal('hide');
					});
				},

				setFilter(key, value) {
					this.filters[key] = value;
					this.fetchProducts();
				}
			}
		});

		function setFilter(key, value) {
			Product.setFilter(key, value);
		}

		$(function () {
			$('#selectedDropdown .dropdown-menu li a').on('click', function () {
				var selectedText = $(this).text();

				if ( $(this).data('text') != undefined ) {
					selectedText = $(this).data('text');
				}

				$(this).closest('.dropdown').find('> a span').html(selectedText);
			});

			$('#buy').on('shown.bs.modal', function (e) {
				var id = $(e.relatedTarget).closest('.card').data('product-id');

	        	Product.loadProductDetail(Product.id ? Product.id : id);
	        }).on('hidden.bs.modal', function () {
	        	Product.loadingDetail = true;
	        	Product.id = null;
	        });

	        @if ( $id )
	        	Product.id = {{ $id }};
	        	$('#buy').modal('show');
	        @endif
		});
	</script>
@stop