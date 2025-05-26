@section('title')
    Add to Card
@endsection

@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Add to Card</h3>
            </div>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <form method="POST" action="{{ route('user.cart.update') }}">
            @csrf

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Product Image</th>
                        <th>Price (<i class="fa-solid fa-bangladeshi-taka-sign"></i>)</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($cartItems as $item)
                        @php
                            $price = (float) $item->sell_price;
                            $qty = (int) $item->quentity;
                            $total = $price * $qty;
                            $grandTotal += $total;
                        @endphp
                        <tr>
                            <td>{{ Str::limit($item->product->product_name, 30) }}</td>
                            <td>
                                @if (!empty($item->product->image))
                                    @php
                                        $images = is_string($item->product->image)
                                            ? json_decode($item->product->image, true)
                                            : $item->product->image;
                                    @endphp

                                    @if (is_array($images))
                                        @foreach ($images as $img)
                                            <img src="{{ asset('storage/' . $img) }}" height="100" width="100"
                                                class="img-fluid rounded shadow" alt="Product Image">
                                        @endforeach
                                    @endif
                                @endif
                            </td>
                            <td>
                                <input type="number" name="prices[{{ $item->id }}]"
                                    value="{{ $item->sell_price }}"step="0.01" min="0" class="form-control" />
                            </td>
                            <td>
                                <input type="number"
                                    name="quantities[{{ $item->id }}]"value="{{ $item->quentity }}" min="1"
                                    class="form-control" />
                            </td>
                            <td><i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($total, 2) }}</td>
                            <td><a class="form-control btn btn-danger"
                                    href="{{ route('user.addcarddelete', ['id' => $item->id]) }}"
                                    onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                            </td>
                        </tr>

                    @endforeach
                    <tr>
                        {{-- <td></td>
                        <td></td>
                        <td></td> --}}
                        <td colspan="4">Grand Total: </td>
                        <td><i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($grandTotal, 2) }} </td>
                        <td><button type="submit" class="form-control btn btn-primary">Update Cart</button> </td>

                    </tr>
                </tbody>
            </table>

            <div class="text-end fw-bold">

            </div>

            <div class="text-end mt-3">

            </div>
        </form>
        <form action="">
            <div class="card p-4">
                <h4 class="card-title mb-3">Order Details</h4>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input name="name" type="text" class="form-control" id="fullName" placeholder="Customer Name" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input name="phone_number"  type="text" class="form-control" id="number" placeholder="Phone Number" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Curiorservice" class="form-label">Curior Service</label>
                        <select name="curior" class="form-control form-select">
                            <option value="">!!!----Select Curior Service----!!!</option>
                            <option value="SparkX_60">Home_Delivery_Inside-Dhaka_60tk</option>
                            <option value="Patho_60">Patho_Inside-Dhaka_65tk</option>
                            <option value="DeliveryTiger_35">DeliveryTiger_Inside-Dhaka_35tk</option>
                            <option value="">--</option>
                            <option value="Patho_100">Patho_Dhaka-SubArea_100tk - 2-3 days</option>
                            <option value="DeliveryTiger_60">DeliveryTiger_Dhaka-SubArea_60tk</option>
                            <option value="">--</option>
                            <option value="Sundorbon">Sundorbon-Courier-Service_130Tk </option>
                            <option value="SA_Paribahan">Sa-Probahon_150Tk</option>
                            <option value="Patho_100">Patho_Outside-Dhaka_100tk - 4-7 days</option>
                            <option value="DeliveryTiger_100">DeliveryTiger_Outside-Dhaka_80tk 5-10 days
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address </label>
                        <textarea name="address" type="text" class="form-control" required id="shippingAddress" placeholder="Full Address" required cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="note" class="form-label">Note ( optional )</label>
                        <textarea name="note" type="text" class="form-control" id="note" required cols="30" placeholder="Some note" rows="10"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Order</button>
            </div>
        </form>
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
