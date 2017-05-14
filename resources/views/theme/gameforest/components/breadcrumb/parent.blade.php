<section class="bg-grey-50 border-bottom-1 border-grey-300 padding-top-10 padding-bottom-10">
    <div class="container">
        <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
            @include('components.breadcrumb.block', [
                'position' => 1,
                'name' => __('Anasayfa'),
                'url' => route('home')
            ])

            {{ $slot }}
        </ol>
    </div>
</section>