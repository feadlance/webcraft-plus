<li{!! $active or false ? ' class="active"' : '' !!} itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
	@if ( isset($active) && $active === true )
		<font itemscope itemtype="http://schema.org/Thing" itemprop="item">
			<span itemprop="name">{{ $name }}</span>
		</font>
	@else
		<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{{ $url or '#' }}"{!! isset($url_toggle) ? ' data-toggle="' . $url_toggle . '"' : '' !!}>
			<span itemprop="name">{{ $name }}</span>
		</a>
	@endif

	<meta itemprop="position" content="{{ $position }}">
</li>