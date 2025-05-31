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

                                <a href="?status=Pending"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-info mb-3">Pending ({{$pendingOrder}})</button></a>
                                <a href="?status=Processing"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-success mb-3">Processing ({{$ProcessingOrder}})</button></a>
                                <a href="?status=Hold"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-dark mb-3">Hold ({{$HoldOrder}})</button></a>
                                <a href="?status=Packing"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-warning mb-3">Packing ({{$PackingOrder}})</button></a>
                                <a href="?status=Shipped"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-dark mb-3">Shipped ({{$ShippedOrder}})</button></a>
                                <a href="?status=Delivered"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-success mb-3">Delivered ({{$DeliveredOrder}})</button></a>
                                <a href="?status=Delivery_Failed"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-danger mb-3">Delivery_Failed ({{$Delivery_FailedOrder}})</button></a>
                                <a href="?status=Canceled"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-info mb-3">Canceled ({{$CanceledOrder}})</button></a>
                                <a href="?payment_status=Unpaid"><button style="margin:20px 0px;" type="button"
                                        class="btn btn-danger mb-3">Unpaid ({{$UnpaidOrder}})</button></a>
                            
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
                                            <th>Order Number</th>
                                            <th>Customer Info</th>
                                            <th>Price & Curior</th>
                                            <th>Image</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th>confirm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($customerInfo as $customer)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $customer->order_number }}</td>
                                                <td>
                                                    <p>{{ $customer->name }}</p>
                                                    <p>{{ Str::limit($customer->address, 10) }}
                                                    </p>
                                                    <p>0{{ $customer->phone }}</p>

                                                </td>
                                                @php
                                                    $total = $customer->total_paid + $customer->shipping_fee;
                                                @endphp
                                                <td>{{ $customer->total_paid }} + {{ $customer->shipping_fee }} <br>
                                                    Total: {{ number_format($total, 2) }}</td>
                                                <td>
                                                    @foreach ($customer->orderlist as $order)
                                                        @php
                                                            $product = $order->adminproduct;
                                                        @endphp
                                                        @if (!empty($product->image))
                                                            @php
                                                                $images = is_string($product->image)
                                                                    ? json_decode($product->image, true)
                                                                    : $product->image;
                                                            @endphp

                                                            @if (is_array($images))
                                                                @foreach ($images as $img)
                                                                    <img src="{{ asset('storage/' . $img) }}"
                                                                        height="100" width="100"
                                                                        class="img-fluid rounded shadow"
                                                                        alt="Product Image">
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                        {{-- <p>{{$order->adminproduct->sku}}</p> --}}
                                                    @endforeach
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($customer->order_create_time)->format('d M y') }}
                                                </td>
                                                <td>{{ $customer->status }}</td>
                                                <td>
                                                    <a class="from-control btn btn-info" href="{{ route('orderinfo',['order_number' => $customer->order_number]) }}">info</a>
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
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
