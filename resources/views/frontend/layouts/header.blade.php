
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="{{ asset('storage/setting/' . $siteSetting->img_logo) }}" alt="Logo">
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                           <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("home") }}'>Home</a>
                           </li>
                           <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("about") }}'>About</a>
                           </li>
                           <li class="nav-item {{ request()->routeIs('ourroom') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("ourroom") }}'>Our room</a>
                           </li>
                           <li class="nav-item {{ request()->routeIs('gallery') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("gallery") }}'>Gallery</a>
                           </li>
                           <li class="nav-item {{ request()->routeIs('blog') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("blog") }}'>Blog</a>
                           </li>
                           <li class="nav-item {{ request()->routeIs('comtact') ? 'active' : '' }}">
                              <a class="nav-link" href='{{ route("comtact") }}'>Contact Us</a>
                           </li>
                        </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>