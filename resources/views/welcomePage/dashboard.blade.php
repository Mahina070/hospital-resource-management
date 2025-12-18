<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Resource Allocation & Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --staff-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --resource-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-color: #28a745;
            --warning-color: #ffc107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            color: white;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 1.3rem;
            opacity: 0.95;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .stat-icon.resources {
            background: var(--resource-gradient);
        }

        .stat-icon.bookings {
            background: var(--staff-gradient);
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }

        .stat-content p {
            color: #6c757d;
            margin: 0;
            font-size: 0.95rem;
        }

        .main-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .module-card {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .module-header {
            padding: 30px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .module-header:hover {
            filter: brightness(1.1);
        }

        .module-header.staff {
            background: var(--staff-gradient);
        }

        .module-header.resource {
            background: var(--resource-gradient);
        }

        .module-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .module-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .module-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .module-title p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .expand-icon {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .expand-icon.rotated {
            transform: rotate(180deg);
        }

        .module-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .module-content.active {
            max-height: 1000px;
        }

        .module-buttons {
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            padding: 18px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .action-btn i {
            font-size: 1.3rem;
        }

        .btn-staff-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-staff-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
        }

        .btn-resource-primary {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
        }

        .btn-resource-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .btn-resource-warning {
            background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%);
        }

        .btn-resource-info {
            background: linear-gradient(135deg, #3f51b5 0%, #5a55ae 100%);
        }

        .btn-resource-danger {
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 1rem;
            }

            .main-buttons {
                grid-template-columns: 1fr;
            }

            .module-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="header">
            <h1><i class="bi bi-hospital"></i> Hospital Resource Allocation & Tracking System</h1>
            <p>Manage staff and resources efficiently with our comprehensive management system</p>
        </div>

        <!-- Statistics -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon resources">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalResources }}</h3>
                    <p>Total Resources</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bookings">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalBookings }}</h3>
                    <p>Total Bookings</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $pendingBookings }}</h3>
                    <p>Pending Requests</p>
                </div>
            </div>
        </div>

        <!-- Alert Button -->
        <a href="{{ route('resource.alerts') }}" class="alert-banner" style="display: block; background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%); color: white; padding: 20px 30px; border-radius: 15px; text-decoration: none; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(255, 107, 107, 0.3); transition: all 0.3s ease;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-weight: 700; font-size: 1.5rem;">Resource Shortage Alerts</h3>
                        <p style="margin: 5px 0 0 0; opacity: 0.95;">View resources with availability below 10 units</p>
                    </div>
                </div>
                <div style="font-size: 1.5rem;">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </div>
            </div>
        </a>

        <!-- Main Modules -->
        <div class="main-buttons">
            <!-- Staff Module -->
            <div class="module-card">
                <div class="module-header staff" onclick="toggleModule('staff')">
                    <div class="module-header-content">
                        <div class="module-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="module-title">
                            <h2>Staff Management</h2>
                            <p>Manage hospital staff members</p>
                        </div>
                    </div>
                    <div class="expand-icon" id="staffIcon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="module-content" id="staffContent">
                    <div class="module-buttons">
                        <a href="{{ route('staff.index') }}" class="action-btn btn-staff-primary">
                            <i class="bi bi-list-ul"></i>
                            Staff Index
                        </a>
                        <a href="{{ route('staff.create') }}" class="action-btn btn-staff-success">
                            <i class="bi bi-person-plus"></i>
                            Create Staff
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resources Module -->
            <div class="module-card">
                <div class="module-header resource" onclick="toggleModule('resource')">
                    <div class="module-header-content">
                        <div class="module-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <div class="module-title">
                            <h2>Resource Management</h2>
                            <p>Manage hospital resources & bookings</p>
                        </div>
                    </div>
                    <div class="expand-icon" id="resourceIcon">
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>
                <div class="module-content" id="resourceContent">
                    <div class="module-buttons">
                        <a href="{{ route('resource.index') }}" class="action-btn btn-resource-primary">
                            <i class="bi bi-grid"></i>
                            Resource Index
                        </a>
                        <a href="{{ route('resource.create') }}" class="action-btn btn-resource-success">
                            <i class="bi bi-plus-circle"></i>
                            Create Resource
                        </a>
                        <a href="{{ route('resource.book.page') }}" class="action-btn btn-resource-warning">
                            <i class="bi bi-calendar-check"></i>
                            Book Resource
                        </a>
                        <a href="{{ route('resource.approve.page') }}" class="action-btn btn-resource-info">
                            <i class="bi bi-clipboard-check"></i>
                            Approve Resource
                        </a>
                        <a href="{{ route('resource.report') }}" class="action-btn btn-resource-danger">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                            Resource Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function toggleModule(module) {
            const content = document.getElementById(`${module}Content`);
            const icon = document.getElementById(`${module}Icon`);
            
            // Toggle active class
            content.classList.toggle('active');
            icon.classList.toggle('rotated');
            
            // Close other module if it's open
            const otherModule = module === 'staff' ? 'resource' : 'staff';
            const otherContent = document.getElementById(`${otherModule}Content`);
            const otherIcon = document.getElementById(`${otherModule}Icon`);
            
            if (otherContent.classList.contains('active')) {
                otherContent.classList.remove('active');
                otherIcon.classList.remove('rotated');
            }
        }
    </script>
</body>
</html>
