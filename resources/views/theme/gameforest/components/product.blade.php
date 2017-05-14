<div data-product-id="{{ $product->id }}" class="card card-product">
	<div class="card-img">
		<a class="image" data-toggle="modal" href="#buy">
			<img src="{{ $product->toImageUrl() }}" alt="Product Image">
		</a>
		<div class="icon">
			<a data-toggle="modal" href="#buy">
				<img width="75" src="{{ $product->toImageUrl() }}" alt="Product Icon">
			</a>
		</div>
		<div class="price">
			<span class="label label-success">{{ $product->price() }}</span>
		</div>
		<div class="category">
			<span class="label label-{{ $product->server->onlineStatusColor() }}">{{ $product->server->name }}</span>
		</div>
		@if ( $saleCount = $product->sales->count() )
			<div class="meta" data-toggle="tooltip" title="{{ __(':count kişi bu ürünü satın aldı.', ['count' => $saleCount]) }}"><i class="fa fa-cart-arrow-down"></i> <span>{{ $saleCount }}</span></div>
		@endif
	</div>
	<div class="caption">
		<h3 class="card-title"><a data-toggle="modal" href="#buy">{{ $product->name }}</a></h3>
		<ul>
			<li>{{ $product->created_at->diffForHumans() }}</li>
		</ul>
	</div>
</div>