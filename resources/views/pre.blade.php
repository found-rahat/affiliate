@section('title')
    Blank Page
@endsection

@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="card alert-black">
            <div class="card-header">
                @foreach ($query as $customer)
                    <h1 class="card-title text-center text"> <span style="font-size: 30px"
                            class="form-control btn-warning">Order Number: {{ $customer->order_number }}</span> </h1>
                @endforeach
            </div>
        </div>

        <div class="card alert-success">
            <div class="card-header">
                <h4 class="card-title">Customer Info</h4>
            </div>
            @foreach ($query as $customer)
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fullName" class="form-label">Customer Name</label>
                            <input name="name" value="{{ $customer->name }}" type="text" class="form-control"
                                id="fullName" disabled placeholder="Customer Name" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="phonenumber" class="form-label">Phone Number</label>
                            <input name="phone_number" value="0{{ $customer->phone }}" type="number"
                                class="form-control" id="number" disabled placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Order Date</label>
                            <input type="text" class="form-control" value="{{ $customer->order_create_time }}"
                                placeholder="Order Date" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="{{ $customer->status }}"
                                placeholder="Status" disabled>
                        </div>
                        @if (!empty($customer->shipped_time))
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Shpping Time</label>
                                <input type="text" class="form-control" value="{{ $customer->shipped_time }}"
                                    placeholder="Shipping Time" disabled>
                            </div>
                        @endif

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Order User</label>
                            <input type="text" class="form-control" value="{{ $customer->user->name }}"
                                placeholder="Order User" disabled>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <div class="card alert-info">
            <div class="card-header">
                <h4 class="card-title">Payment Info</h4>
            </div>
            @foreach ($query as $product)
                <form action="{{ route('prepaymentUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4">
                        <div class="row">


                            <div class="col-md-2 mb-3">
                                <label class="form-label">Total Price</label>
                                <input type="text" class="form-control" value="{{ $product->total_paid }} Taka"
                                    placeholder="Status" disabled>
                            </div>
                            <input type="hidden" name="order_number" value="{{ $product->order_number }}">
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Delivery Charge</label>
                                <input type="text" class="form-control" value="{{ $product->shipping_fee }} Taka"
                                    placeholder="Status" disabled>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Discount</label>
                                <input type="number" name="discount" class="form-control"
                                    value="{{ $product->discount }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pre Payment</label>
                                <input type="number" name="pre_payment" class="form-control"
                                    value="{{ $product->pre_payment }}">
                            </div>

                            

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Grand Total</label>
                                @php
                                    $total = $product->total_paid - $product->discount - $product->pre_payment + $product->shipping_fee;
                                @endphp
                                <input type="text" class="form-control" value="{{ $total }} taka" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Update Payment</label>
                                <button type="submit" class="form-control btn btn-secondary">Update payment</button>

                            </div>


                        </div>
                    </div>
                </form>
            @endforeach
        </div>


    </div>
</div>
@include('include.footer')
