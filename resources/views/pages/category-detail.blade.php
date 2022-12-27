@extends('layouts.app')

@section('title')
    Store Category Page
@endsection

@section('content')
    <div class="page-content page-home">
        <!-- all-products -->
        <section class="store-new-products">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h5>All product categories {{ $category->slug }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-4 justify-content-center">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <div class="row">
                    @php
                        $incrementProduct = 0;
                    @endphp
                    @forelse ($products as $product)
                        @if ($product->store->store_status == 1)
                            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up"
                                data-aos-delay="{{ $incrementProduct += 100 }}">
                                <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                                    <div class="products-thumbnail">
                                        <div class="products-image"
                                            style="
                                        @if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else background-image:#eee @endif;">
                                        </div>
                                    </div>
                                    <div class="products-text">{{ $product->name }}</div>
                                    <div class="products-price">Rp. {{ number_format($product->price) }}</div>
                                </a>
                            </div>
                        @endif
                    @empty
                        <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                            No Products Found
                        </div>
                    @endforelse

                </div>
                
            </div>
        </section>
    </div>
@endsection
