@section('title')
    About Us
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">About Us</h3>
            </div>
        </div>

        <div class="row">
            @foreach ($abouts as $item)
                <div class="col-md-3">
                    <div class="card card-profile">
                        <div class="card-header" style="background-image: url('user/assets/img/blogpost.jpg')">
                            <div class="profile-picture">
                                <div class="avatar avatar-xxl">
                                    <img style="margin-bottom:10px;" src="{{ asset('storage/' . $item->images) }}"
                                        alt="..." class="avatar-img rounded-circle" />
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="margin-top: 11px;" class="user-profile text-center">
                                <div class="name">{{ $item->name }}</div>
                                <div class="job">{{ $item->designation }}</div>
                                <div class="social-media">
                                    @if ($item->tw_url)
                                        <a target="_blank" class="btn btn-info btn-twitter btn-sm btn-link"
                                        href="{{ $item->tw_url }}">
                                        <span class="btn-label just-icon"><i class="icon-social-twitter"></i>
                                        </span>
                                    </a>
                                    @else
                                        <i class="fab fa-phoenix-squadron"></i>
                                    @endif
                                    @if ($item->fb_url)
                                        <a target="_blank" class="btn btn-primary btn-sm btn-link" rel="publisher"
                                        href="{{ $item->fb_url }}">
                                        <span class="btn-label just-icon"><i class="icon-social-facebook"></i>
                                        </span>
                                    </a>
                                    @else
                                        <i class="fab fa-phoenix-squadron"></i>
                                    @endif
                                    @if ($item->fb_url)
                                        <a target="_blank" class="btn btn-danger btn-sm btn-link" rel="publisher"
                                        href="{{ $item->linkin_url }}">
                                        <span class="btn-label just-icon"><i class="icon-social-linkedin"></i>
                                        </span>
                                    </a>
                                    @else
                                        <i class="fab fa-phoenix-squadron"></i>
                                    @endif
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@include('include.footer')
