<div class="row">
	<div class="col-md-4">
		<div class="widget">
			<div class="panel panel-default">
				<div class="panel-heading">{{ __('Görünüm') }}</div>
				<div class="panel-body text-center">
					<img src="{{ $user->body(150) }}" alt="User Body">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="widget">
			<div class="panel panel-default">
				<div class="panel-heading">{{ __('Hakkında') }}</div>
				<div class="panel-body">
					{{ $user->biography }}
					<ul class="panel-list{{ $user->biography ? ' margin-top-25' : '' }}">
						@if ( $user->social_facebook )
							<li>
								<i class="fa fa-facebook"></i>
								<a target="_blank" href="https://www.facebook.com/{{ $user->social_facebook }}">
									{{ $user->social_facebook }}
								</a>
							</li>
						@endif
						@if ( $user->social_youtube )
							<li>
								<i class="fa fa-youtube"></i>
								<a target="_blank" href="https://www.youtube.com/user/{{ $user->social_youtube }}">
									{{ $user->social_youtube }}
								</a>
							</li>
						@endif
						@if ( $user->social_steam )
							<li>
								<i class="fa fa-steam"></i>
								<a target="_blank" href="http://steamcommunity.com/id/{{ $user->social_steam }}">
									{{ $user->social_steam }}
								</a>
							</li>
						@endif
						@if ( $user->location )
							<li><i class="fa fa-map-marker"></i> {{ $user->location }}</li>
						@endif
						<li><i class="fa fa-clock-o"></i> {{ __(':time katıldı.', ['time' => $user->created_at->diffForHumans()]) }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="widget">
			<div class="panel panel-default">
				<div class="panel-heading">{{ __('Oyun') }}</div>
				<div class="panel-body">
					<ul class="panel-list">
						<li><i class="fa fa-try"></i> {{ __(':money Türk Lirası', ['money' => _nf($user->money)]) }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.panel-list > li:first-child {
		margin-top: 0;
	}
</style>