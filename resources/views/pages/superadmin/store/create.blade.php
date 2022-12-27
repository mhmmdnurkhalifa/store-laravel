@extends('layouts.admin')

@section('title')
    Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Store</h2>
                <p class="dashboard-subtitle">Create New Stores</p>
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
                                <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>User Name</label>
                                                @foreach ($stores as $store)
                                                @php
                                                    $idStore = $store->id
                                                @endphp
                                                @endforeach
                                                <select name="users_id" class="form-control" required>
                                                    <option hidden>Select User</option>
                                                    @foreach ($users as $user)
                                                        @if ($user->id != $idStore)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Store Name</label>
                                                <input type="text" name="store_name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Account Number / No Rekening</label>
                                                <input type="number" name="account_number" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Store Status</label>
                                                <select name="store_status" class="form-control" required>
                                                    <option hidden>Select Store Status</option>
                                                    <option value="1">Open</option>
                                                    <option value="0">CLosed</option>
                                                </select>
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
