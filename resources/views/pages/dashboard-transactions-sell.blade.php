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
                    @php
                        $totalPrice = 0;
                    @endphp
                    @foreach ($sellTransaction as $transaction)
                        @php
                            $totalPriceItem = $transaction->price * $transaction->qty;
                            $totalPrice += $totalPriceItem;
                        @endphp
                    @endforeach
                    Total Price Rp. {{ number_format($totalPrice) }}

                </p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12 mt-2">
                        <p style="font-weight: 500;font-size: 20px;line-height: 36px;color: #0c0d36;">
                            Detail Items
                        </p>

                        @foreach ($sellTransaction as $transaction)
                            <a href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                                class="card card-list d-block">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                                alt="" class="w-100" />
                                        </div>
                                        <div class="col-md-3">{{ $transaction->product->name }}</div>
                                        @php
                                            $totalPriceItem = $transaction->price * $transaction->qty;
                                        @endphp
                                        <div class="col-md-3">Rp. {{ number_format($totalPriceItem) }}</div>
                                        <div class="col-md-2">{{ $transaction->shipping_status }}
                                        </div>
                                        <div class="col-md-2">
                                            {{ date('d-m-Y', strtotime($transaction->created_at)) }}</div>
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
@endsection
