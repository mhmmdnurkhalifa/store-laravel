@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transaction Detail
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">#{{ $transaction->code }}</h2>
                <p class="dashboard-subtitle">Transactions Details</p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content" id="transactionDetails">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                            alt="" class="w-100 mb-3" />
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Customer Name</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->product->user->name }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Product Name</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->product->name }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Mobile</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->phone_number }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">
                                                    Date of Transaction
                                                </div>
                                                <div class="product-subtitle">
                                                    {{ date('d-m-Y', strtotime($transaction->created_at)) }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Quantity</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->qty }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Price</div>
                                                <div class="product-subtitle">
                                                    Rp. {{ number_format($transaction->price) }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Payment Status</div>
                                                <div class="product-subtitle text-danger">
                                                    {{ $transaction->transaction->transaction_status }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Total Amount</div>
                                                <div class="product-subtitle">
                                                    @php
                                                        $totalPrice = $transaction->price * $transaction->qty;
                                                    @endphp
                                                    Rp. {{ number_format($totalPrice) }}</div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('dashboard-transaction-update', $transaction->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <h5>Shipping Information</h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Address I</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->address_one }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Address II</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->address_two }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Province</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Province::find($transaction->provinces_id)->name ?? ''}}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">City</div>
                                                    <div class="product-subtitle">
                                                        {{ App\Models\Regency::find($transaction->regencies_id)->name ?? ''}}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Postal Code</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->zip_code }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Country</div>
                                                    <div class="product-subtitle">
                                                        {{ $transaction->country }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="product-title">Shipping Status</div>
                                                    @if (Auth::user()->id == $transaction->product->user->id)
                                                        <select name="shipping_status" id="status" class="form-control"
                                                            v-model="status">
                                                            <option value="PENDING">Pending</option>
                                                            <option value="CANCEL">Cancel</option>
                                                            <option value="SHIPPING">Shipping</option>
                                                            <option value="SUCCESS">Success</option>
                                                        </select>
                                                    @else
                                                        <div class="product-subtitle">
                                                            {{ $transaction->shipping_status }}</div>
                                                    @endif
                                                </div>
                                                @if (Auth::user()->id == $transaction->product->user->id)
                                                    <template v-if="status =='SHIPPING'">
                                                        <div class="col-md-4">
                                                            <div class="product-title">Input Resi</div>
                                                            <input type="text" class="form-control" name="resi"
                                                                v-model="resi" />
                                                        </div>
                                                    </template>
                                                @else
                                                    <div class="col-md-4">
                                                        <div class="product-title">Resi</div>
                                                        <div class="product-subtitle">
                                                            @if ($transaction->resi != null)
                                                                {{ $transaction->resi }}
                                                            @else
                                                                -
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::user()->id == $transaction->product->user->id)
                                        @if ($transaction->shipping_status != 'SUCCESS')
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success btn-block mt-4">
                                                        Save Now
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (Auth::user()->id == $transaction->transaction->user->id)
                                        @if ($transaction->shipping_status != 'CANCEL' && $transaction->shipping_status != 'SHIPPING' && $transaction->shipping_status != 'SUCCESS')
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" name="shipping_status" value="CANCEL" class="btn btn-danger btn-block mt-4">
                                                        Cancel Shipping
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
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
    <script src="/vendor/vue/vue.js"></script>
    <script>
        var transactionDetails = new Vue({
            el: "#transactionDetails",
            data: {
                status: "{{ $transaction->shipping_status }}",
                resi: "{{ $transaction->resi }}",
            },
        });
    </script>
@endpush
