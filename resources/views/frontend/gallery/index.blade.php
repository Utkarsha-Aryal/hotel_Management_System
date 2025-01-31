@extends('frontend.layouts.main')
<style>
   #image{
      height:300px; 
      object-fit:cover;
   }
   .gallery_img p {
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
    }
</style>

@section('title')
Gallery
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
               @foreach ($data as $item)
                  <div class="col-md-3 col-sm-6">
                        <div class="gallery_img">
                        <figure>
                           <a href="{{ route('gallery.show', $item->slug) }}">
                                 <img id="image" src="{{ asset('storage/gallery-image/' . @$item['image']) }}" alt="Gallery Image" />
                           </a>
                        </figure>
                           <p>{{ $item->name }}</p>
                        </div>
                  </div>
               @endforeach
            </div>

         </div>
      </div>
 @endsection