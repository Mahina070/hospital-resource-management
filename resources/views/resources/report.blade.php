<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Booking Report - Hospital Resource Allocation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 50px;
        }

        .report-container {
            max-width: 1600px;
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
            color: var(--primary-color);
            font-size: 2.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .filter-section h5 {
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .report-table {
            width: 100%;
            margin-bottom: 0;
        }

        .report-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .report-table thead th {
            padding: 15px;
            font-weight: 600;
            border: none;
            white-space: nowrap;
        }

        .report-table thead th:first-child {
            border-radius: 10px 0 0 0;
        }

        .report-table thead th:last-child {
            border-radius: 0 10px 0 0;
        }

        .report-table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .report-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #997404;
        }

        .status-approved {
            background: #d1f2eb;
            color: #0f5132;
        }

        .status-rejected {
            background: #f8d7da;
            color: #842029;
        }

        .date-badge {
            background: #e7f1ff;
            color: #004085;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: inline-block;
        }

        .time-badge {
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: inline-block;
        }

        .empty-state {
            text-align: center;
            padding: 60px 30px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        @media print {
            body {
                background: white;
            }

            .header-section,
            .filter-section,
            .table-container {
                box-shadow: none;
                border: 1px solid #dee2e6;
            }

            .action-buttons,
            .filter-section {
                display: none !important;
            }

            .report-table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1>
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        Resource Booking Report
                    </h1>
                    <p class="text-muted mb-0">Comprehensive report of all resource booking requests</p>
                </div>
                <div class="action-buttons">
                    <button onclick="window.print()" class="btn btn-custom btn-primary">
                        <i class="bi bi-printer"></i> Print Report
                    </button>
                    <button onclick="exportToCSV()" class="btn btn-custom btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Export CSV
                    </button>
                    <a href="{{ route('resource.index') }}" class="btn btn-custom btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number text-primary">{{ $bookings->count() }}</div>
                <div class="stat-label">
                    <i class="bi bi-list-check"></i> Total Requests
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-success">{{ $bookings->where('status', 'approved')->count() }}</div>
                <div class="stat-label">
                    <i class="bi bi-check-circle"></i> Approved
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-warning">{{ $bookings->where('status', 'pending')->count() }}</div>
                <div class="stat-label">
                    <i class="bi bi-hourglass-split"></i> Pending
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-danger">{{ $bookings->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">
                    <i class="bi bi-x-circle"></i> Rejected
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-info">{{ $bookings->sum('quantity_requested') }}</div>
                <div class="stat-label">
                    <i class="bi bi-box-seam"></i> Total Units Requested
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-success">{{ $bookings->where('status', 'approved')->sum('quantity_requested') }}</div>
                <div class="stat-label">
                    <i class="bi bi-box-seam"></i> Units Allocated
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <h5><i class="bi bi-funnel"></i> Filter Options</h5>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Resource Type</label>
                    <select id="typeFilter" class="form-select">
                        <option value="">All Types</option>
                        @foreach($bookings->unique('resource_type')->pluck('resource_type') as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date From</label>
                    <input type="date" id="dateFrom" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date To</label>
                    <input type="date" id="dateTo" class="form-control">
                </div>
            </div>
            <div class="mt-3">
                <button onclick="applyFilters()" class="btn btn-primary">
                    <i class="bi bi-search"></i> Apply Filters
                </button>
                <button onclick="resetFilters()" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </button>
            </div>
        </div>

        <!-- Report Table -->
        <div class="table-container">
            <h5 class="mb-4">
                <i class="bi bi-table"></i> Booking Records
                <span class="badge bg-primary ms-2" id="recordCount">{{ $bookings->count() }} records</span>
            </h5>

            @if($bookings->count() > 0)
                <table class="report-table table" id="reportTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Request Date</th>
                            <th>Request Time</th>
                            <th>Resource Name</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Requested By</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Approved/Rejected Date</th>
                            <th>Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                        <tr data-status="{{ $booking->status }}" 
                            data-type="{{ $booking->resource_type }}"
                            data-date="{{ $booking->created_at->format('Y-m-d') }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="date-badge">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $booking->created_at->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="time-badge">
                                    <i class="bi bi-clock"></i>
                                    {{ $booking->created_at->format('h:i:s A') }}
                                </span>
                            </td>
                            <td><strong>{{ $booking->resource_name }}</strong></td>
                            <td>{{ $booking->resource_type }}</td>
                            <td><strong class="text-primary">{{ $booking->quantity_requested }}</strong></td>
                            <td>{{ $booking->requested_by }}</td>
                            <td>{{ $booking->requested_position }}</td>
                            <td>{{ $booking->department ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ $booking->status }}">
                                    @if($booking->status == 'pending')
                                        <i class="bi bi-hourglass-split"></i>
                                    @elseif($booking->status == 'approved')
                                        <i class="bi bi-check-circle"></i>
                                    @else
                                        <i class="bi bi-x-circle"></i>
                                    @endif
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                @if($booking->approved_at)
                                    <span class="date-badge">
                                        <i class="bi bi-calendar-check"></i>
                                        {{ $booking->approved_at->format('M d, Y h:i:s A') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $booking->approved_by ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h3>No Booking Records</h3>
                    <p>There are no booking requests to display in the report.</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let allRows = [];

        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#reportTable tbody');
            if (tableBody) {
                allRows = Array.from(tableBody.querySelectorAll('tr'));
            }
        });

        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            let visibleCount = 0;

            allRows.forEach(row => {
                const status = row.dataset.status.toLowerCase();
                const type = row.dataset.type.toLowerCase();
                const date = row.dataset.date;

                let show = true;

                // Status filter
                if (statusFilter && status !== statusFilter) {
                    show = false;
                }

                // Type filter
                if (typeFilter && !type.includes(typeFilter)) {
                    show = false;
                }

                // Date range filter
                if (dateFrom && date < dateFrom) {
                    show = false;
                }

                if (dateTo && date > dateTo) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
                if (show) {
                    visibleCount++;
                    // Update row number
                    row.querySelector('td:first-child').textContent = visibleCount;
                }
            });

            // Update record count
            document.getElementById('recordCount').textContent = `${visibleCount} records`;
        }

        function resetFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';

            allRows.forEach((row, index) => {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = index + 1;
            });

            document.getElementById('recordCount').textContent = `${allRows.length} records`;
        }

        function exportToCSV() {
            const table = document.getElementById('reportTable');
            if (!table) {
                alert('No data to export');
                return;
            }

            let csv = [];
            const rows = table.querySelectorAll('tr');

            // Get visible rows only
            const visibleRows = Array.from(rows).filter(row => {
                return row.style.display !== 'none';
            });

            visibleRows.forEach(row => {
                const cols = row.querySelectorAll('td, th');
                const csvRow = [];
                cols.forEach(col => {
                    // Clean the text (remove extra spaces and newlines)
                    let text = col.innerText.replace(/\s+/g, ' ').trim();
                    // Escape quotes
                    text = text.replace(/"/g, '""');
                    csvRow.push('"' + text + '"');
                });
                csv.push(csvRow.join(','));
            });

            // Create CSV file
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', 'resource_booking_report_' + new Date().toISOString().split('T')[0] + '.csv');
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
