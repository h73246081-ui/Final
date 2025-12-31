
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Chart.js for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #3b82f6;
        --danger: #ef4444;
        --light: #f9fafb;
        --dark: #111827;
        --gray: #6b7280;
        --border: #e5e7eb;
        --card-bg: #ffffff;
    }
    
    .dashboard-container {
        padding: 0px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Page Header */
    .page-header {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 5px;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 0;
    }
    
    /* Stats Cards - UPDATED LAYOUT */
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #111827;
        line-height: 1;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 0;
    }
    
    /* Color variants */
    .stat-card.blue .stat-icon {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--info);
    }
    
    .stat-card.purple .stat-icon {
        background-color: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
    }
    
    .stat-card.green .stat-icon {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }
    
    .stat-card.orange .stat-icon {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    /* Charts Section */
    .chart-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        height: 100%;
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .chart-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 0;
        color: #111827;
    }
    
    .period-select {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        font-size: 14px;
        cursor: pointer;
    }
    
    .chart-container {
        height: 250px;
        position: relative;
    }
    
    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .table-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 0;
        color: #111827;
    }
    
    .view-all-btn {
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    
    .view-all-btn:hover {
        text-decoration: underline;
    }
    
    .table th {
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
        padding: 12px;
        font-size: 14px;
    }
    
    .table td {
        padding: 16px 12px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    
    /* Status Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #065f46;
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #92400e;
    }
    
    .badge-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: #1e40af;
    }
    
    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        height: 100%;
    }
    
    .info-card h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #111827;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #6b7280;
        font-size: 14px;
    }
    
    .info-value {
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Action Buttons */
    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        background: #f9fafb;
        border-color: var(--primary);
        color: var(--primary);
    }
    
    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        
        .page-header {
            padding: 15px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            font-size: 20px;
        }
        
        .stat-number {
            font-size: 24px;
        }
        
        .stat-label {
            font-size: 13px;
        }
        
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .period-select {
            align-self: flex-end;
        }
        
        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .view-all-btn {
            align-self: flex-end;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .table th,
        .table td {
            padding: 10px 8px;
        }
    }
    
    @media (max-width: 576px) {
        .stat-card {
            padding: 12px;
        }
        
        .chart-card,
        .table-card,
        .info-card {
            padding: 15px;
        }
        
        .stat-number {
            font-size: 22px;
        }
    }
</style>

@extends('layouts.app')
@section('content')
        <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">
                Welcome back, {{ auth()->user()->name ?? 'Admin' }}! Here's your store overview.
            </p>
        </div>
        

            <!-- Stats Cards - HORIZONTAL LAYOUT (Icon Left, Stats Right) -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3 fade-in">
            <div class="stat-card blue">
                <div class="stat-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number"> 466 </div>
                    <p class="stat-label">Categories</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.1s">
            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number"> 456 </div>
                    <p class="stat-label">Subcategories</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.2s">
            <div class="stat-card green">
                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number"> 464 </div>
                    <p class="stat-label">Products</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.3s">
            <div class="stat-card orange">
                <div class="stat-icon">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number"> 355 </div>
                    <p class="stat-label">Orders</p>
                </div>
            </div>
        </div>
    </div>

        
        <!-- Charts Section -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8 fade-in">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Sales Overview</h3>
                        <select class="period-select" id="salesPeriod">
                            <option value="7">Last 7 days</option>
                            <option value="30" selected>Last 30 days</option>
                            <option value="90">Last 90 days</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 fade-in" style="animation-delay: 0.1s">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Customer Growth</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders Table -->
        <div class="row mb-4 fade-in" style="animation-delay: 0.2s">
            <div class="col-12">
                <div class="table-card">
                    <div class="table-header">
                        <h3>Recent Orders</h3>
                        <a href="#" class="view-all-btn">View All Orders</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td>#{{ str_pad($order->id ?? $order['id'], 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $order->customer_name ?? $order['customer'] ?? 'Customer Name' }}</td>
                                    <td>{{ $order->created_at ? $order->created_at->format('M d, Y') : ($order['date'] ?? 'N/A') }}</td>
                                    <td>
                                        @php
                                            $status = $order->status ?? $order['status'] ?? 'pending';
                                        @endphp
                                        @if($status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-info">Processing</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($order->total_amount ?? $order['total'] ?? 0, 2) }}</td>
                                    <td>
                                        <button class="action-btn" onclick="viewOrder({{ $order->id ?? $order['id'] }})">
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-cart-x me-2"></i>
                                            No orders found
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Information Section -->
        <div class="row g-3 fade-in" style="animation-delay: 0.3s">
            <div class="col-lg-6">
                <div class="info-card">
                    <h4>Top Products</h4>
                    @foreach($topProducts ?? [] as $product)
                    <div class="info-item">
                        <span class="info-label">{{ $product['name'] ?? $product->name ?? 'Product Name' }}</span>
                        <span class="info-value">${{ number_format($product['revenue'] ?? $product->revenue ?? 0, 0) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="info-card">
                    <h4>Store Performance</h4>
                    <div class="info-item">
                        <span class="info-label">Conversion Rate</span>
                        <span class="info-value">{{ $performance['conversion_rate'] ?? '3.25' }}%</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Avg. Order Value</span>
                        <span class="info-value">${{ number_format($performance['avg_order_value'] ?? 156.80, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Returning Customers</span>
                        <span class="info-value">{{ $performance['returning_customers'] ?? '42' }}%</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Inventory Turnover</span>
                        <span class="info-value">{{ $performance['inventory_turnover'] ?? '4.2' }}x</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Sales ($)',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Initialize Growth Chart
            const growthCtx = document.getElementById('growthChart').getContext('2d');
            const growthChart = new Chart(growthCtx, {
                type: 'doughnut',
                data: {
                    labels: ['New Customers', 'Returning Customers', 'Inactive'],
                    datasets: [{
                        data: [55, 30, 15],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#e5e7eb'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                            }
                        }
                    }
                }
            });
            
            // Period Select Change Event
            document.getElementById('salesPeriod').addEventListener('change', function(e) {
                const period = e.target.value;
                alert('Loading data for last ' + period + ' days');
                // In real implementation, fetch new data and update chart
            });
            
            // Sample data for demo
            window.recentOrders = [
                {id: 1, customer: 'John Doe', date: 'Mar 15, 2024', status: 'completed', total: 299.99},
                {id: 2, customer: 'Jane Smith', date: 'Mar 14, 2024', status: 'pending', total: 159.50},
                {id: 3, customer: 'Robert Johnson', date: 'Mar 13, 2024', status: 'processing', total: 599.99},
                {id: 4, customer: 'Emily Davis', date: 'Mar 12, 2024', status: 'completed', total: 89.99},
                {id: 5, customer: 'Michael Wilson', date: 'Mar 11, 2024', status: 'completed', total: 349.99}
            ];
            
            window.topProducts = [
                {name: 'Wireless Headphones', revenue: 12500},
                {name: 'Smart Watch', revenue: 9800},
                {name: 'Laptop Backpack', revenue: 7500},
                {name: 'Phone Case', revenue: 5200},
                {name: 'USB-C Cable', revenue: 3100}
            ];
        });
        
        // View Order Function
        function viewOrder(orderId) {
            alert('Viewing order #' + orderId);
            // In real implementation, redirect to order details
            // window.location.href = '/orders/' + orderId;
        }
        
        // Refresh Dashboard Data
        function refreshDashboard() {
            // Show loading state
            const refreshBtn = document.querySelector('.refresh-btn');
            if (refreshBtn) {
                refreshBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Refreshing...';
                refreshBtn.disabled = true;
            }
            
            // Simulate API call
            setTimeout(() => {
                if (refreshBtn) {
                    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i> Refresh';
                    refreshBtn.disabled = false;
                }
                alert('Dashboard data refreshed!');
            }, 1500);
        }
        
        // Export Dashboard Data
        function exportDashboardData() {
            const data = {
                timestamp: new Date().toISOString(),
                stats: {
                    categories: 466,
                    subcategories: 456,
                    products: 464,
                    orders: 355
                },
                performance: {
                    conversion_rate: '3.25%',
                    avg_order_value: '$156.80',
                    returning_customers: '42%',
                    inventory_turnover: '4.2x'
                }
            };
            
            const dataStr = JSON.stringify(data, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = 'dashboard-data-' + new Date().toISOString().split('T')[0] + '.json';
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
        }
    </script>
@endsection