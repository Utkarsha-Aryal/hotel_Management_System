@extends('backend.layouts.main')

@section('title')
    Rooms
@endsection
<style>
    input#trashed_file {
        border: 1px solid rgb(0, 99, 198) !important
    }
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@section('main-content')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div class="my-auto">
            <h5 class="page-title fs-21 mb-1">Room Setting</h5>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Main Contents</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Our Rooms</li>
                    <li class="breadcrumb-item active" aria-current="page">Room setting</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="postModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="room-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-tab="index">Index</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-tab="amne">amne</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div id="tab-content" class="mt-4">
            <p>Click a tab to load content dynamically.</p>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Load default content
            loadTabContent('index');

            // Handle tab click
            $('.nav-link').click(function (e) {
                e.preventDefault();
                var tab = $(this).data('tab');
                loadTabContent(tab);

                // Set active tab
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Function to load tab content
            function loadTabContent(tab) {
    $('#tab-content').html('<p>Loading...</p>');
    
    // Construct the POST request
    $.post("{{ url('admin/main') }}/" + tab, {
        _token: "{{ csrf_token() }}" // Include CSRF token for POST requests
    })
    .done(function(response) {
        $('#tab-content').html(response);
    })
    .fail(function() {
        $('#tab-content').html('<p>Failed to load content.</p>');
    });
}
        });
    </script>
@endsection