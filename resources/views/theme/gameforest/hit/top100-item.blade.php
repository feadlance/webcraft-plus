<?php

	$th1 = $key === 0;
	$th2 = $key === 1;
	$th3 = $key === 2;

	if ( $th1 ) { $color = ' text-danger'; }
	else if ( $th2 ) { $color = ' text-info'; }
	else if ( $th3 ) { $color = ' text-success'; }
	else { $color = null; }

?>

<td class="iteration{{ $color }}">
	@if ( $th1 )
		<i class="fa fa-trophy"></i>
	@else
		{{ ++$key }}
	@endif
</td>
<td>
	<a href="{{ route('profile.index', $statistic->user->username) }}">
		<img style="border-radius: 100%; margin-right: 5px;" src="{{ $statistic->user->avatar(30) }}" alt="User Avatar">
		{!! $statistic->user->prefixAndName() !!}
	</a>
</td>
<td class="number">{{ $statistic->player_kills ?: 0 }}</td>
<td class="number">{{ $statistic->mob_kills ?: 0 }}</td>
<td class="number">{{ $statistic->deaths ?: 0 }}</td>