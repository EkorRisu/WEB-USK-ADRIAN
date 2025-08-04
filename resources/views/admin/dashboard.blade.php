@extends('layouts.admin')
@section('content')
    <div class="admin-dashboard-dark">
        <!-- Top Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value">2,847</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">156</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">23</div>
                <div class="stat-label">Pending Orders</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">98.5%</div>
                <div class="stat-label">System Health</div>
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-text">
                <h1>Dashboard Overview</h1>
                <p>Monitor and manage your entire system from this central hub</p>
            </div>
            <div class="welcome-avatar">
                <div class="avatar-circle">
                    <span>A</span>
                </div>
                <div class="status-dot"></div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="main-grid">
            <!-- Left Column - Primary Actions -->
            <div class="primary-column">
                <a href="{{ route('admin.users.index') }}" class="primary-card users-card">
                    <div class="card-background"></div>
                    <div class="card-content">
                        <div class="card-header">
                            <div class="card-icon">👥</div>
                            <div class="card-badge">Active</div>
                        </div>
                        <h3>User Management</h3>
                        <p>Manage user accounts, permissions, and access levels</p>
                        <div class="card-stats">
                            <span>+12 new this week</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </a>

                <a href="{{ route('admin.produk.index') }}" class="primary-card products-card">
                    <div class="card-background"></div>
                    <div class="card-content">
                        <div class="card-header">
                            <div class="card-icon">📦</div>
                            <div class="card-badge">Updated</div>
                        </div>
                        <h3>Product Catalog</h3>
                        <p>Add, edit, and organize your product inventory</p>
                        <div class="card-stats">
                            <span>156 total items</span>
                        </div>
                    </div>
                    <div class="card-glow"></div>
                </a>
            </div>

            <!-- Center Column - Secondary Actions -->
            <div class="secondary-column">
                <a href="{{ route('admin.kategori.index') }}" class="secondary-card">
                    <div class="card-icon-small">🏷️</div>
                    <div class="card-info">
                        <h4>Categories</h4>
                        <p>Organize product categories</p>
                    </div>
                    <div class="card-arrow">→</div>
                </a>

                <a href="{{ route('admin.transactions.index') }}" class="secondary-card urgent">
                    <div class="card-icon-small">🛒</div>
                    <div class="card-info">
                        <h4>Order Confirmation</h4>
                        <p>Process customer orders</p>
                        <span class="urgent-badge">23 pending</span>
                    </div>
                    <div class="card-arrow">→</div>
                </a>

                <div class="secondary-card">
                    <div class="card-icon-small">📊</div>
                    <div class="card-info">
                        <h4>System Logs</h4>
                        <p>Monitor system activity</p>
                    </div>
                    <div class="card-arrow">→</div>
                </div>

                <a href="{{ route('admin.chat') }}" class="secondary-card chat-card">
                    <div class="card-icon-small">💬</div>
                    <div class="card-info">
                        <h4>Admin Chat</h4>
                        <p>Team communication</p>
                        <span class="online-indicator">● 3 online</span>
                    </div>
                    <div class="card-arrow">→</div>
                </a>
            </div>

            <!-- Right Column - Analytics -->
            <div class="analytics-column">
                <div class="analytics-card">
                    <h4>Quick Analytics</h4>
                    <div class="chart-container">
                        <div class="chart-bar" style="height: 60%"></div>
                        <div class="chart-bar" style="height: 80%"></div>
                        <div class="chart-bar" style="height: 45%"></div>
                        <div class="chart-bar" style="height: 90%"></div>
                        <div class="chart-bar" style="height: 70%"></div>
                    </div>
                    <p>Revenue trend this month</p>
                </div>

                <div class="activity-card">
                    <h4>Recent Activity</h4>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div class="activity-text">
                                <span>New user registered</span>
                                <time>2 min ago</time>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div class="activity-text">
                                <span>Product updated</span>
                                <time>15 min ago</time>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div class="activity-text">
                                <span>Order confirmed</span>
                                <time>1 hour ago</time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Animate stats on load
                const statValues = document.querySelectorAll('.stat-value');
                statValues.forEach((stat, index) => {
                    setTimeout(() => {
                        stat.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            stat.style.transform = 'scale(1)';
                        }, 200);
                    }, index * 100);
                });

                // Add hover effects to cards
                const cards = document.querySelectorAll('.primary-card, .secondary-card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function () {
                        this.style.transform = 'translateY(-4px) scale(1.02)';
                    });

                    card.addEventListener('mouseleave', function () {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });

                // Animate chart bars
                const chartBars = document.querySelectorAll('.chart-bar');
                chartBars.forEach((bar, index) => {
                    setTimeout(() => {
                        bar.style.transform = 'scaleY(1)';
                    }, index * 100);
                });
            });
        </script>
    @endpush

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .admin-dashboard-dark {
            min-height:90vh;
            color: #e2e8f0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding: 2rem;
        }

        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: linear-gradient(135deg, #1e1e3f 0%, #2d2d5f 100%);
            border: 1px solid #3d3d7f;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            border-color: #6366f1;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #6366f1;
            margin-bottom: 0.5rem;
            transition: transform 0.3s ease;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Welcome Section */
        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 2rem;
            background: linear-gradient(135deg, #1e1e3f 0%, #2d2d5f 100%);
            border-radius: 16px;
            border: 1px solid #3d3d7f;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: #94a3b8;
            font-size: 1.1rem;
        }

        .welcome-avatar {
            position: relative;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .status-dot {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 16px;
            height: 16px;
            background: #10b981;
            border-radius: 50%;
            border: 3px solid #0f0f23;
        }

        /* Main Grid */
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr;
            gap: 2rem;
        }

        /* Primary Cards */
        .primary-card {
            position: relative;
            background: linear-gradient(135deg, #1e1e3f 0%, #2d2d5f 100%);
            border: 1px solid #3d3d7f;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-decoration: none;
            color: inherit;
            display: block;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .primary-card:hover {
            border-color: #6366f1;
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.2);
        }

        .card-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .users-card .card-background {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        }

        .products-card .card-background {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(6, 182, 212, 0.1));
        }

        .primary-card:hover .card-background {
            opacity: 1;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-icon {
            font-size: 2rem;
        }

        .card-badge {
            background: rgba(99, 102, 241, 0.2);
            color: #6366f1;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .card-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #f1f5f9;
        }

        .card-content p {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .card-stats {
            color: #6366f1;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Secondary Cards */
        .secondary-card {
            background: linear-gradient(135deg, #1e1e3f 0%, #2d2d5f 100%);
            border: 1px solid #3d3d7f;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .secondary-card:hover {
            border-color: #6366f1;
            transform: translateX(4px);
        }

        .secondary-card.urgent {
            border-color: #ef4444;
        }

        .secondary-card.urgent:hover {
            border-color: #dc2626;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
        }

        .card-icon-small {
            font-size: 1.5rem;
            width: 40px;
            text-align: center;
        }

        .card-info {
            flex-grow: 1;
        }

        .card-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #f1f5f9;
        }

        .card-info p {
            font-size: 0.875rem;
            color: #94a3b8;
            margin: 0;
        }

        .urgent-badge {
            background: #ef4444;
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .online-indicator {
            color: #10b981;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .card-arrow {
            color: #6366f1;
            font-size: 1.25rem;
            transition: transform 0.3s ease;
        }

        .secondary-card:hover .card-arrow {
            transform: translateX(4px);
        }

        /* Analytics Column */
        .analytics-card,
        .activity-card {
            background: linear-gradient(135deg, #1e1e3f 0%, #2d2d5f 100%);
            border: 1px solid #3d3d7f;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .analytics-card h4,
        .activity-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #f1f5f9;
        }

        .chart-container {
            display: flex;
            align-items: end;
            gap: 0.5rem;
            height: 80px;
            margin-bottom: 1rem;
        }

        .chart-bar {
            background: linear-gradient(to top, #6366f1, #8b5cf6);
            border-radius: 4px 4px 0 0;
            flex: 1;
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.6s ease;
        }

        .analytics-card p {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            background: #6366f1;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .activity-text span {
            display: block;
            font-size: 0.875rem;
            color: #f1f5f9;
        }

        .activity-text time {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-grid {
                grid-template-columns: 1fr 1fr;
            }

            .analytics-column {
                grid-column: span 2;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .admin-dashboard-dark {
                padding: 1rem;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }

            .main-grid {
                grid-template-columns: 1fr;
            }

            .analytics-column {
                grid-column: span 1;
                display: block;
            }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .primary-card,
        .secondary-card,
        .analytics-card,
        .activity-card {
            animation: slideInUp 0.6s ease-out;
        }

        .primary-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .primary-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .secondary-card:nth-child(1) {
            animation-delay: 0.3s;
        }

        .secondary-card:nth-child(2) {
            animation-delay: 0.4s;
        }

        .secondary-card:nth-child(3) {
            animation-delay: 0.5s;
        }

        .secondary-card:nth-child(4) {
            animation-delay: 0.6s;
        }
    </style>
@endsection