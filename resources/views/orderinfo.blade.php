@section('title')
    Order Info
@endsection

@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <form action="{{ route('infoUpdate') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card alert-black">
                <div class="card-header">
                    @foreach ($query as $customer)
                        <h1 class="card-title text-center text"> <span style="font-size: 30px"
                                class="form-control btn-warning">Order Number: {{ $customer->order_number }}</span>
                        </h1>
                    @endforeach
                </div>
            </div>
            {{-- --------------------Customer info-------------- --}}
            <div class="card alert-success">
                <div class="card-header">
                    <h4 class="card-title">Customer Info</h4>
                </div>
                @foreach ($query as $customer)
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="fullName" class="form-label">Customer Name</label>
                                <input type="hidden" name="order_number" value="{{ $customer->order_number }}">
                                <input name="name" value="{{ $customer->name }}" type="text" class="form-control"
                                    id="fullName" placeholder="Customer Name" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phonenumber" class="form-label">Phone Number</label>
                                <input name="phone_number" value="0{{ $customer->phone }}" type="number"
                                    class="form-control" id="number" placeholder="Phone Number" required>
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address </label>
                                <textarea name="address" type="text" class="form-control" required id="shippingAddress" placeholder="Full Address"
                                    required cols="10" rows="2">{{ $customer->address }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="note" class="form-label">Note ( optional )</label>
                                <textarea name="note" type="text" class="form-control" cols="30" placeholder="Some note" rows="2">{{ $customer->order_note }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- --------------------delivery info-------------- --}}
            <div class="card alert-info">
                <div class="card-header">
                    <h4 class="card-title">Delivery Info</h4>
                </div>

                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="Curiorservice" class="form-label">Curior Service</label>
                            <select name="curior" class="form-control form-select">
                                <option value="">!!!----Select Courier Service----</option>
                                @foreach ($curior as $cost)
                                    <option value="{{ $cost->title }}">
                                        {{ $cost->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @foreach ($query as $delivery)
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Delivery Charge</label>
                                <input type="text" class="form-control" value="{{ $delivery->shipping_fee }} Taka"
                                    placeholder="Status" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Delivery Provider</label>
                                <input type="text" class="form-control"
                                    value="{{ $delivery->shipping_provider }} Taka" placeholder="Status" disabled>
                            </div>
                            @if (!empty($delivery->shipping_provider_delivery_code))
                                <div class="col-md-4 mb-3">
                                    <label class="form-label"></label>
                                    <a type="button" class="form-control btn btn-danger" href="#">Product
                                        Track</a>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Delivery Provider Code</label>
                                    <input type="text" class="form-control"
                                        value="{{ $delivery->shipping_provider_delivery_code }}"
                                        placeholder="Delivery Provider Code" disabled>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- --------------------Product Info--------------- --}}
            <div class="card alert-danger">
                <div class="card-header">
                    <h4 class="card-title">Product Info</h4>
                </div>
                <div class="table-responsive">
                    <table class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Product id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $product)
                                @foreach ($product->orderlist as $order)
                                    <tr>
                                        <td>{{ $order->product_id }}</td>
                                        <td>
                                            <p>{{ Str::limit($order->adminproduct->product_name, 30) }}
                                            </p>
                                        </td>
                                        <td>{{ $order->adminproduct->sell_price }}</td>
                                        <td>
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
                                                        <img src="{{ asset('storage/' . $img) }}" height="100"
                                                            width="100" class="img-fluid rounded shadow"
                                                            alt="Product Image">
                                                    @endforeach
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $order->item_quentity }}</td>
                                        <td>{{ $order->unit_price }}</td>

                                        <td>{{ $order->paid_price }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- -------------------Old Order Info-------------- --}}
            <div class="card alert-black">
                <div class="card-header">
                    <h4 class="card-title">Old Order Info</h4>
                </div>
                <div class="table-responsive">
                    <table class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10</td>
                                <td>
                                    <p>{{ Str::limit('Mirpur 1 dhaka 1216 naryangang madanpur kolabagan khan monjil uttara', 30) }}
                                    </p>
                                </td>
                                <td>
                                    <img src="" alt="" height="100" width="100">
                                </td>
                                <td>5</td>
                                <td>300</td>
                                <td>1500</td>
                                <td>Delivery</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>
                                    <p>{{ Str::limit('Mirpur 1 dhaka 1216 naryangang madanpur kolabagan khan monjil uttara', 30) }}
                                    </p>
                                </td>
                                <td>
                                    <img src="" alt="" height="100" width="100">
                                </td>
                                <td>5</td>
                                <td>300</td>
                                <td>1500</td>
                                <td>Processing</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- --------------------Payment info--------------- --}}
            <div class="card alert-info">
                <div class="card-header">
                    <h4 class="card-title">Payment Info</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        @foreach ($query as $product)
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Total Price</label>
                                <input type="text" class="form-control" value="{{ $product->total_paid }} Taka"
                                    placeholder="Status" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Delivery Charge</label>
                                <input type="text" class="form-control" value="{{ $product->shipping_fee }} Taka"
                                    placeholder="Status" disabled>
                            </div>
                            @php
                                $pre_payment = $customer->pre_payment ?? 0;
                                $discount = $customer->discount ?? 0;
                            @endphp
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Discount</label>
                                <input type="text" name="discount" class="form-control"
                                    value="{{ $discount }} taka" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Pre Payment</label>
                                <input type="text" name="pre_payment" class="form-control"
                                    value="{{ $pre_payment }} taka" disabled>
                            </div>




                            <div class="col-md-2 mb-3">
                                <label class="form-label">Grand Total</label>
                                @php
                                    $total =
                                        $product->total_paid +
                                        $product->shipping_fee -
                                        $product->discount -
                                        $product->pre_payment;
                                @endphp
                                <input type="text" class="form-control" value="{{ $total }} taka"
                                    disabled>
                            </div>
                            @if ($product->status == 'Pending')
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Update Payment</label>

                                    <a class="form-control btn btn-secondary"
                                        href="{{ route('prepayment', ['order_number' => $customer->order_number]) }}">Pay
                                        now</a>


                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ------------------Confirm Button--------------- --}}
            <div class="card alert-success">
                <div class="card-header">
                    <h4 class="card-title">Confirmation</h4>
                </div>

                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <button type="submit" class=" form-control btn btn-info ">Update</button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class=" form-control btn btn-dark ">Hold</button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class=" form-control btn btn-danger ">Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@include('include.footer')
