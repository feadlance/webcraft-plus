<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 rightside">
    <div class="widget widget-list">
        <div class="title">
            {!! __('<small>Bu Ay En Çok</small> Kredi Yükleyenler') !!}
        </div>
        @if ( $lastCreditUsers->count() > 0 )
            <ul>
                @foreach ( $lastCreditUsers as $user )
                    <li>
                        <a href="{{ route('profile.index', $user->username) }}" class="thumb"><img style="border-radius: 100%;" src="{{ $user->avatar(40) }}" alt="User Avatar"></a>
                        <div class="widget-list-meta row">
                            <div class="pull-left">
                                <span style="display: block; margin-top: 9px; margin-left: 10px;">
                                    <a href="{{ route('profile.index', $user->username) }}">{!! $user->prefixAndName() !!}</a>
                                </span>
                            </div>
                            <div class="pull-right text-right">
                                <h4 class="widget-list-title">{{ price_with_symbol($user->money, true) }}</h4>
                                <p><i class="fa fa-credit-card-alt"></i> {{ __(':total kez', ['total' => $user->total]) }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('Kimse kredi yüklememiş.') }}</p>
        @endif
    </div>
    <div class="widget widget-list">
        <div class="title">
            {{ __('Son Satışlar') }}
        </div>
        @if ( $lastSales->count() > 0 )
            <ul>
                @foreach ( $lastSales as $sale )
                    <li>
                        <a href="{{ route('profile.index', $sale->user->username) }}" class="thumb"><img style="border-radius: 100%;" src="{{ $sale->user->avatar(40) }}" alt="User Avatar"></a>
                        <div class="widget-list-meta row">
                            <div class="pull-left">
                                <span style="display: block; margin-top: 9px; margin-left: 10px;">
                                    <a href="{{ route('profile.index', $sale->user->username) }}">{!! $sale->user->prefixAndName() !!}</a>
                                </span>
                            </div>
                            <div class="pull-right text-right">
                                <h4 class="widget-list-title">
                                    @if ( $sale->product )
                                        <a href="{{ route('market.index', ['id' => $sale->product->id]) }}">{{ $sale->product->name }}</a>
                                    @else
                                        {{ __('Ürün') }}
                                    @endif
                                </h4>
                                <p><i class="fa fa-money"></i> {{ $sale->price() }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('Kimse bir şey satın almamış.') }}</p>
        @endif
    </div>
    <div class="widget widget-list">
        <div class="title">
            {{ __('En Vahşi Oyuncular') }}
        </div>
        @if ( $topKills->count() > 0 )
            <ul>
                @foreach ( $topKills as $statistic )
                    <li>
                        <a href="{{ route('profile.index', $statistic->user->username) }}" class="thumb"><img style="border-radius: 100%;" src="{{ $statistic->user->avatar(40) }}" alt="User Avatar"></a>
                        <div class="widget-list-meta row">
                            <div class="pull-left">
                                <span style="display: block; margin-top: 9px; margin-left: 10px;">
                                    <a href="{{ route('profile.index', $statistic->user->username) }}">{!! $statistic->user->prefixAndName() !!}</a>
                                </span>
                            </div>
                            <div class="pull-right text-right">
                                <h4 class="widget-list-title">{{ __(':kills Öldürme', ['kills' => $statistic->player_kills]) }}</h4>
                                <p><i class="fa fa-bolt"></i> {{ __(':deaths Ölüm', ['deaths' => $statistic->deaths ?: 0]) }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p>{{ __('Kimse kimseyi öldürmemiş.') }}</p>
        @endif
    </div>
    @if ( settings('lebby.ads_field') )
        <div class="widget widget-list">
            <div class="title">{{ __('Reklam') }}</div>
            {!! settings('lebby.ads_field') !!}
        </div>
    @endif 
</div>