@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transaction
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Transactions</h2>
                <p class="dashboard-subtitle">
                    Big result start from the small one
                </p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12 mt-2">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="sell-tab" data-toggle="pill" data-target="#sell"
                                    type="button" role="tab" aria-controls="sell" aria-selected="true">
                                    Sell Product
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="buy-tab" data-toggle="pill" data-target="#buy" type="button"
                                    role="tab" aria-controls="buy" aria-selected="false">
                                    Buy Product
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="sell" role="tabpanel" aria-labelledby="sell-tab"
                                tabindex="0">
                                @foreach ($sellTransaction as $transaction)
                                    <a href="{{ route('dashboard-transaction-sell', $transaction->transaction->id) }}"
                                        class="card card-list d-block">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">{{ $transaction->transaction->user->name }}</div>
                                                <div class="col-md-3">
                                                    {{ date('d-m-Y', strtotime($transaction->transaction->created_at)) }}
                                                </div>
                                                <div class="col-md-3">Rp. {{ number_format($transaction->price) }}</div>
                                                <div class="col-md-2">{{ $transaction->transaction->transaction_status }}
                                                </div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/dashboard-anow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="buy" role="tabpanel" aria-labelledby="buy-tab"
                                tabindex="0">
                                @foreach ($buyTransaction as $transaction)
                                    <a href="{{ route('dashboard-transaction-buy', $transaction->id) }}"
                                        class="card card-list d-block">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">{{ $transaction->user->name }}</div>
                                                <div class="col-md-3">
                                                    {{ date('d-m-Y', strtotime($transaction->created_at)) }}</div>
                                                <div class="col-md-3">Rp. {{ number_format($transaction->total_price) }}</div>
                                                <div class="col-md-2">{{ $transaction->transaction_status }}</div>
                                                <div class="col-md-1 d-none d-md-block">
                                                    <img src="/images/dashboard-anow-right.svg" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="dashboard-content">
                <div class="row">
                    <div class="col-12 mt-2">
                        @foreach ($transactions as $transaction)
                            <a href="{{ route('dashboard-transaction-items', $transaction->id) }}"
                                class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">{{ $transaction->user->name }}</div>
                                        <div class="col-md-3">
                                            {{ date('d-m-Y', strtotime($transaction->created_at)) }}</div>
                                        <div class="col-md-3">${{ number_format($transaction->total_price) }}</div>
                                        <div class="col-md-2">{{ $transaction->transaction_status }}</div>
                                        <div class="col-md-1 d-none d-md-block">
                                            <img src="/images/dashboard-anow-right.svg" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>


                </div>
            </div> --}}
        </div>
    </div>
    </div>
@endsection
