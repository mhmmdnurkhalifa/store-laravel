@extends('layouts.dashboard')

@section('title')
    Store Dashboard Product
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Products</h2>
                <p class="dashboard-subtitle">Manage it well and get money</p>
            </div>
            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('dashboard-product-create') }}" class="btn btn-success">Add New Product</a>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-4">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="row mt-4">
                    @foreach ($products as $product)
                        <div class="col-12 col-sn-6 col-md-4 col-lg-3">
                            <a href="{{ route('dashboard-product-details', $product->id) }}"
                                class="card card-dashboard-product d-block">
                                <div class="card-body">

                                    <div class="product-thumbnail">
                                        <div class="product-image"
                                            style="
                                        @if ($product->galleries->count()) background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                        @else background-image:#eee @endif;">
                                        </div>
                                    </div>
                                    <div class="product-title">{{ $product->name }}</div>
                                    <div class="product-category">Rp. {{ number_format($product->price) }}</div>
                                    <div class="product-category">Quantity {{ $product->qty }}</div>
                                    {{-- <div class="product-category">{{ $product->category->name }}</div> --}}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
