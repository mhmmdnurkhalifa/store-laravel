@extends('layouts.admin')

@section('title')
    Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Store</h2>
                <p class="dashboard-subtitle">Edit Store</p>
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
                                <form action="{{ route('store.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="store_name" class="form-control" value="{{ $item->user->name }}" disabled required>
                                            </div>
                                            <div class="form-group">
                                                <label>Store Name</label>
                                                <input type="text" name="store_name" class="form-control" value="{{ $item->store_name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number / No Rekening</label>
                                                <input type="number" name="account_number" class="form-control" value="{{ $item->account_number }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Store Status</label>
                                                <p class="text-muted">
                                                    Apakah saat ini tokonya buka?
                                                </p>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreTrue" value="1"
                                                        {{ $item->store_status == '1' ? 'checked' : '' }} />
                                                    <label for="openStoreTrue" class="custom-control-label">
                                                        Ya
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreFalse" value="0"
                                                        {{ $item->store_status == '0' || $item->store_status == null ? 'checked' : '' }} />
                                                    <label for="openStoreFalse" class="custom-control-label">
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
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
