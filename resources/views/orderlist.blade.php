@section('title')
    Order List
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">

        <div class="row">
            <div>
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <div class="card alert-success">
                    <center>
                        <div class="card-header">
                            <a href="?status=pending"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-info mb-3">Pending ()</button></a>
                            <a href="?status=processing"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-success mb-3">Processing ()</button></a>
                            <a href="?status=Hold"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-dark mb-3">Hold ()</button></a>
                            <a href="?status=Packing"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-warning mb-3">Packing ()</button></a>
                            <a href="?status=Shipped"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-dark mb-3">Shipped ()</button></a>
                            <a href="?status=Delivered"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-success mb-3">Delivered ()</button></a>
                            <a href="?status=delivery_Failed"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-danger mb-3">Delivery_Failed ()</button></a>
                            <a href="?status=canceled"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-info mb-3">Canceled ()</button></a>
                            <a href="?payment_status=unpaid"><button style="margin:20px 0px;" type="button"
                                    class="btn btn-danger mb-3">Unpaid ()</button></a>
                        </div>
                    </center>
                </div>
                <div class="col-md-12">
                    <div class="card alert-black">

                        <div class="card-header">
                            <h4 class="card-title">Order list</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Customer Info</th>
                                            <th>Price & Curior</th>
                                            <th>Image</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th>confirm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <p>Md. Rahat Ahmed</p>
                                                <p>{{ Str::limit('Mirpur 1 dhaka 1216 naryangang madanpur kolabagan khan monjil uttara', 10) }}
                                                </p>
                                                <p>01980851423</p>

                                            </td>
                                            <td>250 + 60 = 310</td>
                                            <td>
                                                <img src="" alt="" height="100" width="100">
                                            </td>
                                            <td>15 Apr 2025</td>
                                            <td>Pending</td>
                                            <td>
                                                <a class="from-control btn btn-info"
                                                    href="{{ route('orderinfo') }}">info</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <p>Md. Rahat Ahmed</p>
                                                <p>{{ Str::limit('Mirpur 1 dhaka 1216 naryangang madanpur kolabagan khan monjil uttara', 10) }}
                                                </p>
                                                <p>01980851423</p>

                                            </td>
                                            <td>250 + 60 = 310</td>
                                            <td>
                                                <img src="" alt="" height="100" width="100">
                                            </td>
                                            <td>15 Apr 2025</td>
                                            <td>Pending</td>
                                            <td>
                                                <a class="from-control btn btn-info"
                                                    href="{{ route('orderinfo') }}">info</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (Session::has('success'))
            <script>
                setTimeout(function() {
                    location.reload();
                }, 1000); // Reloads after 1 seconds
            </script>
        @endif
        @include('include.footer')
