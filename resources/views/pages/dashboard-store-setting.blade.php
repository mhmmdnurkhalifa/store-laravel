@extends('layouts.dashboard')

@section('title')
    Store Dashboard
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Store Settings</h2>
                <p class="dashboard-subtitle">Make store that profitable</p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('dashboard-store-setting-redirect', 'dashboard-setting-store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="users_id" value="{{ $user->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        @if (Auth::user()->id == $stores->users_id)
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Store Name</label>
                                                    <input type="text" class="form-control" name="store_name"
                                                        value="{{ $stores->store_name }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Account Number / Nomor Rekening</label>
                                                    <input type="number" class="form-control" name="account_number"
                                                        value="{{ $stores->account_number }}" />
                                                </div>
                                            </div>
                                        @endif
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="categories_id" class="form-control">
                                                    @if ($user->categories_id != null)
                                                        <option hidden value="{{ $user->categories_id }}">
                                                            {{ $user->category->name }}
                                                        </option>
                                                    @else
                                                    <option hidden value="{{ $user->categories_id }}">
                                                        Select Category
                                                    </option>
                                                    @endif
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Store</label>
                                                <p class="text-muted">
                                                    Apakah saat ini toko Anda buka?
                                                </p>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreTrue" value="1"
                                                        {{ $stores->store_status == '1' ? 'checked' : '' }} />
                                                    <label for="openStoreTrue" class="custom-control-label">
                                                        Open
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" class="custom-control-input" name="store_status"
                                                        id="openStoreFalse" value="0"
                                                        {{ $stores->store_status == '0' || $stores->store_status == null ? 'checked' : '' }} />
                                                    <label for="openStoreFalse" class="custom-control-label">
                                                        Closed
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="text-danger">
                                                    <p>*Pastikan Data anda Benar</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button class="btn btn-success px-5">Save Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
