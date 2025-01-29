@extends('frontend.layouts.main')

@section('title')
Blog
@endsection 
  @section('main-content')
      <div  class="gallery">
      <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>gallery</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery1.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery2.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery3.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery4.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery5.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery6.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery7.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="gallery_img">
                     <figure><img src="{{ asset('frontpanel/assets/images/gallery8.jpg')}}" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
 @endsection