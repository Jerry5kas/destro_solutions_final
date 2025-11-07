<x-admin-layout title="Dashboard - Destrosolutions">
    <h1 class="page-title">Dashboard</h1>
    
    <div class="dashboard-grid">
        <!-- Revenue Card -->
        <div class="dashboard-card revenue-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Revenue</h2>
                    <p class="card-subtitle">Sales from {{ date('1-12 M, Y') }}</p>
                </div>
                <a href="#" class="card-action">View Report</a>
            </div>
            <div class="revenue-value">${{ number_format(7852000, 0, '.', ',') }}</div>
            <div class="revenue-trend trend-up">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 11.5 4.5 8.5 5.5 7.5 7.5 9.5 10.5 6.5 11.5 7.5 7.5 11.5z"/>
                </svg>
                <span>2.1% vs last week</span>
            </div>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Order Time Card -->
        <div class="dashboard-card order-time-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Order Time</h2>
                    <p class="card-subtitle">From {{ date('1-6 M, Y') }}</p>
                </div>
                <a href="#" class="card-action">View Report</a>
            </div>
            <div class="donut-chart-container">
                <canvas id="orderTimeChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <div class="legend-dot" style="background: #0D0DE0;"></div>
                    <span>Afternoon 40%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background: #6366f1;"></div>
                    <span>Evening 32%</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot" style="background: #93c5fd;"></div>
                    <span>Morning 28%</span>
                </div>
            </div>
        </div>
        
        <!-- Your Rating Card -->
        <div class="dashboard-card rating-card">
            <h2 class="card-title">Your Rating</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Customer satisfaction metrics</p>
            <div class="rating-charts">
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingHygiene"></canvas>
                        <div class="rating-value">85%</div>
                    </div>
                    <div class="rating-label">Hygiene</div>
                </div>
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingTaste"></canvas>
                        <div class="rating-value">88%</div>
                    </div>
                    <div class="rating-label">Service Quality</div>
                </div>
                <div class="rating-item">
                    <div class="rating-circle">
                        <canvas id="ratingPackaging"></canvas>
                        <div class="rating-value">92%</div>
                    </div>
                    <div class="rating-label">Customer Support</div>
                </div>
            </div>
        </div>
        
        <!-- Most Ordered Card -->
        <div class="dashboard-card most-ordered-card">
            <h2 class="card-title">Most Popular Services</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Top performing services</p>
            <div class="ordered-list">
                <div class="ordered-item">
                    <div class="ordered-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ordered-info">
                        <div class="ordered-name">Cybersecurity Services</div>
                        <div class="ordered-price">$45,000</div>
                    </div>
                </div>
                <div class="ordered-item">
                    <div class="ordered-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ordered-info">
                        <div class="ordered-name">Functional Safety</div>
                        <div class="ordered-price">$75,000</div>
                    </div>
                </div>
                <div class="ordered-item">
                    <div class="ordered-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                        </svg>
                    </div>
                    <div class="ordered-info">
                        <div class="ordered-name">Software Update Management</div>
                        <div class="ordered-price">$45,000</div>
                    </div>
                </div>
                <div class="ordered-item">
                    <div class="ordered-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ordered-info">
                        <div class="ordered-name">ASPICE Consulting</div>
                        <div class="ordered-price">$45,000</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Card -->
        <div class="dashboard-card order-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Total Orders</h2>
                    <p class="card-subtitle">Sales from {{ date('1-6 M, Y') }}</p>
                </div>
                <a href="#" class="card-action">View Report</a>
            </div>
            <div class="order-value">{{ number_format(\App\Models\User::count() * 128, 0, '.', ',') }}</div>
            <div class="revenue-trend trend-down">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M7.5 4.5 4.5 7.5 5.5 8.5 7.5 6.5 10.5 9.5 11.5 8.5 7.5 4.5z"/>
                </svg>
                <span>2.1% vs last week</span>
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
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                datasets: [
                    {
                        label: 'Last 6 days',
                        data: [120, 190, 300, 250, 400, 350, 280, 320, 380, 300, 420, 450],
                        backgroundColor: '#0D0DE0',
                        borderRadius: 6
                    },
                    {
                        label: 'Last Week',
                        data: [100, 150, 250, 200, 300, 280, 220, 280, 320, 250, 350, 380],
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
                    data: [40, 32, 28],
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
        
        createRatingChart('ratingHygiene', 85, '#8b5cf6');
        createRatingChart('ratingTaste', 88, '#f59e0b');
        createRatingChart('ratingPackaging', 92, '#0D0DE0');
        
        // Order Chart (Line Chart)
        const orderCtx = document.getElementById('orderChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'line',
            data: {
                labels: ['01', '02', '03', '04', '05', '06'],
                datasets: [
                    {
                        label: 'Last 6 days',
                        data: [120, 190, 300, 250, 400, 350],
                        borderColor: '#0D0DE0',
                        backgroundColor: 'rgba(13, 13, 224, 0.1)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 2
                    },
                    {
                        label: 'Last Week',
                        data: [100, 150, 250, 200, 300, 280],
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
