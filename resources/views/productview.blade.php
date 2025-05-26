@section('title')
    Product View
@endsection

@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Product View</h3>
            </div>
        </div>

        <div class="container py-5">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    @if (!empty($product->image))
                        @php
                            $images = is_string($product->image) ? json_decode($product->image, true) : $product->image;
                        @endphp

                        @if (is_array($images))
                            @foreach ($images as $img)
                                <img src="{{ asset('storage/' . $img) }}" class="img-fluid rounded shadow"
                                    alt="Product Image">
                            @endforeach
                        @endif
                    @endif
                </div>

                <!-- Product Details -->
                <div class="col-md-6">
                    <h2>{{ $product->product_name }}</h2>

                    <!-- Ratings -->
                    <div class="mb-2 text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-muted">({{$product->total_sell}} Sell)</span>
                    </div>

                    <!-- Description -->
                    <p class="text-muted">{!! $product->description !!}</p>

                    <!-- Price -->
                    <h4 class="text-success mb-3"><i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ number_format($product->sell_price, 2) }}</h4>

                    <!-- Add to Cart -->
                    <form method="post" action="{{route('user.addtocard')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-center mb-3">
                            <label for="quentity" class="me-2">Qty:</label>
                            <input type="number" name="quentity" id="quentity" value="1" min="1"
                                class="form-control w-auto">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <input type="hidden" name="sell_price" value="{{$product->sell_price}}">
                        </div>
                        <button type="submit" class="btn btn-dark text-warning px-4 py-2">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>




    </div>
</div>
@include('include.footer')
