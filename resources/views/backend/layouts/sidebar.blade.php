<style>
    li.slide.active a {
        color: blue !important;
        font-weight: 500 !important;
    }

    li.slide.active a span {
        color: blue !important;
        font-weight: 500 !important;
    }

    /* li.slide.active a svg path {
        color: blue !important;
    } */
</style>
<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
       <!--    @if (!empty($siteSetting->img_logo) && Storage::exists('public/setting/' . $siteSetting->img_logo))
            @dd($siteSetting->img_logo)
                <img src="{{ asset('/storage/setting/' . $siteSetting->img_logo) }}" class="rounded-circle" alt="No Logo"
                    width=" 37" height="37">
            @else
                <img src="{{ asset('frontpanel/assets/images/logo/demo_logo.png') }}" alt="Logo" />
            @endif -->
    <div class="main-sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="header-logo">
             <!-- <img src="{{ asset('backpanel/assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
            class="desktop-logo">
            <img src="{{ asset('backpanel/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('backpanel/assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('backpanel/assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white"> -->
            <!-- storage disk checks the public directory -->
            @if (!empty($siteSetting->img_logo) && Storage::disk('public')->exists('setting/'.$siteSetting->img_logo))
            <img src="{{ asset('/storage/setting/' . $siteSetting->img_logo) }}" class="rounded-circle" alt="No Logo"
                    width=" 37" height="37">
            @else
                <img src="{{ asset('frontpanel/assets/images/logo/demo_logo.png') }}" alt="Logo" />
            @endif
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <ul class="main-menu">
                <li class="slide__category"><span class="category-name">Dashboard</span></li>
                <!-- Starts::Dashboard -->
                <li class="slide" data-id="dashboard">
                    <a href="{{'dashboard'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- Ends::Dashboard -->

                <!-- Starts::Enquiry Section  -->
                <li class="slide__category"><span class="category-name">Enquiry</span></li>

                <!-- ContactUs Starts -->
                <li class="slide" data-id="contact">
                    <a href="" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16"
                            fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.736L0 4.697zM6.761 8.83 0 12.803A2 2 0 0 0 2 14h12a2 2 0 0 0 2-1.197l-6.761-3.975L8 9.586l-1.239-.757zM16 4.697l-5.803 3.668L16 11.801V4.697z" />
                        </svg>
                        <span class="side-menu__label">Contact Us</span>
                    </a>
                </li>

                <li class="slide" data-id="enquiry">
                    <a href="" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16"
                            fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                            <path
                                d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                        </svg>
                        <span class="side-menu__label">Enquiry Us</span>
                    </a>
                </li>

                <!-- ContactUs Ends -->

                <!-- Ends::Enquiry Section  -->
                <!-- Starts::Most Usaualble  -->
                <li class="slide__category"><span class="category-name">Main Contents</span></li>
                <!-- Starts:: News & Blog -->
                <li class="slide" data-id="news-blogs">
                    <a href="{{'post'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16"
                            viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8q.425 0 .713.288T14 4t-.288.713T13 5H5v14h14v-8q0-.425.288-.712T20 10t.713.288T21 11v8q0 .825-.587 1.413T19 21zm4-4q-.425 0-.712-.288T8 16t.288-.712T9 15h6q.425 0 .713.288T16 16t-.288.713T15 17zm0-3q-.425 0-.712-.288T8 13t.288-.712T9 12h6q.425 0 .713.288T16 13t-.288.713T15 14zm0-3q-.425 0-.712-.288T8 10t.288-.712T9 9h6q.425 0 .713.288T16 10t-.288.713T15 11zm9-2q-.425 0-.712-.288T17 8V7h-1q-.425 0-.712-.288T15 6t.288-.712T16 5h1V4q0-.425.288-.712T18 3t.713.288T19 4v1h1q.425 0 .713.288T21 6t-.288.713T20 7h-1v1q0 .425-.288.713T18 9" />
                        </svg>
                        <span class="side-menu__label">News and Blogs</span>
                    </a>
                </li>

                <li class="slide" data-id="message">
                    <a href="{{'message'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="16" height="16" viewBox="0 0 512 512"><path d="M160 368c26.5 0 48 21.5 48 48l0 16 72.5-54.4c8.3-6.2 18.4-9.6 28.8-9.6L448 368c8.8 0 16-7.2 16-16l0-288c0-8.8-7.2-16-16-16L64 48c-8.8 0-16 7.2-16 16l0 288c0 8.8 7.2 16 16 16l96 0zm48 124l-.2 .2-5.1 3.8-17.1 12.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3l0-21.3 0-6.4 0-.3 0-4 0-48-48 0-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L448 0c35.3 0 64 28.7 64 64l0 288c0 35.3-28.7 64-64 64l-138.7 0L208 492z"/></svg>
                        <span class="side-menu__label">message</span>
                    </a>
                </li>
                
                <!-- Ends:: News & Blog -->

                <!-- Starts::Our Team  -->
                <li class="slide" data-id="member">
                    <a href="{{'member'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                        <span class="side-menu__label">Our Team</span>
                    </a>
                </li>
                <!-- Ends::Our Team  -->

           
                <li class="slide">
                    <a href= "{{route('admin.price-setting') }}" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="side-menu__icon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                    </svg>
                        <span class="side-menu__label">Room Pricing</span>
                    </a>
                </li>

                {{-- Rooms start here --}}
                <li class="slide has-sub" id="mainMenu">
                    <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"  height='16' fill='currentColor' class="side-menu__icon" >
                        <path d="M32 32c17.7 0 32 14.3 32 32l0 256 224 0 0-160c0-17.7 14.3-32 32-32l224 0c53 0 96 43 96 96l0 224c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-32-224 0-32 0L64 416l0 32c0 17.7-14.3 32-32 32s-32-14.3-32-32L0 64C0 46.3 14.3 32 32 32zm144 96a80 80 0 1 1 0 160 80 80 0 1 1 0-160z"/>
                    </svg>
                        <span class="side-menu__label">Rooms</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">Rooms</a>
                        </li>
                        <li class="slide" id="childMenu" data-id="program">
                            <a href="{{route('admin.room-setting') }}" class="side-menu__item">Room Setting</a>
                        </li>
                        <li class="slide" data-id="course">
                            <a href="{{('rooms') }}" class="side-menu__item">Room Category</a>
                        </li>
                    </ul>
                </li>
                {{-- Rooms end here --}}

                {{-- document start here --}}
                <li class="slide" data-id="document">
                    <a href="{{'document'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                            <path
                                d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                        </svg>
                        <span class="side-menu__label">Documents</span>
                    </a>
                </li>
                {{-- document end here --}}

                <!-- Starts:: Testimonial  -->
                <li class="slide" data-id="testimonial">
                    <a href="{{'testimonial'}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
                            <path
                                d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z" />
                        </svg>
                        <span class="side-menu__label">Testimonial</span>
                    </a>
                </li>
                <!-- Ends:: Testimonial  -->

                <!-- Ends::Most Usaualble  -->
               
                    <!-- Starts:: USer Management section  -->
                    <li class="slide__category"><span class="category-name">User Management</span></li>
                    <!-- Starts::User  -->
                    <li class="slide" data-id="user">
                        <a href="{{ route('admin.account') }}" class="side-menu__item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                                height="16" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path
                                        d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor"
                                        d="M16 14a5 5 0 0 1 5 5v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1a5 5 0 0 1 5-5zm4-6a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1V9a1 1 0 0 1 1-1m-8-6a5 5 0 1 1 0 10a5 5 0 0 1 0-10" />
                                </g>
                            </svg>
                            <span class="side-menu__label">User</span>
                        </a>
                    </li>
                    <!-- Ends::User  -->
           
                <!-- Ends:: USer Management section  -->

                <!-- Starts::Setting Section  -->
                <li class="slide__category"><span class="category-name">One Time Setting </span></li>
                <!-- Sitesetting starts -->
                <li class="slide" data-id="sitesetting">
                    <a href="{{route('admin.sitesetting')}}" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                            <path
                                d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                        </svg>
                        <span class="side-menu__label">Site Setting</span>
                    </a>
                </li>
                <!-- Sitesetting ends -->

                <!-- FAQ starts -->
                <li class="slide has-sub" id="mainMenu">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-patch-question-fill"
                            viewBox="0 0 16 16">
                            <path
                                d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627" />
                        </svg>
                        <span class="side-menu__label">FAQ</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">FAQ</a>
                        </li>
                        <li class="slide" id="childMenu" data-id="faqCategory">
                            <a href="{{ route('admin.faq.category')}}" class="side-menu__item">FAQ Category</a>
                        </li>
                        <li class="slide" data-id="faq">
                            <a href="{{route('admin.faq')}}" class="side-menu__item">FAQ</a>
                        </li>
                    </ul>
                </li>
                <!-- FAQ ends -->

                <!-- AboutUs Starts -->
                <li class="slide has-sub" id="mainMenu">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16"
                            height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 24 24">
                            <path
                                d="M11 9h2V7h-2m1 13c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2m-1 15h2v-6h-2z" />
                        </svg>
                        <span class="side-menu__label">About Us</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0);">About Us</a>
                        </li>
                        <li class="slide" id="childMenu" data-id="aboutUs">
                            <a href="{{ route('admin.aboutus') }}" class="side-menu__item">Introduction</a>
                        </li>
                        <li class="slide" data-id="ourValue">
                            <a href="{{ route('admin.values') }}" class=" side-menu__item">Our Values</a>
                        </li>

                        <li class="slide" data-id="choose">
                            <a href="{{ route('admin.why.to.choose.us') }}" class=" side-menu__item">Why Choose
                                Us?</a>
                        </li>
                    </ul>
                </li>
                <!-- AboutUs Ends -->

                <!-- Ends::Setting Section  -->

                <!-- End::slide -->
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->
    </div>
    <!-- End::main-sidebar -->
</aside>
<!-- End::app-sidebar -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#childMenu').off('click');
    //     $('#childMenu').on('click', function(event) {
    //         $('#mainMenu').addClass('open');
    //         event.stopPropagation();
    //     });
    $(document).ready(function() {
        const activeItem = localStorage.getItem('activeItem');
        if (activeItem) {
            $('li.slide').removeClass('active');
            $(`li.slide[data-id="${activeItem}"]`).addClass('active');
        }
        $('li.slide a').on('click', function() {
            const itemId = $(this).closest('li.slide').data('id');
            localStorage.setItem('activeItem', itemId);
        });
    });


    // });
</script>
