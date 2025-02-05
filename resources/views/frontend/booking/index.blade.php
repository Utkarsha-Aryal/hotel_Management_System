@extends('frontend.layouts.main')

@section('title')
booking
@endsection 
  @section('main-content')
  <div class="modal fade" id="testimonialModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                {{-- Content goes here --}}
            </div>
        </div>
    </div>

    <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <h2>Available Rooms</h2>
                  </div>
               </div>
            </div>
         </div>
    </div>
<div class="row">
   @foreach($data as $room)
      <div class="col-md-4 col-sm-6">
         <div id="serv_hover" class="room">
            <div class="room_img">
               <figure>
               <img style="width:200px;" src="{{ asset('storage/roomCategory/' . @$room->image) }}" alt="image not found" />
               </figure>
            </div>
            <div class="bed_room">
            <span style="display:none;" class="room-id">{{$room->id}}</span> <!-- Added a class to the span for easier targeting -->
            <h3>{{ $room->category }}</h3>
               <p>{{ Str::limit($room->bed_type, 100) }}<br>
                  Maximum Occupancy : {{$room->maximum_occupancy}}
               </p> <!-- Limit description to 100 chars -->
            </div>
         </div>
      </div>
   @endforeach
</div>

<script>
 $(document).off('click', '.room');
 
 $(document).on('click', '.room', function() {
   const today = new Date();
        const hours = today.getHours();
        const minutes = today.getMinutes();
        const currentTime =`${hours}h:${minutes}min`
        const formattedDate = today.toISOString().split('T')[0]
        const nepalidate = NepaliFunctions.AD2BS(formattedDate);

     var id = $(this).find('.room-id').text();  // Get the room id
     var url = '{{ route('booknow.view') }}';  // URL for the route
     var data = { id: id, nepali_date: nepalidate};  // Data to be sent

     // Get the CSRF token from the meta tag
     var csrfToken = $('meta[name="csrf-token"]').attr('content');
     
     // Send the POST request with the CSRF token in the headers
     $.ajax({
         url: url,
         type: 'POST',
         data: data,
         headers: {
             'X-CSRF-TOKEN': csrfToken  // Include the CSRF token in the request header
         },
         success: function(response) {
             // Insert the response into the modal content
             $('#testimonialModal .modal-content').html(response);
             // Show the modal
             $('#testimonialModal').modal('show');
         },
         error: function(xhr, status, error) {
             console.log('Error: ' + error);
         }
     });
 });
</script>

  @endsection