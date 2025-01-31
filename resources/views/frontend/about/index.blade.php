
@extends('frontend.layouts.main')

@section('title')
About us
@endsection 
  @section('main-content')
  
  <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <h2>About Us</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about -->
      <div class="about">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-5">
                  <div class="titlepage">
                     <p class="margin_0"> {{@$data->introduction}} </p>
                     <a class="read_more" href="Javascript:void(0)"> Read More</a>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                  @if (!empty($data['img_introduction']))
                                          <figure><img alt=""src={{ asset('/storage/aboutus') . '/' . @$data['img_introduction'] }}
                                            alt="img" id="img_introduction"></figure>
                                    @else
                                    <figure><img src="{{ asset('/images/no-image.jpg') }}" alt="Default Image"
                                            id="img_introduction"></figure>
                                    @endif
                     
                  </div>
               </div>
            </div>
         </div>
      </div>


    @endsection


  
       