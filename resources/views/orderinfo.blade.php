@section('title')
    Order Info
@endsection

@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <form action="">
            <div class="card alert-black">
                <div class="card-header">
                    <h1 class="card-title text-center text"> <span style="font-size: 30px" class="form-control btn btn-warning">Order Number: Ds1234</span> </h1>
                </div>
            </div>
            {{-- --------------------Customer info-------------- --}}
            <div class="card alert-success">
                <div class="card-header">
                    <h4 class="card-title">Customer Info</h4>
                </div>

                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fullName" class="form-label">Customer Name</label>
                            <input name="name" type="text" class="form-control" id="fullName"
                                placeholder="Customer Name" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="phonenumber" class="form-label">Phone Number</label>
                            <input name="phone_number" type="number" class="form-control" id="number"
                                placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Order Date</label>
                            <input type="text" class="form-control" value="15 April 25" placeholder="Order Date"
                                disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="Pending" placeholder="Status" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shpping Time</label>
                            <input type="text" class="form-control" value="16 April 25" placeholder="Shipping Time"
                                disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Order User</label>
                            <input type="text" class="form-control" value="Rahat120" placeholder="Order User"
                                disabled>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address </label>
                            <textarea name="address" type="text" class="form-control" required id="shippingAddress" placeholder="Full Address"
                                required cols="10" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="note" class="form-label">Note ( optional )</label>
                            <textarea name="note" type="text" class="form-control" id="note" required cols="30"
                                placeholder="Some note" rows="2"></textarea>
                        </div>
                    </div>
                </div>
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Delivery Charge</label>
                            <input type="text" class="form-control" value="60 Taka" placeholder="Status" disabled>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"></label>
                            <a type="button" class="form-control btn btn-danger" href="#">Product Track</a>

                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="Curiorservice" class="form-label">Delivery Provider</label>
                            <select name="curior" class="form-control form-select">
                                <option value="">!!!----Select Delivery Provider----!!!</option>
                                <option value="Pathao">Pathao</option>
                                <option value="Redx">Redx</option>
                                <option value="DeliveryTiger_35">StreatFast</option>
                                <option value="DeliveryTiger_35">Daraz Rider</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Delivery Provider Code</label>
                            <input type="text" class="form-control" value="ErcDfr453456"
                                placeholder="Delivery Provider Code" disabled>
                        </div>
                    </div>
                </div>
            </div>
            {{-- -----------------------------------Product Info--------------------------- --}}
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
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
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
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            {{-- -----------------------------------Old Order Info--------------------------- --}}
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
            {{-- --------------------Payment info-------------- --}}
            <div class="card alert-info">
                <div class="card-header">
                    <h4 class="card-title">Payment Info</h4>
                </div>

                <div class="p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Total Price</label>
                            <input type="text" class="form-control" value="500 Taka" placeholder="Status"
                                disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Discount</label>
                            <input type="text" class="form-control" value="100 Taka" placeholder="Status"
                                >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Pre Payment</label>
                            <input type="nmber" class="form-control" value="100 Taka" placeholder="Status">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Grand Total</label>
                            <input type="text" class="form-control" value="300 taka"
                                placeholder="Delivery Provider Code" disabled>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card alert-success">
                <div class="card-header">
                    <h4 class="card-title">Confirmation</h4>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href=""><button type="button"
                                    class=" form-control btn btn-info ">Update</button></a>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                            <a href=""><button type="button"
                                    class=" form-control btn btn-success ">Confirm</button></a>
                        </div> --}}

                        <div class="col-md-4 mb-3">
                            <a href=""><button type="button"
                                    class=" form-control btn btn-dark ">Hold</button></a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href=""><button type="button"
                                    class=" form-control btn btn-danger ">Cancel</button></a>
                        </div>
                    </div>
                </div>

            </div>

        </form>








    </div>
</div>
@include('include.footer')
