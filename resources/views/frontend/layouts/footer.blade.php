<footer>
      <div class="footer">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <h3>Contact Us</h3>
                  <ul class="conta">
                     <li><i class="fa fa-map-marker"></i> {{$siteSetting->address}}</li>
                     <li><i class="fa fa-mobile"></i> {{$siteSetting->phone_number}}</li>
                     <li><i class="fa fa-envelope"></i><a href="#"> {{$siteSetting->email}}</a></li>
                  </ul>
               </div>
               <div class="col-md-4">
                  <h3>Menu Link</h3>
                  <ul class="link_menu">
                     <li><a href="#">Home</a></li>
                     <li><a href="about.html">About</a></li>
                     <li><a href="room.html">Our Room</a></li>
                     <li><a href="gallery.html">Gallery</a></li>
                     <li><a href="blog.html">Blog</a></li>
                     <li><a href="contact.html">Contact Us</a></li>
                  </ul>
               </div>
               <div class="col-md-4">
                  <h3>Newsletter</h3>
                  <form class="bottom_form">
                     <input class="enter" placeholder="Enter your email" type="email" name="email">
                     <button class="sub_btn" type="submit">Subscribe</button>
                  </form>
                  <ul class="social_icon">
                     <li><a href=" {{$siteSetting->link_facebook}}"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="{{$siteSetting->link_instagram}}"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="{{$siteSetting->link_twitter}}"><i class="fa fa-linkedin"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <div class="row">
                  <div class="col-md-10 offset-md-1">
                     <p>© 2019 All Rights Reserved. Design by <a href="https://html.design/">Free Html Templates</a><br><br>
                        Distributed by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </footer>