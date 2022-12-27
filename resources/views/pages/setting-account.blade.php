@extends('layouts.app')

@section('title')
    Store Dashboard
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
                                <li class="breadcrumb-item active">Account</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <!-- Isi Content -->
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12">
                        <form action="{{ route('setting-redirect', 'setting-account') }}" method="POST"
                            enctype="multipart/form-data" id="locations">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
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
                                                <input type="text" class="form-control" id="address_one"
                                                    name="address_one" value="{{ $user->address_one }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_two">Address 2</label>
                                                <input type="text" class="form-control" id="address_two"
                                                    name="address_two" value="{{ $user->address_two }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="provinces_id">Province</label>
                                                <select name="provinces_id" id="provinces_id" class="form-control"
                                                    v-if="provinces" v-model="provinces_id" required>
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
                                                <select name="regencies_id" id="regencies_id" class="form-control"
                                                    v-if="regencies" v-model="regencies_id" required>
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
                                                    value="{{ $user->zip_code }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" id="country" name="country"
                                                    value="{{ $user->country }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number">Mobile</label>
                                                <input type="number" class="form-control" id="phone_number"
                                                    name="phone_number" value="{{ $user->phone_number }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-danger">
                                                <p>*Pastikan Data Diri anda Benar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-4">
                                            <button class="btn btn-success btn-block">Save Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
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
