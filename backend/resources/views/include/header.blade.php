    <!-- Header -->
    <header class="header" id="header">
        <div class="header-content">
            <div class="header-left">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div class="page-info">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Welcome back!')</p>
                </div>
            </div>

            <div class="header-right">
                <!-- Search Bar -->
                <div class="search-bar d-none d-lg-block">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search..." id="searchInput">
                </div>

                <!-- Notifications -->
                <div class="notification-dropdown-container" style="margin-top:3px;">
                    <button class="notification-btn" id="notificationBtn">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header" style="margin-top: 9px;">
                            <h6>Notifications</h6>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <!-- Notifications will be loaded via JavaScript -->
                        </div>
                        <div class="notification-footer">
                            <a href="#">View All Notifications</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile - MODIFIED SECTION -->
                <div class="user-profile">
                    <button class="user-profile-btn" id="userProfileBtn">
                        <div class="user-avatar">
                            <img src="{{asset(auth()->user()->image)}}" style="background: white;"
                                 alt=""
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiM0QTZERTUiLz4KPGcgZmlsbD0id2hpdGUiPgo8Y2lyY2xlIGN4PSIyMCIgY3k9IjE1IiByPSI1Ii8+CjxyZWN0IHg9IjEyIiB5PSIyMyIgd2lkdGg9IjE2IiBoZWlnaHQ9IjgiIHJ4PSIyIi8+CjwvZz4KPC9zdmc+'">
                            <div class="user-status"></div>
                        </div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                        <li>
                            <a href="{{route('admin.profile')}}">
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="bi bi-gear"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>