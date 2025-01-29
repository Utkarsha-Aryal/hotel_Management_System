@extends('frontend.layouts.main')

@section('title')
Blog
@endsection 
  @section('main-content')
        <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Blog</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="blog">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <p class="margin_0">Latest Blog Posts</p>
            </div>
         </div>
      </div>
      <div class="row">
         @foreach($data as $blog)
         <div class="col-md-4">
            <div class="blog_box">
               <div class="blog_img">
                  <figure><img src={{ asset('/storage/post') . '/' . @$blog['image'] }} alt="{{ $blog->title }}"/></figure>
               </div>
               <div class="blog_room">
                  <h3>{{ $blog->title }}</h3>
                  <p>{!! $blog->details !!}</p>
                  <span>{{ $blog->author }}</span>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>

     
@endsection