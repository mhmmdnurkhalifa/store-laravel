@extends('layouts.admin')

@section('title')
    Product Gallery
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Product</h2>
                <p class="dashboard-subtitle">List of Gallery</p>
            </div>

            <!-- Isi Content -->
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-rensponsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Total Price</th>
                                                <th>No Rekening</th>
                                                <th>Transaction Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'store.user.name',
                    name: 'store.user.name'
                },
                {
                    data: 'price',
                    name: 'price',
                },
                {
                    data: 'store.account_number',
                    name: 'store.account_number'
                },
                {
                    data: 'shipping_status',
                    name: 'shipping_status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searcable: false,
                    width: '15%'
                }
            ],
            order: [
                [0, 'desc']
            ]

        });
        datatable.on('order.dt search.dt', function() {
            let i = 1;

            datatable.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    </script>
@endpush
