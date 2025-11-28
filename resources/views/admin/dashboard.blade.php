<x-admin-layout title="Dashboard - Destrosolutions">
    <h1 class="page-title">Dashboard</h1>
    
    <div class="dashboard-grid">
        <!-- Revenue Card -->
        <div class="dashboard-card revenue-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Revenue</h2>
                    <p class="card-subtitle">Sales from {{ $last12MonthsStart }}</p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="card-action">View Report</a>
            </div>
            <div class="revenue-value">${{ number_format($totalRevenue ?? 0, 0, '.', ',') }}</div>
            <div class="revenue-trend {{ ($revenueGrowth ?? 0) >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    @if(($revenueGrowth ?? 0) >= 0)
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 11.5 4.5 8.5 5.5 7.5 7.5 9.5 10.5 6.5 11.5 7.5 7.5 11.5z"/>
                    @else
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 4.5 4.5 7.5 5.5 8.5 7.5 6.5 10.5 9.5 11.5 8.5 7.5 4.5z"/>
                    @endif
                </svg>
                <span>{{ number_format(abs($revenueGrowth ?? 0), 1) }}% vs previous period</span>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Order Time Card -->
        <div class="dashboard-card order-time-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Enrollment Time</h2>
                    <p class="card-subtitle">From {{ $last6MonthsStart ?? date('1-6 M, Y') }}</p>
                </div>
                <a href="{{ route('admin.enrollments.index') }}" class="card-action">View Report</a>
            </div>
            <div class="donut-chart-container">
                <canvas id="orderTimeChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-dot" style="background: #0D0DE0;"></div>
                    <span>Afternoon {{ $afternoonPercent ?? 40 }}%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background: #6366f1;"></div>
                    <span>Evening {{ $eveningPercent ?? 32 }}%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background: #93c5fd;"></div>
                    <span>Morning {{ $morningPercent ?? 28 }}%</span>
                </div>
            </div>
        </div>
        
        <!-- System Status Card -->
        <div class="dashboard-card rating-card">
            <h2 class="card-title">System Status</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Content and user metrics</p>
            <div class="rating-charts">
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingContent"></canvas>
                        <div class="rating-value">{{ $contentItemPercentage ?? 0 }}%</div>
                    </div>
                    <div class="rating-label">Active Content</div>
                </div>
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingUsers"></canvas>
                        <div class="rating-value">{{ $userPercentage ?? 0 }}%</div>
                    </div>
                    <div class="rating-label">Active Users</div>
                </div>
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingContacts"></canvas>
                        <div class="rating-value">{{ $contactPercentage ?? 0 }}%</div>
                    </div>
                    <div class="rating-label">Processed Contacts</div>
                </div>
            </div>
        </div>
        
        <!-- Most Popular Trainings Card -->
        <div class="dashboard-card most-ordered-card">
            <h2 class="card-title">Most Popular Trainings</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Top performing trainings</p>
            <div class="ordered-list">
                @forelse($popularItems ?? [] as $item)
                <div class="ordered-item">
                    <div class="ordered-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div class="ordered-info">
                        <div class="ordered-name">{{ strlen($item['title']) > 30 ? substr($item['title'], 0, 30) . '...' : $item['title'] }}</div>
                        <div class="ordered-price">{{ $item['formatted_price'] ?? '$0' }} ({{ $item['enrollments_count'] ?? 0 }} enrollments)</div>
                    </div>
                </div>
                @empty
                <div style="padding: 1rem; text-align: center; color: #6b7280; font-size: 0.875rem;">
                    No training enrollments yet
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Order Card -->
        <div class="dashboard-card order-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Total Enrollments</h2>
                    <p class="card-subtitle">From {{ $last6MonthsStart ?? date('1-6 M, Y') }}</p>
                </div>
                <a href="{{ route('admin.enrollments.index') }}" class="card-action">View Report</a>
            </div>
            <div class="order-value">{{ number_format($totalOrders ?? 0, 0, '.', ',') }}</div>
            <div class="revenue-trend {{ ($ordersGrowth ?? 0) >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    @if(($ordersGrowth ?? 0) >= 0)
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 11.5 4.5 8.5 5.5 7.5 7.5 9.5 10.5 6.5 11.5 7.5 7.5 11.5z"/>
                    @else
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 4.5 4.5 7.5 5.5 8.5 7.5 6.5 10.5 9.5 11.5 8.5 7.5 4.5z"/>
                    @endif
                </svg>
                <span>{{ number_format(abs($ordersGrowth ?? 0), 1) }}% vs previous period</span>
            </div>
            <div class="chart-container">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        /* Dashboard Cards - Override for dashboard specific styles */
        .dashboard-card {
            transform: translateY(0);
        }
        
        .dashboard-card:hover {
            transform: translateY(-2px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        
        .card-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .card-action {
            color: #0D0DE0;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }
        
        .card-action:hover {
            background: #eff6ff;
            text-decoration: none;
        }
        
        /* Revenue Card */
        .revenue-card {
            grid-column: span 8;
        }
        
        .revenue-value {
            font-size: 2.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }
        
        .revenue-trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        
        .trend-up {
            color: #10b981;
        }
        
        .trend-down {
            color: #ef4444;
        }
        
        .chart-container {
            position: relative;
            height: 220px;
            margin-top: 1rem;
        }
        
        /* Order Time Card */
        .order-time-card {
            grid-column: span 4;
        }
        
        .donut-chart-container {
            position: relative;
            height: 220px;
            margin: 1rem 0;
        }
        
        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            margin-top: 1.5rem;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            font-size: 0.875rem;
            color: #374151;
        }
        
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        /* Rating Card */
        .rating-card {
            grid-column: span 4;
        }
        
        .rating-charts {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
            margin-top: 1.5rem;
        }
        
        .rating-item {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        
        .rating-circle {
            width: 90px;
            height: 90px;
            position: relative;
            flex-shrink: 0;
        }
        
        .rating-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.375rem;
            font-weight: 600;
            color: #111827;
        }
        
        .rating-label {
            flex: 1;
            font-size: 0.9375rem;
            color: #6b7280;
            font-weight: 500;
        }
        
        /* Most Ordered Card */
        .most-ordered-card {
            grid-column: span 4;
        }
        
        .ordered-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .ordered-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 12px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .ordered-item:hover {
            background: #f3f4f6;
            border-color: #e5e7eb;
            transform: translateX(4px);
        }
        
        .ordered-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0D0DE0;
            flex-shrink: 0;
        }
        
        .ordered-info {
            flex: 1;
            min-width: 0;
        }
        
        .ordered-name {
            font-size: 0.9375rem;
            font-weight: 500;
            color: #111827;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .ordered-price {
            font-size: 0.875rem;
            font-weight: 600;
            color: #0D0DE0;
        }
        
        /* Order Card */
        .order-card {
            grid-column: span 4;
        }
        
        .order-value {
            font-size: 2.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: repeat(8, 1fr);
            }
            
            .revenue-card {
                grid-column: span 8;
            }
            
            .order-time-card {
                grid-column: span 8;
            }
            
            .rating-card {
                grid-column: span 4;
            }
            
            .most-ordered-card {
                grid-column: span 4;
            }
            
            .order-card {
                grid-column: span 8;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
            
            .revenue-card,
            .order-time-card,
            .rating-card,
            .most-ordered-card,
            .order-card {
                grid-column: span 1;
            }
            
            .dashboard-card {
                padding: 1.5rem;
            }
            
            .revenue-value,
            .order-value {
                font-size: 2.25rem;
            }
            
            .chart-container,
            .donut-chart-container {
                height: 200px;
            }
        }
        
        @media (max-width: 640px) {
            .revenue-value,
            .order-value {
                font-size: 2rem;
            }
            
            .rating-circle {
                width: 80px;
                height: 80px;
            }
            
            .rating-value {
                font-size: 1.25rem;
            }
        }
    </style>
    @endpush
    
    @push('scripts')
    <script>
        // Revenue Chart (Bar Chart)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = @json($revenueChartData ?? array_fill(0, 12, 0));
        const previousRevenueData = @json($previousRevenueChartData ?? array_fill(0, 12, 0));
        const monthLabels = [];
        for (let i = 11; i >= 0; i--) {
            const date = new Date();
            date.setMonth(date.getMonth() - i);
            monthLabels.push(('0' + (date.getMonth() + 1)).slice(-2));
        }
        
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: 'Current Period',
                        data: revenueData,
                        backgroundColor: '#0D0DE0',
                        borderRadius: 6
                    },
                    {
                        label: 'Previous Period',
                        data: previousRevenueData,
                        backgroundColor: '#e5e7eb',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
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
        
        // Order Time Chart (Donut Chart)
        const orderTimeCtx = document.getElementById('orderTimeChart').getContext('2d');
        new Chart(orderTimeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Afternoon', 'Evening', 'Morning'],
                datasets: [{
                    data: [{{ $afternoonPercent ?? 40 }}, {{ $eveningPercent ?? 32 }}, {{ $morningPercent ?? 28 }}],
                    backgroundColor: ['#0D0DE0', '#6366f1', '#93c5fd'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Rating Charts (Circular Progress)
        function createRatingChart(canvasId, value, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [value, 100 - value],
                        backgroundColor: [color, '#e5e7eb'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '75%'
                }
            });
        }
        
        createRatingChart('ratingContent', {{ $contentItemPercentage ?? 0 }}, '#8b5cf6');
        createRatingChart('ratingUsers', {{ $userPercentage ?? 0 }}, '#f59e0b');
        createRatingChart('ratingContacts', {{ $contactPercentage ?? 0 }}, '#0D0DE0');
        
        // Order Chart (Line Chart)
        const orderCtx = document.getElementById('orderChart').getContext('2d');
        const ordersData = @json($ordersChartData ?? array_fill(0, 6, 0));
        const previousOrdersData = @json($previousOrdersChartData ?? array_fill(0, 6, 0));
        const monthLabelsOrders = [];
        for (let i = 5; i >= 0; i--) {
            const date = new Date();
            date.setMonth(date.getMonth() - i);
            monthLabelsOrders.push(('0' + (date.getMonth() + 1)).slice(-2));
        }
        
        new Chart(orderCtx, {
            type: 'line',
            data: {
                labels: monthLabelsOrders,
                datasets: [
                    {
                        label: 'Current Period',
                        data: ordersData,
                        borderColor: '#0D0DE0',
                        backgroundColor: 'rgba(13, 13, 224, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    },
                    {
                        label: 'Previous Period',
                        data: previousOrdersData,
                        borderColor: '#e5e7eb',
                        backgroundColor: 'rgba(229, 231, 235, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            display: false
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
    </script>
    @endpush
</x-admin-layout>


