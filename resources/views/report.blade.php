@section('title')
    Report
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Report Us</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Report Form</div>
                    </div>
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <form action="{{ route('report.authenticate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="">
                                <div style="float: left" class="form-group col-md-6 col-lg-6">
                                    <label for="largeSelect">Type</label>
                                    <select name="type" class="form-select form-control-lg" id="largeSelect">
                                        <option>---Selection Type---</option>
                                        <option value="Product Problem">Product Problem</option>
                                        <option value="Payment Issue">Payment Issue</option>
                                        <option value="Delivery Problem">Delivery Problem</option>
                                        <option value="Other">Other</option>
                                    </select>

                                </div>

                                <div style="float: left" class="form-group col-md-6 col-lg-6">
                                    <label for="text">Subject</label>
                                    <input value="{{ old('subject') }}" type="text"
                                        class="form-control @error('subject') is-invalid @enderror" id="text"
                                        name="subject" placeholder="Enter Subject" />
                                    @error('subject')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    {{-- <label for="exampleFormControlTextarea1">Description</label> --}}
                                    <textarea value="{{ old('subject') }}" name="description"
                                        class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1"
                                        placeholder="Leave a Description here" rows="3"></textarea>
                                    @error('description')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1">(Optional) Example file input</label>
                                    <input name="attachment[]" type="file" multiple class="form-control-file"
                                        id="exampleFormControlFile1" />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info"> <span class="btn-label"> <i
                                                class="fa fa-exclamation-circle"></i> Report </button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Reports data</div>
            </div>
            <div class="card-body">
                <table class="table table-head-bg-primary">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Type</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Description</th>
                            <th scope="col">Attachemnt</th>
                            <th scope="col">Note</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report->type }}</td>
                                <td>{{ $report->subject }}</td>
                                <td>{{ Str::limit($report->description, 10) }}</td>
                                <td>
                                    @if(!empty($report->attachment))
                                        @php
                                            $images = json_decode($report->attachment, true);
                                        @endphp

                                        @if(is_array($images))
                                            @foreach ($images as $img)
                                                <img src="{{ asset('storage/' . $img) }}" width="100" height="100" alt="Attachment">
                                            @endforeach
                                        @else
                                            <p>No images found.</p>
                                        @endif
                                    @else
                                        <p>No attachments available.</p>
                                    @endif
                                    </td>
                                <td>{!! Str::limit($report->admin_note, 10) !!}</td>
                                <td>{{ $report->status }}</td>
                                <td>
                                    <a href="{{ route('user.reportsview', ['id' => $report->id]) }}" class="btn btn-info">View</a>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
