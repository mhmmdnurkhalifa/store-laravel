@extends('layouts.admin')

@section('title')
    Product
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Product</h2>
                <p class="dashboard-subtitle">Edit Product</p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('product.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $product->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Store</label>
                                                <select name="stores_id" class="form-control">
                                                    <option hidden value="{{ $product->stores_id }}" selected>
                                                        {{ $product->store->store_name }}
                                                    </option>
                                                    @foreach ($stores as $store)
                                                        @if ($store->store_status == 1)
                                                            <option value="{{ $store->id }}">{{ $store->store_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="categories_id" class="form-control">
                                                    <option hidden value="{{ $product->categories_id }}" selected>
                                                        {{ $product->category->name }}
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Product Price</label>
                                                <input type="number" name="price" min="1" class="form-control"
                                                    value="{{ $product->price }}" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <input type="number" min="1" class="form-control" name="qty"
                                                        value="{{ $product->qty }}" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="editor">
                                                    {!! $product->description !!}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5"
                                                onclick="document.getElementById('meimg').required = false;">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor");
    </script>
@endpush
