<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Resources - Hospital Resource Allocation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .booking-container {
            max-width: 1200px;
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

        .header-section p {
            color: #6c757d;
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .resource-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .resource-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--info-color));
        }

        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .resource-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .resource-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--info-color));
            color: white;
        }

        .resource-title {
            flex: 1;
        }

        .resource-title h5 {
            margin: 0;
            font-weight: 700;
            color: #333;
            font-size: 1.2rem;
        }

        .resource-id {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 3px;
        }

        .resource-info {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        .availability-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .availability-high {
            background: #d1f2eb;
            color: #0f5132;
        }

        .availability-medium {
            background: #fff3cd;
            color: #997404;
        }

        .availability-low {
            background: #f8d7da;
            color: #842029;
        }

        .availability-none {
            background: #e9ecef;
            color: #495057;
        }

        .booking-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .quantity-input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .quantity-input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .quantity-input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .quantity-input-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }

        .btn-book {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-book:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-book i {
            font-size: 1.2rem;
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            background: white;
            border-radius: 15px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
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

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .filter-section select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .filter-section select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1>
                        <i class="bi bi-calendar-check"></i>
                        Request Resources
                    </h1>
                    <p>Submit a booking request for the resources you need - Administrator will review and approve</p>
                </div>
                <a href="{{ route('resource.index') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i>
                    Back to Resources
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="typeFilter" class="form-label fw-bold">
                        <i class="bi bi-funnel"></i> Filter by Type
                    </label>
                    <select id="typeFilter" class="form-select">
                        <option value="">All Types</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="availabilityFilter" class="form-label fw-bold">
                        <i class="bi bi-check-circle"></i> Filter by Availability
                    </label>
                    <select id="availabilityFilter" class="form-select">
                        <option value="">All Availability</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button id="resetFilters" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Resources Grid -->
        <div id="resourcesGrid" class="resources-grid">
            <!-- Resources will be loaded here dynamically -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state" style="display: none;">
            <i class="bi bi-inbox"></i>
            <h3>No Resources Available</h3>
            <p>There are currently no resources available for booking.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let allResources = [];
        let filteredResources = [];

        // Fetch resources when page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchResources();
        });

        function fetchResources() {
            fetch('{{ route("resource.index") }}')
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML to extract resource data
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Extract resources from the table (you might need to adjust based on your actual structure)
                    // For now, we'll use a simpler approach - fetch via API
                    fetchResourcesFromAPI();
                })
                .catch(error => {
                    console.error('Error fetching resources:', error);
                    showAlert('Error loading resources. Please refresh the page.', 'danger');
                });
        }

        // Alternative: Fetch resources from API endpoint
        function fetchResourcesFromAPI() {
            // Since we don't have a dedicated API endpoint, we'll simulate with sample data
            // In production, you should create an API endpoint to return JSON
            
            // For now, let's create sample data structure
            // You should replace this with actual API call: fetch('/api/resources')
            allResources = @json(\App\Models\Resource::all());
            filteredResources = allResources;
            
            // Populate type filter
            populateTypeFilter();
            
            // Display resources
            displayResources(filteredResources);
        }

        function populateTypeFilter() {
            const typeFilter = document.getElementById('typeFilter');
            const types = [...new Set(allResources.map(r => r.type))];
            
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                typeFilter.appendChild(option);
            });
        }

        function displayResources(resources) {
            const grid = document.getElementById('resourcesGrid');
            const emptyState = document.getElementById('emptyState');
            
            if (resources.length === 0) {
                grid.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }
            
            grid.style.display = 'grid';
            emptyState.style.display = 'none';
            grid.innerHTML = '';
            
            resources.forEach(resource => {
                const card = createResourceCard(resource);
                grid.appendChild(card);
            });
        }

        function createResourceCard(resource) {
            const card = document.createElement('div');
            card.className = 'resource-card';
            
            const availabilityPercentage = (resource.quantity_available / resource.quantity_total) * 100;
            let availabilityClass = 'availability-none';
            let availabilityText = 'Unavailable';
            
            if (availabilityPercentage > 50) {
                availabilityClass = 'availability-high';
                availabilityText = 'High Availability';
            } else if (availabilityPercentage > 20) {
                availabilityClass = 'availability-medium';
                availabilityText = 'Medium Availability';
            } else if (availabilityPercentage > 0) {
                availabilityClass = 'availability-low';
                availabilityText = 'Low Availability';
            }
            
            const isAvailable = resource.quantity_available > 0;
            
            card.innerHTML = `
                <div class="resource-header">
                    <div class="resource-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="resource-title">
                        <h5>${resource.name}</h5>
                        <div class="resource-id">ID: ${resource.resource_id}</div>
                    </div>
                </div>
                
                <div class="resource-info">
                    <div class="info-row">
                        <span class="info-label">Type:</span>
                        <span class="info-value">${resource.type}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Quantity:</span>
                        <span class="info-value">${resource.quantity_total}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Available:</span>
                        <span class="info-value text-primary">${resource.quantity_available}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="availability-badge ${availabilityClass}">${availabilityText}</span>
                    </div>
                </div>
                
                <div class="booking-form">
                    <div class="quantity-input-group">
                        <label for="staff_name_${resource.id}">
                            <i class="bi bi-person"></i> Your Name <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="staff_name_${resource.id}" 
                            ${!isAvailable ? 'disabled' : ''}
                            placeholder="Enter your name"
                            required
                        >
                    </div>
                    <div class="quantity-input-group">
                        <label for="staff_position_${resource.id}">
                            <i class="bi bi-briefcase"></i> Position <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="staff_position_${resource.id}" 
                            ${!isAvailable ? 'disabled' : ''}
                            placeholder="e.g., Nurse, Doctor"
                            required
                        >
                    </div>
                    <div class="quantity-input-group">
                        <label for="department_${resource.id}">
                            <i class="bi bi-building"></i> Department
                        </label>
                        <input 
                            type="text" 
                            id="department_${resource.id}" 
                            ${!isAvailable ? 'disabled' : ''}
                            placeholder="Enter department"
                        >
                    </div>
                    <div class="quantity-input-group">
                        <label for="quantity_${resource.id}">
                            <i class="bi bi-123"></i> Quantity Needed <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="quantity_${resource.id}" 
                            min="1" 
                            max="${resource.quantity_available}" 
                            value="1"
                            ${!isAvailable ? 'disabled' : ''}
                            placeholder="Enter quantity"
                            required
                        >
                    </div>
                    <div class="quantity-input-group">
                        <label for="reason_${resource.id}">
                            <i class="bi bi-chat-left-text"></i> Reason for Request
                        </label>
                        <textarea 
                            id="reason_${resource.id}" 
                            rows="3"
                            ${!isAvailable ? 'disabled' : ''}
                            placeholder="Briefly explain why you need this resource"
                            style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; resize: vertical;"
                        ></textarea>
                    </div>
                    <button 
                        class="btn btn-book ${isAvailable ? 'btn-primary' : 'btn-secondary'}" 
                        onclick="submitBookingRequest(${resource.id}, '${resource.name}')"
                        ${!isAvailable ? 'disabled' : ''}
                    >
                        <i class="bi bi-send"></i>
                        ${isAvailable ? 'Submit Request' : 'Unavailable'}
                    </button>
                </div>
            `;
            
            return card;
        }

        function submitBookingRequest(resourceId, resourceName) {
            const quantityInput = document.getElementById(`quantity_${resourceId}`);
            const staffNameInput = document.getElementById(`staff_name_${resourceId}`);
            const staffPositionInput = document.getElementById(`staff_position_${resourceId}`);
            const departmentInput = document.getElementById(`department_${resourceId}`);
            const reasonInput = document.getElementById(`reason_${resourceId}`);
            
            const quantity = parseInt(quantityInput.value);
            const staffName = staffNameInput.value.trim();
            const staffPosition = staffPositionInput.value.trim();
            const department = departmentInput.value.trim();
            const reason = reasonInput.value.trim();
            
            // Validation
            if (!staffName) {
                showAlert('Please enter your name.', 'warning');
                staffNameInput.focus();
                return;
            }
            
            if (!staffPosition) {
                showAlert('Please enter your position.', 'warning');
                staffPositionInput.focus();
                return;
            }
            
            if (!quantity || quantity <= 0) {
                showAlert('Please enter a valid quantity.', 'warning');
                quantityInput.focus();
                return;
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            // Make booking request
            fetch(`/resource/book/${resourceId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: quantity,
                    requested_by: staffName,
                    requested_position: staffPosition,
                    department: department,
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(`Request submitted successfully! Your request for ${quantity} unit(s) of ${resourceName} is pending administrator approval.`, 'success');
                    // Clear the form
                    staffNameInput.value = '';
                    staffPositionInput.value = '';
                    departmentInput.value = '';
                    quantityInput.value = '1';
                    reasonInput.value = '';
                } else {
                    showAlert(data.message || 'Request submission failed. Please try again.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error submitting request:', error);
                showAlert('An error occurred while submitting your request. Please try again.', 'danger');
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

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', applyFilters);
        document.getElementById('availabilityFilter').addEventListener('change', applyFilters);
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        function applyFilters() {
            const typeFilter = document.getElementById('typeFilter').value;
            const availabilityFilter = document.getElementById('availabilityFilter').value;
            
            filteredResources = allResources.filter(resource => {
                let matchesType = !typeFilter || resource.type === typeFilter;
                let matchesAvailability = true;
                
                if (availabilityFilter === 'available') {
                    matchesAvailability = resource.quantity_available > 0;
                } else if (availabilityFilter === 'unavailable') {
                    matchesAvailability = resource.quantity_available === 0;
                }
                
                return matchesType && matchesAvailability;
            });
            
            displayResources(filteredResources);
        }

        function resetFilters() {
            document.getElementById('typeFilter').value = '';
            document.getElementById('availabilityFilter').value = '';
            filteredResources = allResources;
            displayResources(filteredResources);
        }
    </script>
</body>
</html>
