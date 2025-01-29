@extends('frontend.layouts.main')

@section('title')
ourroom
@endsection 
  @section('main-content')
      <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <h2>Our Room</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- our_room -->
      <div  class="our_room">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <p  class="margin_0">Lorem Ipsum available, but the majority have suffered </p>
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
               <h3>{{ $room->category }}</h3>
               <p>{{ Str::limit($room->bed_type, 100) }}<br>
                  Maximum Occupancy : {{$room->maximum_occupancy}}
               </p> <!-- Limit description to 100 chars -->
            </div>
         </div>
      </div>
   @endforeach
</div>

         </div>
      </div>
      @endsection

     
   

