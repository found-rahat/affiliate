@section('title')
    Order Now
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Order Now</h3>
            </div>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="container">
            <div class="row">
                @foreach ($product_lists as $product)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card border-0 rounded-0 shadow" style="width: 100%;">

                            @if (!empty($product->image))
                                @php
                                    $images = is_string($product->image)
                                        ? json_decode($product->image, true)
                                        : $product->image;
                                @endphp

                                @if (is_array($images))
                                    @foreach ($images as $img)
                                    <a href="{{ route('user.productview', [ 'id'=> $product->id]) }}">
                                        <img src="{{ asset('storage/' . $img) }}" width="500" height="300" class="card-img-top rounded-0" alt="Product Image">
                                    </a>
                                    
                                    @endforeach
                                @endif
                            @endif
                            <div class="card-body mt-3 mb-3">
                                <div class="row">
                                    <div class="col-10">
                                        <a href="{{ route('user.productview', [ 'id'=> $product->id]) }} "><h4 class="card-title">{{ Str::limit($product->product_name, 30) }}</h4></a>
                                        
                                        <p class="card-text">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half"></i>
                                            ({{$product->total_sell}})
                                        </p>
                                    </div>
                                    <div class="col-2">
                                        <i class="bi bi-bookmark-plus fs-2"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center text-center g-0">
                                <div class="col-4">
                                    <h5><i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ $product->sell_price }}</h5>
                                </div>
                                <div class="col-8">
                                    <form action="{{ route('user.addviewclick')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-dark w-100 p-3 rounded-0 text-warning">ADD TO CART</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
@if (Session::has('success'))
    <script>
        setTimeout(function() {
            location.reload();
        }, 3000); // Reloads after 3 seconds
    </script>
@endif
    @include('include.footer')
