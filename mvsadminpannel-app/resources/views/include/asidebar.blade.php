<!-- Sidebar -->
<style>
    #space{
        margin-left: 7px;
    }
    .right{
        margin-right: 63px;
    }
    .cir{
        font-size: 0.6rem;
    }
</style>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/tijaar2.jpeg') }}" alt="Logo">
        </a>
        {{-- <h2>Tijaar</h2> --}}
        <button class="sidebar-close" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- <div class="sidebar-content" id="sidebarContent"> --}}
        <nav class="sidebars-contents" id="navMenu">
            <div class="nav-section">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i>
                    <span class="spanp">Dashboard</span>
                </a>

                <!-- CMS Management with nested dropdowns -->
                <div class="dropdown {{ request()->routeIs('cms.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-gear"></i>
                        <span>CMS</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <!-- Home Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.home.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-house-door"></i>
                                <span id="space" class="right">Home Page</span>
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
                                <a href="{{ route('editHero') }}"
                                    class="nav-link {{ request()->routeIs('editHero') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Hero
                                </a>
                                <a href="{{ route('cms.brand.index') }}"
                                    class="nav-link {{ request()->routeIs('cms.brand.index') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> brands
                                </a>
                                <a href="{{ route('cms.stats.edit') }}"
                                    class="nav-link {{ request()->routeIs('cms.stats.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i>Stats
                                </a>
                                <a href="{{ route('cms.testimonial.index') }}"
                                    class="nav-link {{ request()->routeIs('cms.testimonial.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Testimonials
                                </a>

                                <a href="{{ route('cms.category1.index') }}"
                                    class="nav-link {{ request()->routeIs('cms.category1.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Section 1
                                </a>

                                <a href="{{ route('cms.category2.index2') }}"
                                    class="nav-link {{ request()->routeIs('cms.category2.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Section 2
                                </a>

                                <a href="{{ route('cms.category3.index3') }}"
                                    class="nav-link {{ request()->routeIs('cms.category3.*') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Section 3
                                </a>


                            </div>
                        </div>

                        <!-- About Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.about.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-info-circle"></i>
                                <span id="space" class="right">About Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                <a href="{{ route('cms.about.mission') }}"
                                    class="nav-link {{ request()->routeIs('cms.about.mission') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i>Our Mission
                                </a>
                                <a href="{{ route('cms.about.stat') }}"
                                    class="nav-link {{ request()->routeIs('cms.about.stat') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Stats
                                </a>
                                <a href="{{ route('cms.about.team') }}"
                                    class="nav-link {{ request()->routeIs('cms.about.team') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Team
                                </a>
                                <a href="{{ route('cms.about.journey') }}"
                                    class="nav-link {{ request()->routeIs('cms.about.journey') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Journey
                                </a>
                                <a href="{{ route('cms.about.value') }}"
                                    class="nav-link {{ request()->routeIs('cms.about.value') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> About Value
                                </a>
                            </div>
                        </div>

                        <!-- Blog Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.blog.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-journal-text"></i>
                                <span id="space" class="right" style="margin-right: 73px;">Blog Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                {{-- <a href="#" class="nav-link {{ request()->routeIs('cms.blog.banner') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Blog Banner
                                </a> --}}
                                <a href="{{ route('cms.blog.index') }}"
                                    class="nav-link {{ request()->routeIs('cms.blog.index') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> All Blogs
                                </a>
                            </div>
                        </div>

                        <!-- Contact Page -->
                        <div class="dropdown nested-dropdown {{ request()->routeIs('cms.contact.*') ? 'open' : '' }}">
                            <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                <i class="bi bi-telephone"></i>
                                <span id="space" class="right" style="margin-right: 52px;">Contact Page</span>
                                {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                            </a>
                            <div class="submenu nested-submenu">
                                {{-- <a href="#" class="nav-link {{ request()->routeIs('cms.contact.content') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Info
                                </a>
                                    <a href="#" class="nav-link {{ request()->routeIs('cms.contact.content') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Social
                                </a> --}}
                                <a href="{{ route('cms.contact.messages') }}"
                                    class="nav-link {{ request()->routeIs('cms.contact.messages') ? 'active' : '' }}">
                                    <i class="bi bi-circle me-2"></i> Contact Messages
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('indexTerm') }}"
                            class="{{ request()->routeIs('indexTerm') ? 'active' : '' }}">
                            <i class="bi bi-journal-text"></i>
                            <span id="space">Terms & Conditions</span>
                        </a>
                        <a href="{{ route('indexPolicy') }}"
                            class="{{ request()->routeIs('indexPolicy') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i>
                            <span id="space">Privacy & Policy</span>
                        </a>
                        <a href="{{ route('editBanner') }}"
                            class="{{ request()->routeIs('editBanner') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i>
                            <span id="space">Banners</span>
                        </a>


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
                        {{-- </a> --}}
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

                {{-- <div class="dropdown {{ request()->routeIs('category.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span> --}}
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    {{-- </a> --}}
                    {{-- <div class="submenu">
                        <a href="{{ route('') }}"
                            class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                            All Categories
                        </a>
                    </div> --}}
                {{-- </div> --}}
                <div class="dropdown {{ request()->routeIs('vendor.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-person-workspace"></i>
                        <span>Sellers</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{ route('vendor.index') }}"
                            class="{{ request()->routeIs('vendor.index') ? 'active' : '' }}" >
                            <i class="bi bi-circle me-2 cir"></i>Private Sellers
                        </a>
                        <a href="{{ route('vendor.busi') }}"
                        class="{{ request()->routeIs('vendor.busi') ? 'active' : '' }}">
                        <i class="bi bi-circle me-2 cir"></i>Sellers
                    </a>
                        <a href="{{ route('store.index') }}"
                            class="{{ request()->routeIs('store.index') ? 'active' : '' }}">
                            <i class="bi bi-circle me-2 cir"></i>Stores
                        </a>
                    </div>
                    {{-- <div class="submenu">
                        <a href="" class="">
                            All Store
                        </a>
                    </div> --}}
                </div>
                <a href="{{ route('category.index') }}"
                class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span class="spanp">Categories</span>
            </a>
            <a href="{{ route('subcategory.index') }}"
            class="nav-link {{ request()->routeIs('subcategory.index') ? 'active' : '' }}">
            <i class="bi bi-diagram-2"></i>
            <span class="spanp">SubCategories</span>
        </a>

                {{-- <div class="dropdown {{ request()->routeIs('subcategory.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-diagram-2"></i>
                        <span>Subcategories</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    {{-- </a>
                    <div class="submenu">
                        <a href="{{ route('subcategory.index') }}"
                            class="{{ request()->routeIs('subcategory.index') ? 'active' : '' }}">
                            All Subcategories
                        </a>
                    </div> --}}
                {{-- </div>  --}}
                <a href="{{ route('product.index') }}"
                class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>
                <span class="spanp">Products</span>
            </a>
                {{-- <div class="dropdown {{ request()->routeIs('product.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                        <i class="dropdown-arrow bi bi-chevron-right"></i>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('product.index') }}"
                            class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
                            All Products
                        </a>
                    </div>
                </div> --}}
                <a href="{{ route('flash.index') }}"
                class="nav-link {{ request()->routeIs('flash.index') ? 'active' : '' }}">
                <i class="bi bi-lightning-fill"></i>
                <span class="spanp">Flash Deals</span>
            </a>

            <a href="{{route('editLimit')}}"
            class="nav-link {{ request()->routeIs('editLimita') ? 'active' : '' }}">
            <i class="bi bi-123"></i>
            <span class="spanp">Product Limit</span>
        </a>






                <div class="dropdown {{ request()->routeIs('role.*') ? 'open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                        <i class="bi bi-person-gear"></i>
                        <span>Roles</span>
                        {{-- <i class="dropdown-arrow bi bi-chevron-right"></i> --}}
                    </a>
                    <div class="submenu">
                        <a href="{{ route('role.index') }}"
                            class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                            <i class="bi bi-circle me-2 cir"></i>All Role
                        </a>
                    </div>
                    <div class="submenu">
                        <a href="{{ route('allPermission') }}"
                            class="{{ request()->routeIs('allPermission') ? 'active' : '' }}">
                            <i class="bi bi-circle me-2 cir"></i>Permission
                        </a>
                    </div>
                </div>

                <a href="{{ route('user.index') }}"
                class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                <i class="bi bi-person-fill cir"></i>
                <span class="spanp">Users</span>
            </a>






                {{-- <a href="{{ route('allPrivateSellers') }}"
                    class="nav-link {{ request()->routeIs('allPrivateSellers') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill me-2"></i>
                    <span class="spanp">Private Sellers</span>
                </a> --}}

                <a href="{{ route('allOrder') }}"
                    class="nav-link {{ request()->routeIs('allOrder') ? 'active' : '' }}">
                    <i class="bi bi-cart-check-fill"></i>
                    <span class="spanp">Orders</span>
                </a>

                <a href="{{ route('packages.index') }}"
                class="nav-link {{ request()->routeIs('packages.index') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i>

                <span class="spanp">Packages</span>
            </a>

            <a href="{{route('vendorPackage')}}"
            class="nav-link {{ request()->routeIs('vendorPackage') ? 'active' : '' }}">
            <i class="bi bi-bag-check-fill"></i>

            <span class="spanp">Seller Package</span>
        </a>

            <a href="{{ route('allSub') }}"
            class="nav-link {{ request()->routeIs('allSub') ? 'active' : '' }}">
            <i class="bi bi-envelope-paper-heart"></i>
            <span class="spanp">Subscribers</span>
        </a>
        <a href="{{ route('editComission') }}"
        class="nav-link {{ request()->routeIs('editComission') ? 'active' : '' }}">
        <i class="bi bi-percent"></i>
        <span class="spanp">Commission</span>
    </a>

                <a href="{{ route('website.setting') }}"
                    class="nav-link {{ request()->routeIs('website.setting') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i>
                    <span class="spanp">Settings</span>
                </a>

                {{-- logout --}}
                {{-- <a href="{{ route('website.setting') }}"
                    class="nav-link {{ request()->routeIs('website.setting') ? 'active' : '' }}">
                    <div class="btn" style="margin-left: 16px;
    background: white;
    color: black;">
                        <i class="bi bi-box-arrow-right me-2"></i>
                    <span class="spanp">Logout</span>
                    </div>
                </a> --}}


            </div>
        </nav>
    {{-- </div> --}}
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebars-contents');
        const activeLink = sidebar.querySelector('.nav-link.active');

        if (activeLink) {
            activeLink.scrollIntoView({
                behavior: 'smooth',
                block: 'center' // center / nearest bhi use kar sakte ho
            });
        }
    });
    </script>

