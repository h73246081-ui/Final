<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


          @yield('head')


    <!-- ✅ DataTables Responsive Extension CSS & JS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --sidebar-width: 250px;
        --header-height: 70px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        width: 100%;
        overflow-x: hidden;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8fafc;
        min-height: 100vh;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    /* SIDEBAR - FIXED */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: white;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e5e7eb;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .sidebar-header {
        padding: 0 20px;
        height: var(--header-height);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-shrink: 0;
      /* ;  background: linear-gradient(135deg, #667eea 0%, #23cf70cb 100%) */
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo {
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .logo img {
        width: 13rem;
        max-height: 72px;
        /* filter: brightness(3) invert(1); */
    }

    .sidebar-close {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    /* SIDEBAR CONTENT - FIXED */
    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 15px 0;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .nav-menu {
        padding: 0 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .nav-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    /* NAV-LINK FIXES - COMPLETELY FIXED */
    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #374151;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        -moz-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        tap-highlight-color: rgba(0, 0, 0, 0) !important;
        user-select: none;
        position: relative;
    }

    .nav-link:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    /* ICONS FIXED */
    .nav-link i:not(.dropdown-arrow) {
        font-size: 1.2rem !important;
        width: 24px !important;
        flex-shrink: 0;
        color: inherit;
        display: inline-block !important;
    }

    .nav-link span {
        font-size: 0.95rem;
        font-weight: 500;
        flex: 1;
    }

    /* Dropdown arrow - FIXED */
    .dropdown-arrow {
        margin-left: auto;
        font-size: 0.8rem !important;
        transition: transform 0.3s ease;
        color: #6b7280;
        display: inline-block !important;
    }

    .nav-link.active .dropdown-arrow {
        color: rgba(255, 255, 255, 0.8);
    }

    .dropdown.open > .nav-link > .dropdown-arrow,
    .nested-dropdown.open > .nav-link > .dropdown-arrow {
        transform: rotate(90deg);
    }

    /* Dropdown - FIXED */
    .dropdown {
        position: relative;
    }

    .submenu {
        display: none;
        padding-left: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .dropdown.open > .submenu {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Nested dropdown styles */
    .nested-dropdown {
        position: relative;
    }

    .nested-submenu {
        display: none;
        padding-left: 15px;
        margin-top: 5px;
        margin-bottom: 5px;
        border-left: 2px solid #e5e7eb;
    }

    .nested-dropdown.open > .nested-submenu {
        display: block;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { 
            opacity: 0;
            transform: translateX(-10px);
        }
        to { 
            opacity: 1;
            transform: translateX(0);
        }
    }

    .submenu a,
    .nested-submenu a {
        display: block;
        padding: 10px 15px;
        color: #4b5563;
        text-decoration: none;
        border-radius: 6px;
        margin-bottom: 3px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        -moz-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        user-select: none;
    }

    .nested-submenu .nav-link {
        padding: 8px 15px !important;
        font-size: 0.9rem !important;
    }

    .nested-submenu .nav-link i.bi-circle {
        font-size: 0.6rem !important;
        display: inline-block !important;
    }

    .submenu a:hover,
    .submenu a.active,
    .nested-submenu a:hover,
    .nested-submenu a.active {
        color: #111827;
        background: #f3f4f6;
    }

    /* HEADER - FIXED */
    .header {
        height: var(--header-height);
        background: white;
        border-bottom: 1px solid #e5e7eb;
        position: fixed;
        top: 0;
        left: var(--sidebar-width);
        right: 0;
        z-index: 999;
        padding: 0 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: left 0.3s ease;
    }

    .header-content {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #4b5563;
        cursor: pointer;
        padding: 5px;
    }

    .page-info h1 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .page-info p {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* Search - FIXED */
    .search-bar {
        position: relative;
        min-width: 250px;
    }

    .search-bar i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-bar input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* Notification Button - FIXED */
    .notification-btn {
        position: relative;
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #4b5563;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .notification-btn:hover {
        background: #f3f4f6;
        color: var(--primary);
    }

    .notification-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        min-width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        font-weight: 600;
    }

    /* Notification Dropdown - FIXED */
    .notification-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        min-width: 350px;
        max-height: 400px;
        overflow-y: auto;
        display: none;
        z-index: 1050;
        border: 1px solid #e5e7eb;
    }

    .notification-dropdown.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification-header {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        background: #f8f9fa;
        border-radius: 10px 10px 0 0;
    }

    .notification-header h6 {
        margin: 0;
        font-weight: 600;
        color: #111827;
    }

    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 15px;
        border-bottom: 1px solid #f5f5f5;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: flex-start;
    }

    .notification-item:hover {
        background: #f8f9fa;
    }

    .notification-item.unread {
        background: #f0f7ff;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e3f2fd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #2196f3;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 3px;
    }

    .notification-message {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .notification-time {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .notification-footer {
        padding: 10px 15px;
        text-align: center;
        border-top: 1px solid #e0e0e0;
        background: #f8f9fa;
        border-radius: 0 0 10px 10px;
    }

    .notification-footer a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .notification-footer a:hover {
        text-decoration: underline;
    }

    /* USER PROFILE - MODIFIED SECTION */
    .user-profile {
        position: relative;
    }

    .user-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: none;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-profile-btn:hover {
        background: #f3f4f6;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #f0f0f0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .user-profile-btn:hover .user-avatar img {
        transform: scale(1.05);
    }

    .user-name {
        font-weight: 500;
        color: #374151;
        font-size: 0.9rem;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Online Status Indicator */
    .user-status {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* User Dropdown Menu - FIXED */
    .user-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        padding: 10px 0;
        display: none;
        z-index: 1050;
        border: 1px solid #e5e7eb;
    }

    .user-dropdown-menu.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    .user-dropdown-menu li {
        list-style: none;
    }

    .user-dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .user-dropdown-menu a:hover {
        background: #f9fafb;
        color: var(--primary);
    }

    .user-dropdown-menu i {
        width: 20px;
        color: #6b7280;
        font-size: 1.1rem;
    }

    /* MAIN CONTENT - FIXED */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-top: var(--header-height);
        padding: 20px;
        min-height: calc(100vh - var(--header-height));
        overflow-y: auto;
        transition: all 0.3s ease;
    }

    /* Overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 998;
        display: none;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
        }
        
        .sidebar.active {
            transform: translateX(0);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        
        .header {
            left: 0;
        }
        
        .main-content {
            margin-left: 0;
        }
        
        .mobile-menu-toggle {
            display: block;
        }
        
        .sidebar-close {
            display: block;
        }
        
        .search-bar {
            display: none;
        }
        
        .notification-dropdown {
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
        }

        .user-dropdown-menu {
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 300px;
        }
        
        .overlay.show {
            display: block;
        }
        
        /* Mobile nested dropdown fixes */
        .nested-submenu {
            padding-left: 10px;
        }
        
        .nested-submenu .nav-link {
            padding: 8px 10px !important;
        }
    }

    @media (max-width: 768px) {
        .header {
            padding: 0 15px;
        }
        
        .user-name {
            display: none;
        }
        
        .search-bar {
            min-width: auto;
        }
    }

    /* ULTIMATE FIX FOR CLICK COLOR ISSUE */
    .nav-link,
    .submenu a,
    .nested-submenu a {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        -moz-tap-highlight-color: rgba(0, 0, 0, 0) !important;
        tap-highlight-color: rgba(0, 0, 0, 0) !important;
        outline: none !important;
    }

    .nav-link:active,
    .nav-link.active:active,
    .submenu a:active,
    .submenu a.active:active,
    .nested-submenu a:active,
    .nested-submenu a.active:active {
        opacity: 1 !important;
        transform: none !important;
    }

    /* App.css override prevention */
    .sidebar .nav-link,
    .sidebar .submenu a,
    .sidebar .nested-submenu a {
        opacity: 1 !important;
        background-color: inherit !important;
        color: black !important;
    }

    .sidebar .nav-link.active,
    .sidebar .submenu a.active,
    .sidebar .nested-submenu a.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
    }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    @include('include.asidebar')

    <!-- Header -->
    @include('include.header')

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const userProfileBtn = document.getElementById('userProfileBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        // Track if we're in mobile mode
        let isMobile = window.innerWidth <= 992;
        
        /* ================= SIDEBAR FUNCTIONS ================= */
        function openSidebar() {
            sidebar.classList.add('active');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
        
        /* ================= DROPDOWN FUNCTIONS ================= */
        function closeAllSidebarDropdowns() {
            document.querySelectorAll('.dropdown.open, .nested-dropdown.open').forEach(d => {
                d.classList.remove('open');
            });
        }
        
        function closeOtherDropdownsAtSameLevel(currentDropdown) {
            const parent = currentDropdown.closest('.submenu') || 
                          currentDropdown.closest('.nested-submenu') || 
                          currentDropdown.closest('.nav-section');
            
            if (parent) {
                parent.querySelectorAll('.dropdown, .nested-dropdown').forEach(d => {
                    if (d !== currentDropdown && !currentDropdown.contains(d)) {
                        d.classList.remove('open');
                    }
                });
            }
        }
        
        /* ================= TOGGLE DROPDOWN ================= */
        function toggleDropdown(dropdown) {
            const isOpen = dropdown.classList.contains('open');
            
            // Close other dropdowns at the same level
            closeOtherDropdownsAtSameLevel(dropdown);
            
            // Toggle current dropdown
            dropdown.classList.toggle('open', !isOpen);
            
            // Close notification and user dropdowns
            if (notificationDropdown) notificationDropdown.classList.remove('show');
            if (userDropdownMenu) userDropdownMenu.classList.remove('show');
        }
        
        /* ================= EVENT LISTENERS ================= */
        // Mobile menu toggle
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', openSidebar);
        }
        
        // Close sidebar
        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        
        // Overlay click
        if (overlay) {
            overlay.addEventListener('click', () => {
                closeSidebar();
                closeAllSidebarDropdowns();
                if (notificationDropdown) notificationDropdown.classList.remove('show');
                if (userDropdownMenu) userDropdownMenu.classList.remove('show');
            });
        }
        
        /* ================= DROPDOWN CLICK HANDLING ================= */
        document.addEventListener('click', function(e) {
            const target = e.target;
            
            // Check if click is on a dropdown toggle (both main and nested)
            const dropdownToggle = target.closest('.nav-link.dropdown-toggle');
            if (dropdownToggle) {
                e.preventDefault();
                e.stopPropagation();
                
                const dropdown = dropdownToggle.closest('.dropdown') || 
                                dropdownToggle.closest('.nested-dropdown');
                if (dropdown) {
                    toggleDropdown(dropdown);
                }
                return;
            }
            
            // Check if click is on a regular menu link
            const regularLink = target.closest('.submenu a:not(.dropdown-toggle), .nested-submenu a:not(.dropdown-toggle)');
            if (regularLink) {
                if (isMobile && sidebar.classList.contains('active')) {
                    setTimeout(closeSidebar, 300);
                }
                return;
            }
            
            // Check if click is on notification button
            if (notificationBtn && target.closest('#notificationBtn')) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('show');
                if (userDropdownMenu) userDropdownMenu.classList.remove('show');
                return;
            }
            
            // Check if click is on user profile button
            if (userProfileBtn && target.closest('#userProfileBtn')) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('show');
                if (notificationDropdown) notificationDropdown.classList.remove('show');
                return;
            }
            
            // Close notification and user dropdowns when clicking outside
            const clickedInsideNotification = target.closest('.notification-dropdown');
            const clickedInsideUserMenu = target.closest('.user-dropdown-menu');
            
            if (!clickedInsideNotification && notificationDropdown) {
                notificationDropdown.classList.remove('show');
            }
            
            if (!clickedInsideUserMenu && userDropdownMenu) {
                userDropdownMenu.classList.remove('show');
            }
        });
        
        /* ================= TOUCH SUPPORT FOR MOBILE ================= */
        document.querySelectorAll('.nav-link.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('touchstart', function(e) {
                if (isMobile) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const dropdown = this.closest('.dropdown') || 
                                    this.closest('.nested-dropdown');
                    if (dropdown) {
                        toggleDropdown(dropdown);
                    }
                }
            }, { passive: false });
        });
        
        /* ================= AUTO OPEN ACTIVE MENU ================= */
        function openParentDropdowns(element) {
            let parent = element.closest('.dropdown') || element.closest('.nested-dropdown');
            while (parent) {
                parent.classList.add('open');
                parent = parent.parentElement.closest('.dropdown') || 
                        parent.parentElement.closest('.nested-dropdown');
            }
        }
        
        // Open parent dropdowns for active links
        document.querySelectorAll('.nav-link.active').forEach(link => {
            openParentDropdowns(link);
        });
        
        // Also open for active submenu links
        document.querySelectorAll('.submenu a.active, .nested-submenu a.active').forEach(link => {
            openParentDropdowns(link);
        });
        
        /* ================= RESIZE HANDLER ================= */
        window.addEventListener('resize', function() {
            isMobile = window.innerWidth <= 992;
            
            if (!isMobile) {
                // On desktop, close sidebar but keep dropdowns as they are
                closeSidebar();
            }
        });
        
        /* ================= INITIALIZE ================= */
        // Close all dropdowns on page load for mobile
        if (isMobile) {
            closeAllSidebarDropdowns();
        }
    });
    </script>
        @include('include.flash')
  
   @yield('scripts')

    @stack('scripts')
</body>
</html>