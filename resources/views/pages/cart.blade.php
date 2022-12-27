@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
    <!-- Page Content -->
    <div class="page-content page-cart">
        <!-- breadcrumbs -->
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Content -->
        <section class="store-cart">
            <div class="container">
                <!-- Tabel Pesanan -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Name &amp; Seller</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <td>Menu</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                    @if ($cart->product->qty > 0)
                                        <tr>
                                            <td style="width: 20%">
                                                <img src="{{ Storage::url($cart->product->galleries->first()->photos ?? '') }}"
                                                    alt="" class="cart-image" />
                                            </td>
                                            <td>
                                                <div class="product-title">{{ $cart->product->name }}</div>
                                                <div class="product-subtitle">{{ $cart->store->store_name }}</div>
                                            </td>
                                            <td>
                                                <div class="product-title">{{ $cart->qty }}</div>
                                                <div class="product-subtitle">Pcs</div>
                                            </td>
                                            <td>
                                                <div class="product-title">
                                                    @php
                                                        $totalPriceItem = $cart->product->price * $cart->qty;
                                                    @endphp
                                                    Rp. {{ number_format($totalPriceItem) }}</div>
                                                <div class="product-subtitle">IDR</div>
                                            </td>
                                            <td style="width: 20%">
                                                <form action="{{ route('cart-delete', $cart->product->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-remove-cart"> Remove </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                            $totalPrice += $totalPriceItem;
                                        @endphp
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pesanan -->
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-4">Shipping Details</h2>
                    </div>
                </div>
                <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
                    @csrf
                    @php
                        $total = ($totalPrice * 10) / 100 + $totalPrice;
                    @endphp
                    <input type="hidden" name="total_price" value="{{ $total }}">
                    <!-- Form Pesanan -->
                    <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_one">Address 1</label>
                                <input type="text" class="form-control" id="address_one" name="address_one"
                                    value="{{ $user->address_one }}"required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_two">Address 2</label>
                                <input type="text" class="form-control" id="address_two" name="address_two"
                                    value="{{ $user->address_two }}" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provinces_id">Province</label>
                                <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces"
                                    v-model="provinces_id" required>
                                    <option hidden :value="province_id">
                                        {{ App\Models\Province::find($user->provinces_id)->name ?? 'Select Province' }}
                                    </option>
                                    <option v-for="province in provinces" :value="province.id">
                                        @{{ province.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="regencies_id">City</label>
                                <select name="regencies_id" id="regencies_id" class="form-control"v-if="regencies"
                                    v-model="regencies_id" required>
                                    <option hidden :value="regencies_id">
                                        {{ App\Models\Regency::find($user->regencies_id)->name ?? 'Select Regency' }}
                                    </option>
                                    <option v-for="regency in regencies" :value="regency.id">
                                        @{{ regency.name }}
                                    </option>
                                </select>
                                <select v-else class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="zip_code">Postal Code</label>
                                <input type="number" class="form-control" id="zip_code" name="zip_code"
                                    value="{{ $user->zip_code }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="{{ $user->country }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Mobile</label>
                                <input type="number" class="form-control" id="phone_number" name="phone_number"
                                    value="{{ $user->phone_number }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-danger">
                                <p>*Pastikan Data Diri anda Benar</p>
                            </div>
                        </div>
                    </div>

                    @if ($carts->first() != null)
                        <!-- Pembayaran -->
                        <div class="row" data-aos="fade-up" data-aos-delay="150">
                            <div class="col-12">
                                <hr />
                            </div>
                            <div class="col-12">
                                <h2 class="mb-2">Payment Informations</h2>
                            </div>
                        </div>
                        <!-- Total Pembayaran -->
                        <div class="row" data-aos="fade-up" data-aos-delay="200">
                            <div class="col-12 col-md-6">
                                <div class="product-title text-danger">Total belanja belum termasuk ongkos kirim</div>
                                <div class="product-subtitle">Ongkos kirim di tanggung pembeli</div>
                                <div class="product-subtitle">Pihak toko akan menghubungi pembeli mangenai ongkos kirim
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="product-title">Pajak Pembelian</div>
                                <div class="product-subtitle">
                                    10%
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="product-title text-success">$
                                    {{ number_format($total ?? 0) }}
                                </div>
                                <div class="product-subtitle">Total</div>
                            </div>

                            <div class="col-8 col-md-2">
                                <button type="submit" class="btn btn-success mt-4 btn-block">
                                    Checkout Now
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        var locations = new Vue({
            el: "#locations",
            mounted() {
                AOS.init();
                this.getProvincesData();
                this.getRegenciesData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            console.log(response.data);
                            self.regencies = response.data;
                        })
                }
            },
            watch: {
                provinces_id: function(val, oldVal) {
                    this.regencies_id = null;
                    this.getRegenciesData();
                }
            }
        });
    </script>
@endpush
