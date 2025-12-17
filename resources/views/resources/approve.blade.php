<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Approve Resource Bookings - Hospital Resource Allocation</title>
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

        .approval-container {
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
            color: var(--primary-color);
            font-size: 2.5rem;
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
            color: var(--primary-color);
        }

        .nav-tabs {
            background: white;
            border-radius: 15px;
            padding: 20px 20px 0;
            margin-bottom: 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 15px 25px;
            border-radius: 10px 10px 0 0;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .tab-content {
            background: white;
            border-radius: 0 0 15px 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .booking-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 5px solid var(--warning-color);
            transition: all 0.3s ease;
        }

        .booking-card.approved {
            border-left-color: var(--success-color);
        }

        .booking-card.rejected {
            border-left-color: var(--danger-color);
        }

        .booking-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }

        .booking-title {
            flex: 1;
        }

        .booking-title h5 {
            margin: 0;
            color: #333;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .booking-meta {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
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

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }

        .booking-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-approve {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
            color: white;
        }

        .btn-reject {
            background: linear-gradient(135deg, #dc3545, #e35d6a);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
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

        .empty-state p {
            color: #adb5bd;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .alert-custom {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body>
    <div class="approval-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1>
                        <i class="bi bi-clipboard-check"></i>
                        Resource Booking Approvals
                    </h1>
                    <p class="text-muted mb-0">Review and approve staff resource booking requests</p>
                </div>
                <a href="{{ route('resource.index') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i>
                    Back to Resources
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number text-warning">{{ $pendingBookings->count() }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-success">{{ $approvedBookings->count() }}</div>
                <div class="stat-label">Recently Approved</div>
            </div>
            <div class="stat-card">
                <div class="stat-number text-danger">{{ $rejectedBookings->count() }}</div>
                <div class="stat-label">Recently Rejected</div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                    <i class="bi bi-clock-history"></i> Pending ({{ $pendingBookings->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button">
                    <i class="bi bi-check-circle"></i> Approved ({{ $approvedBookings->count() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button">
                    <i class="bi bi-x-circle"></i> Rejected ({{ $rejectedBookings->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="bookingTabContent">
            <!-- Pending Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                @if($pendingBookings->count() > 0)
                    @foreach($pendingBookings as $booking)
                    <div class="booking-card" data-booking-id="{{ $booking->id }}">
                        <div class="booking-header">
                            <div class="booking-title">
                                <h5>{{ $booking->resource_name }}</h5>
                                <div class="booking-meta">
                                    <i class="bi bi-calendar"></i> Requested on {{ $booking->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                            <span class="status-badge status-pending">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-box-seam"></i> Resource Type</span>
                                <span class="detail-value">{{ $booking->resource_type }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-123"></i> Quantity Requested</span>
                                <span class="detail-value text-primary">{{ $booking->quantity_requested }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-person"></i> Requested By</span>
                                <span class="detail-value">{{ $booking->requested_by }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-briefcase"></i> Position</span>
                                <span class="detail-value">{{ $booking->requested_position }}</span>
                            </div>
                            @if($booking->department)
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-building"></i> Department</span>
                                <span class="detail-value">{{ $booking->department }}</span>
                            </div>
                            @endif
                            @if($booking->reason)
                            <div class="detail-item" style="grid-column: 1 / -1;">
                                <span class="detail-label"><i class="bi bi-chat-left-text"></i> Reason</span>
                                <span class="detail-value">{{ $booking->reason }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="booking-actions">
                            <button class="btn btn-approve" onclick="approveBooking({{ $booking->id }})">
                                <i class="bi bi-check-circle"></i> Approve Request
                            </button>
                            <button class="btn btn-reject" onclick="rejectBooking({{ $booking->id }})">
                                <i class="bi bi-x-circle"></i> Reject Request
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h3>No Pending Requests</h3>
                        <p>All booking requests have been processed.</p>
                    </div>
                @endif
            </div>

            <!-- Approved Tab -->
            <div class="tab-pane fade" id="approved" role="tabpanel">
                @if($approvedBookings->count() > 0)
                    @foreach($approvedBookings as $booking)
                    <div class="booking-card approved">
                        <div class="booking-header">
                            <div class="booking-title">
                                <h5>{{ $booking->resource_name }}</h5>
                                <div class="booking-meta">
                                    <i class="bi bi-check-circle"></i> Approved on {{ $booking->approved_at->format('M d, Y h:i A') }}
                                    @if($booking->approved_by)
                                        by {{ $booking->approved_by }}
                                    @endif
                                </div>
                            </div>
                            <span class="status-badge status-approved">
                                <i class="bi bi-check-circle"></i> Approved
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-box-seam"></i> Resource Type</span>
                                <span class="detail-value">{{ $booking->resource_type }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-123"></i> Quantity Approved</span>
                                <span class="detail-value text-success">{{ $booking->quantity_requested }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-person"></i> Requested By</span>
                                <span class="detail-value">{{ $booking->requested_by }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-briefcase"></i> Position</span>
                                <span class="detail-value">{{ $booking->requested_position }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h3>No Approved Requests</h3>
                        <p>No booking requests have been approved yet.</p>
                    </div>
                @endif
            </div>

            <!-- Rejected Tab -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                @if($rejectedBookings->count() > 0)
                    @foreach($rejectedBookings as $booking)
                    <div class="booking-card rejected">
                        <div class="booking-header">
                            <div class="booking-title">
                                <h5>{{ $booking->resource_name }}</h5>
                                <div class="booking-meta">
                                    <i class="bi bi-x-circle"></i> Rejected on {{ $booking->updated_at->format('M d, Y h:i A') }}
                                    @if($booking->approved_by)
                                        by {{ $booking->approved_by }}
                                    @endif
                                </div>
                            </div>
                            <span class="status-badge status-rejected">
                                <i class="bi bi-x-circle"></i> Rejected
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-box-seam"></i> Resource Type</span>
                                <span class="detail-value">{{ $booking->resource_type }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-123"></i> Quantity Requested</span>
                                <span class="detail-value text-danger">{{ $booking->quantity_requested }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-person"></i> Requested By</span>
                                <span class="detail-value">{{ $booking->requested_by }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="bi bi-briefcase"></i> Position</span>
                                <span class="detail-value">{{ $booking->requested_position }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h3>No Rejected Requests</h3>
                        <p>No booking requests have been rejected.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function approveBooking(bookingId) {
            if (!confirm('Are you sure you want to approve this booking request?')) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/resource/approve/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    approved_by: 'Administrator' // You can modify this to get actual admin name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Booking request approved successfully!', 'success');
                    // Remove the card from pending
                    const card = document.querySelector(`[data-booking-id="${bookingId}"]`);
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(-100%)';
                        setTimeout(() => {
                            card.remove();
                            // Reload page to update counts
                            setTimeout(() => window.location.reload(), 1000);
                        }, 300);
                    }
                } else {
                    showAlert(data.message || 'Failed to approve booking request.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while approving the request.', 'danger');
            });
        }

        function rejectBooking(bookingId) {
            if (!confirm('Are you sure you want to reject this booking request?')) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch(`/resource/reject/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    approved_by: 'Administrator' // You can modify this to get actual admin name
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Booking request rejected.', 'warning');
                    // Remove the card from pending
                    const card = document.querySelector(`[data-booking-id="${bookingId}"]`);
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '0';
                        card.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            card.remove();
                            // Reload page to update counts
                            setTimeout(() => window.location.reload(), 1000);
                        }, 300);
                    }
                } else {
                    showAlert(data.message || 'Failed to reject booking request.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while rejecting the request.', 'danger');
            });
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-custom alert-dismissible fade show`;
            alert.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertContainer.appendChild(alert);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
</body>
</html>
