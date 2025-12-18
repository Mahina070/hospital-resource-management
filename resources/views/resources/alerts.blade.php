<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Shortage Alerts - Hospital Resource Allocation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --critical-color: #ff0000;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 50px;
        }

        .alert-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .header-section h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-section h1 i {
            color: var(--danger-color);
            font-size: 2.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .back-button {
            background: white;
            border-radius: 10px;
            padding: 12px 25px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .back-button:hover {
            transform: translateX(-5px);
            color: var(--danger-color);
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .summary-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 15px;
        }

        .summary-card .icon.critical {
            background: linear-gradient(135deg, #ff0000 0%, #ff6b6b 100%);
        }

        .summary-card .icon.low {
            background: linear-gradient(135deg, #ffa500 0%, #ffcc00 100%);
        }

        .summary-card .icon.total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .summary-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .summary-card p {
            color: #6c757d;
            margin: 0;
        }

        .alerts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .alert-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .alert-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
        }

        .alert-card.critical::before {
            background: linear-gradient(90deg, #ff0000, #ff6b6b);
            animation: blink 1.5s infinite;
        }

        .alert-card.low::before {
            background: linear-gradient(90deg, #ffa500, #ffcc00);
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .alert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .alert-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .alert-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .alert-icon.critical {
            background: linear-gradient(135deg, #ff0000, #ff6b6b);
        }

        .alert-icon.low {
            background: linear-gradient(135deg, #ffa500, #ffcc00);
        }

        .alert-title h5 {
            margin: 0;
            font-weight: 700;
            color: #333;
        }

        .resource-id {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 3px;
        }

        .alert-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
        }

        .quantity-indicator {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .quantity-indicator.critical {
            background: #ffe5e5;
            color: #ff0000;
        }

        .quantity-indicator.low {
            background: #fff4e5;
            color: #ff8800;
        }

        .severity-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .severity-badge.critical {
            background: #ff0000;
            color: white;
            animation: pulse-badge 1.5s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .severity-badge.low {
            background: #ffa500;
            color: white;
        }

        .empty-state {
            background: white;
            border-radius: 15px;
            padding: 80px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #28a745;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
        }

        .progress-bar-custom {
            height: 8px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .progress-fill.critical {
            background: linear-gradient(90deg, #ff0000, #ff6b6b);
        }

        .progress-fill.low {
            background: linear-gradient(90deg, #ffa500, #ffcc00);
        }
    </style>
</head>
<body>
    <div class="alert-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1>
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Resource Shortage Alerts
                    </h1>
                    <p class="text-muted mb-0">Critical and low stock resources requiring immediate attention</p>
                </div>
                <a href="{{ route('dashboard') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="icon critical">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                </div>
                <h3>{{ $lowStockResources->where('quantity_available', '<', 5)->count() }}</h3>
                <p>Critical Stock (< 5 units)</p>
            </div>
            <div class="summary-card">
                <div class="icon low">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h3>{{ $lowStockResources->where('quantity_available', '>=', 5)->count() }}</h3>
                <p>Low Stock (5-9 units)</p>
            </div>
            <div class="summary-card">
                <div class="icon total">
                    <i class="bi bi-list-check"></i>
                </div>
                <h3>{{ $lowStockResources->count() }}</h3>
                <p>Total Alerts</p>
            </div>
        </div>

        <!-- Alerts Grid -->
        @if($lowStockResources->count() > 0)
            <div class="alerts-grid">
                @foreach($lowStockResources as $resource)
                <div class="alert-card {{ $resource->quantity_available < 5 ? 'critical' : 'low' }}">
                    <span class="severity-badge {{ $resource->quantity_available < 5 ? 'critical' : 'low' }}">
                        {{ $resource->quantity_available < 5 ? 'Critical' : 'Low Stock' }}
                    </span>

                    <div class="alert-header">
                        <div class="alert-icon {{ $resource->quantity_available < 5 ? 'critical' : 'low' }}">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="alert-title">
                            <h5>{{ $resource->name }}</h5>
                            <div class="resource-id">ID: {{ $resource->resource_id }}</div>
                        </div>
                    </div>

                    <div class="alert-details">
                        <div class="detail-item">
                            <span class="detail-label">Resource Type</span>
                            <span class="detail-value">{{ $resource->type }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Quantity</span>
                            <span class="detail-value">{{ $resource->quantity_total }}</span>
                        </div>
                        <div class="detail-item" style="grid-column: 1 / -1;">
                            <span class="detail-label">Available Quantity</span>
                            <span class="quantity-indicator {{ $resource->quantity_available < 5 ? 'critical' : 'low' }}">
                                <i class="bi bi-{{ $resource->quantity_available < 5 ? 'exclamation-octagon-fill' : 'exclamation-triangle-fill' }}"></i>
                                {{ $resource->quantity_available }} units
                            </span>
                            <div class="progress-bar-custom">
                                <div class="progress-fill {{ $resource->quantity_available < 5 ? 'critical' : 'low' }}" 
                                     style="width: {{ ($resource->quantity_available / $resource->quantity_total) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-check-circle-fill"></i>
                <h3>All Resources Well Stocked!</h3>
                <p>No resources are currently below the minimum threshold of 10 units.</p>
                <p class="text-muted mt-2">You will be notified when any resource falls below 10 units.</p>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
