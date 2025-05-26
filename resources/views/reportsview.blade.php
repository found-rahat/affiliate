@section('title')
    View Reports
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">View Reports</h3>
            </div>
        </div>
        <div class="container">

            <h2>🧾 Report Details</h2>
            <h3><strong>ID:</strong> #{{ $report->id }}</h3>
            <h3><strong>Type Name:</strong> {{ $report->type }}</h3>
            <h3><strong>Supject Name:</strong> {{ $report->subject }}</h3>
            <h3><strong>Description:</strong> {{ $report->description }}</h3>
            <h3><strong>Status:</strong> {{ $report->status }}</h3>
            @if ($report->admin_note)
                <h3><strong>Note:</strong> {!!$report->admin_note !!}</h3>
            @endif
            
            <h3><strong>Created At:</strong> {{ $report->created_at->format('d M y') }}</h3>


            @if (!empty($report->attachment))
                @php
                    $images = is_string($report->attachment)
                        ? json_decode($report->attachment, true)
                        : $report->attachment;
                @endphp

                @if (is_array($images))
                <h3>Screen Short:</h3>
                    @foreach ($images as $img)
                        <img src="{{ asset('storage/' . $img) }}" width="500" height="500" alt="Attachment">
                    @endforeach
                @else
                    <h3>No images found.</h3>
                @endif
            @else
            <h3>Screen Short: No attachments available.</h3>
            @endif
        </div>
    </div>
</div>
@include('include.footer')
