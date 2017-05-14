<div class="inbox-item">
	@if ( isset($url) && $url )<a href="{{ $url }}">@endif
	@if ( $image )
		<div class="inbox-item-img"><img src="{{ $image }}" class="img-circle{{ $image_radius or true ? '' : ' b-r-0' }}"></div>
	@endif
	<p class="inbox-item-author">{!! strip_tags($title) !!}</p>
	<p class="inbox-item-text{{ $has_danger or false ? ' text-danger' : '' }}">{{ $description or '—' ?: '—' }}</p>
	@if ( isset($date) && $date )
		<p class="inbox-item-date">{{ $date }}</p>
	@endif
	@if ( isset($url) && $url )</a>@endif
</div>