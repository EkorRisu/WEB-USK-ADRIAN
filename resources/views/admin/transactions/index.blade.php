@extends('layouts.admin')

@section('content')
    <div class="transaction-dashboard">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <span class="title-icon">📋</span>
                        Transaction Management
                    </h1>
                    <p class="page-subtitle">Monitor and manage all user transactions</p>
                </div>
                <div class="header-stats">
                    <div class="stat-card">
                        <div class="stat-value">{{ $transactions->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $transactions->where('status', 'dikirim')->count() }}</div>
                        <div class="stat-label">Shipped</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ $transactions->where('status', 'selesai')->count() }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filter-tabs">
                <button class="filter-tab active" data-status="all">All Transactions</button>
                <button class="filter-tab" data-status="pending">Pending</button>
                <button class="filter-tab" data-status="dikirim">Shipped</button>
                <button class="filter-tab" data-status="selesai">Completed</button>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search transactions..." class="search-input">
                <button class="search-btn">🔍</button>
            </div>
        </div>

        <!-- Transactions Grid -->
        <div class="transactions-grid">
            @forelse ($transactions as $trx)
                <div class="transaction-card" data-status="{{ $trx->status }}">
                    <div class="card-header">
                        <div class="invoice-info">
                            <h3 class="invoice-number">#{{ str_pad($trx->id, 6, '0', STR_PAD_LEFT) }}</h3>
                            <div class="transaction-date">
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="status-badge status-{{ $trx->status }}">
                            @if($trx->status === 'pending')
                                <span class="status-icon">⏳</span>
                            @elseif($trx->status === 'dikirim')
                                <span class="status-icon">🚚</span>
                            @elseif($trx->status === 'selesai')
                                <span class="status-icon">✅</span>
                            @endif
                            {{ strtoupper($trx->status) }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($trx->user->name, 0, 1)) }}
                            </div>
                            <div class="customer-details">
                                <h4 class="customer-name">{{ $trx->user->name }}</h4>
                                <p class="customer-contact">📞 {{ $trx->telepon }}</p>
                                <p class="customer-address">📍 {{ Str::limit($trx->alamat, 30) }}</p>
                            </div>
                        </div>

                        <div class="payment-info">
                            <div class="payment-method">
                                <span class="payment-label">Payment Method:</span>
                                <span class="payment-value">{{ ucfirst($trx->metode_pembayaran) }}</span>
                            </div>
                            <div class="total-amount">
                                Rp {{ number_format($trx->total, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="products-section">
                            <h5 class="products-title">🛒 Items Ordered</h5>
                            <div class="products-list">
                                @foreach ($trx->items as $item)
                                    <div class="product-item">
                                        <div class="product-info">
                                            <span class="product-name">{{ $item->produk->nama }}</span>
                                            <span class="product-quantity">x{{ $item->jumlah }}</span>
                                        </div>
                                        <div class="product-price">
                                            Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-actions">
                        

                        @if ($trx->status === 'pending')
                            <form method="POST" action="{{ route('admin.transactions.konfirmasi', $trx->id) }}" class="confirm-form">
                                @csrf
                                <button type="submit" class="action-btn btn-confirm">
                                    <span class="btn-icon">✅</span>
                                    Confirm Order
                                </button>
                            </form>
                        @endif

                        @if ($trx->status === 'dikirim')
                            <button class="action-btn btn-complete" onclick="markAsComplete({{ $trx->id }})">
                                <span class="btn-icon">📦</span>
                                Mark Complete
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>No Transactions Found</h3>
                    <p>There are no transactions to display at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Filter functionality
                const filterTabs = document.querySelectorAll('.filter-tab');
                const transactionCards = document.querySelectorAll('.transaction-card');

                filterTabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        // Remove active class from all tabs
                        filterTabs.forEach(t => t.classList.remove('active'));
                        // Add active class to clicked tab
                        this.classList.add('active');

                        const status = this.dataset.status;

                        // Filter cards
                        transactionCards.forEach(card => {
                            if (status === 'all' || card.dataset.status === status) {
                                card.style.display = 'block';
                                card.style.animation = 'slideInUp 0.3s ease-out';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

                // Search functionality
                const searchInput = document.querySelector('.search-input');
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    transactionCards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });

                // Confirm form submission
                const confirmForms = document.querySelectorAll('.confirm-form');
                confirmForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const confirmBtn = this.querySelector('.btn-confirm');
                        confirmBtn.innerHTML = '<span class="btn-icon">⏳</span>Processing...';
                        confirmBtn.disabled = true;

                        setTimeout(() => {
                            this.submit();
                        }, 1000);
                    });
                });

                // Card hover effects
                transactionCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-4px) scale(1.02)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });
            });

            function markAsComplete(transactionId) {
                if (confirm('Mark this transaction as completed?')) {
                    // Add your completion logic here
                    alert('Transaction marked as completed!');
                }
            }
        </script>
    @endpush

    <style>
        .transaction-dashboard {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 90vh;
            padding: 2rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Header Section */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .title-icon {
            font-size: 2rem;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
        }

        .header-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            text-align: center;
            min-width: 80px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Filters Section */
        .filters-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 2rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .filter-tab {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .filter-tab.active,
        .filter-tab:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .search-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 25px;
            padding: 0.5rem;
            backdrop-filter: blur(10px);
        }

        .search-input {
            border: none;
            outline: none;
            padding: 0.5rem 1rem;
            background: transparent;
            font-size: 0.9rem;
            width: 250px;
        }

        .search-btn {
            background: #667eea;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            color: white;
            font-size: 1rem;
        }

        /* Transactions Grid */
        .transactions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 1.5rem;
        }

        .transaction-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .transaction-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 1px solid #e2e8f0;
        }

        .invoice-number {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .transaction-date {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-dikirim {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-selesai {
            background: #d1fae5;
            color: #065f46;
        }

        .card-body {
            padding: 1.5rem;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .customer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .customer-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.25rem 0;
        }

        .customer-contact,
        .customer-address {
            font-size: 0.875rem;
            color: #64748b;
            margin: 0.125rem 0;
        }

        .payment-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .payment-label {
            font-size: 0.875rem;
            color: #64748b;
        }

        .payment-value {
            font-weight: 600;
            color: #1e293b;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: #059669;
        }

        .products-section {
            margin-bottom: 1.5rem;
        }

        .products-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .products-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 6px;
        }

        .product-info {
            display: flex;
            gap: 0.5rem;
        }

        .product-name {
            font-weight: 500;
            color: #1e293b;
        }

        .product-quantity {
            color: #64748b;
            font-size: 0.875rem;
        }

        .product-price {
            font-weight: 600;
            color: #059669;
        }

        .card-actions {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            display: flex;
            gap: 0.75rem;
            border-top: 1px solid #e2e8f0;
        }

        .action-btn {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            flex: 1;
            justify-content: center;
        }

        .btn-view {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-view:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-confirm {
            background: #10b981;
            color: white;
        }

        .btn-confirm:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-complete {
            background: #3b82f6;
            color: white;
        }

        .btn-complete:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .confirm-form {
            flex: 1;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #64748b;
            font-size: 1rem;
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .transaction-card {
            animation: slideInUp 0.4s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .transaction-dashboard {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .page-title {
                font-size: 2rem;
            }

            .filters-section {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-tabs {
                flex-wrap: wrap;
                justify-content: center;
            }

            .transactions-grid {
                grid-template-columns: 1fr;
            }

            .search-input {
                width: 200px;
            }

            .card-actions {
                flex-direction: column;
            }
        }
    </style>
@endsection