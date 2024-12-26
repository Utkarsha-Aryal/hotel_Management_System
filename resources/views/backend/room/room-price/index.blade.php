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
            <h5 class="page-title fs-21 mb-1">Price Setting</h5>
        </div>
    </div>
    <div class="container mt-5">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="room-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-tab="season">Season Setting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-tab="price_setting">Price Settting</a>
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
    loadTabContent('season');

    // Handle tab click
    $('.nav-link').off('click').on('click', function (e) {
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

        // Debouncing the AJAX call to prevent multiple requests
        if (window.loadingTab) return;
        window.loadingTab = true;

        $.ajax({
            url: "{{route('admin.season-setting.tab')}}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                tab: tab
            },
        })
            .done(function (response) {
                $('#tab-content').html(response);
            })
            .fail(function () {
                $('#tab-content').html('<p>Failed to load content.</p>');
            })
            .always(function () {
                // Reset debounce flag
                window.loadingTab = false;
            });
    }
});

</script>

@endsection