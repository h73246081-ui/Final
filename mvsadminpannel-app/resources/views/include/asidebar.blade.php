<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/img/tijaar2.jpeg') }}" alt="Logo">
        </a>
        {{-- <h2>Tijaar</h2> --}}
        <button class="sidebar-close" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <div class="sidebar-content" id="sidebarContent">
        <nav class="nav-menu" id="navMenu">
            <div class="nav-section">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                     <i class="bi bi-house-door-fill"></i>
                    <span class="spanp">Dashboard</span>
                </a>

                <!-- CMS Management with nested dropdowns -->
                <div class="dropdown {{ request()->routeIs('cms.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-gear"></i>
                        <span>CMS Management</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <!-- Home Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.home.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-house-door"></i>
                                <span>Home Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                {{-- <a href="#" class="nav-link {{ request()->routeIs('cms.home.slider') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Slider
                                </a>
                                <a href="#" class="nav-link {{ request()->routeIs('cms.home.shop') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Shop
                                </a>
                                <a href="#" class="nav-link {{ request()->routeIs('cms.home.offer') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Offer Banner
                                </a> --}}
                                <a href="{{route('cms.hero.index')}}" class="nav-link {{ request()->routeIs('cms.hero.index') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Hero
                                </a>
                                <a href="{{route('cms.brand.index')}}" class="nav-link {{ request()->routeIs('cms.brand.index') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> brands
                                </a>
                                <a href="{{route('cms.stats.edit')}}" class="nav-link {{ request()->routeIs('cms.stats.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i>Stats
                                </a>
                                <a href="{{route('cms.testimonial.index')}}" class="nav-link {{ request()->routeIs('cms.testimonial.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Testimonials
                                </a>
                     
                                <a href="{{ route('cms.category1.index') }}" class="nav-link {{ request()->routeIs('cms.category1.*') ? 'active' : '' }}">
    <i class="bi bi-circle me-2"></i> Section 1
</a>

<a href="{{ route('cms.category2.index2') }}" class="nav-link {{ request()->routeIs('cms.category2.*') ? 'active' : '' }}">
    <i class="bi bi-circle me-2"></i> Section 2
</a>

<a href="{{ route('cms.category3.index3') }}" class="nav-link {{ request()->routeIs('cms.category3.*') ? 'active' : '' }}">
    <i class="bi bi-circle me-2"></i> Section 3
</a>

                        
                            </div>
                        </div>

                        <!-- About Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.about.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-info-circle"></i>
                                <span>About Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                <a href="{{route('cms.about.mission')}}" class="nav-link {{ request()->routeIs('cms.about.mission') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i>Our Mission
                                </a>
                                <a href="{{route('cms.about.stat')}}" class="nav-link {{ request()->routeIs('cms.about.stat') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Stats
                                </a>
                                <a href="{{route('cms.about.team')}}" class="nav-link {{ request()->routeIs('cms.about.team') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Team
                                </a>
                                <a href="{{route('cms.about.journey')}}" class="nav-link {{ request()->routeIs('cms.about.journey') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Journey
                                </a>
                                <a href="{{route('cms.about.value')}}" class="nav-link {{ request()->routeIs('cms.about.value') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Value
                                </a>
                            </div>
                        </div>

                        <!-- Blog Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.blog.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-journal-text"></i>
                                <span>Blog Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                {{-- <a href="#" class="nav-link {{ request()->routeIs('cms.blog.banner') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Blog Banner
                                </a> --}}
                                <a href="{{route('cms.blog.index')}}" class="nav-link {{ request()->routeIs('cms.blog.index') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> All Blogs
                                </a>
                            </div>
                        </div>

                        <!-- Contact Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.contact.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-telephone"></i>
                                <span>Contact Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                {{-- <a href="#" class="nav-link {{ request()->routeIs('cms.contact.content') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Info
                                </a>
                                    <a href="#" class="nav-link {{ request()->routeIs('cms.contact.content') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Social
                                </a> --}}
                                <a href="{{route('cms.contact.messages')}}" class="nav-link {{ request()->routeIs('cms.contact.messages') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Messages
                                </a>
                            </div>
                        </div>

                        <!-- FAQ Page -->
                        {{-- <div class="dropdown nested-dropdown {{ request()->routeIs('cms.faq.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-question-circle"></i>
                                <span>FAQ Page</span> --}}
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            {{-- </a>
                            <div class="submenu nested-submenu">
                                <a href="#" class="nav-link {{ request()->routeIs('cms.faq.banner') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> FAQ Banner
                                </a>
                                <a href="#" class="nav-link {{ request()->routeIs('cms.faq.all') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> All FAQs
                                </a>
                            </div>
                        </div> --}}

                        <!-- Terms & Policy -->
                        {{-- <div class="dropdown nested-dropdown {{ request()->routeIs('cms.terms.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-file-earmark-text"></i> --}}
                                {{-- <span>Terms & Policy</span>  --}}
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            {{-- <div class="submenu nested-submenu">
                                <a href="#" class="nav-link {{ request()->routeIs('cms.terms.conditions') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Terms & Conditions
                                </a>
                                <a href="#" class="nav-link {{ request()->routeIs('cms.privacy.policy') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Privacy Policy
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="dropdown {{ request()->routeIs('category.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('category.index')}}" class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                            All Categories
                        </a>
                    </div>
                </div>

                <div class="dropdown {{ request()->routeIs('subcategory.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-diagram-2"></i>
                        <span>Subcategories</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('subcategory.index')}}" class="{{ request()->routeIs('subcategory.index') ? 'active' : '' }}">
                            All Subcategories
                        </a>
                    </div>
                </div>

                <div class="dropdown {{ request()->routeIs('product.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('product.index')}}" class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
                            All Products
                        </a>
                    </div>
                </div>


                <div class="dropdown {{ request()->routeIs('flash.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                       <i class="bi bi-lightning-charge-fill"></i>
                        <span>FLash Deals</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('flash.index')}}" class="{{ request()->routeIs('flash.index') ? 'active' : '' }}">
                            All Deals
                        </a>
                    </div>
                </div>




            <div class="dropdown {{ request()->routeIs('role.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-person-gear me-2"></i>
                        <span>Roles</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('role.index')}}" class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                            All Role
                        </a>
                    </div>
                </div>


                <div class="dropdown {{ request()->routeIs('user.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                          <i class="bi bi-person-fill me-2"></i>
                        <span>Users</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('user.index')}}" class="{{ request()->routeIs('user.index') ? 'active' : '' }}">
                            All User
                        </a>
                    </div>
                </div>


                                <div class="dropdown {{ request()->routeIs('vendor.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                       <i class="bi bi-person-workspace me-2"></i>
                        <span>Vendor</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{route('vendor.index')}}" class="{{ request()->routeIs('vendor.index') ? 'active' : '' }}">
                            All Vendor
                        </a>
                        <a href="{{route('store.index')}}" class="{{ request()->routeIs('store.index') ? 'active' : '' }}">
                            All Store
                        </a>
                    </div>
                             {{-- <div class="submenu">
                        <a href="" class="">
                            All Store
                        </a>
                    </div> --}}
                </div>




                <a href="{{route('website.setting')}}" class="nav-link {{ request()->routeIs('website.setting') ? 'active' : '' }}">
                      <i class="bi bi-gear-fill"></i>
                    <span class="spanp">Setting</span>
                </a>



            </div>
        </nav>
    </div>
</aside>