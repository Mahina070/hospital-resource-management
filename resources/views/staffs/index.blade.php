<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Staff List</h2>
            <a href="{{ route('staff.create') }}" class="btn btn-primary">Add New Staff</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Staff ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Department</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($staffs ?? [] as $staff)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staff->first_name }}</td>
                                    <td>{{ $staff->last_name }}</td>
                                    <td>{{ $staff->staff_id }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->role }}</td>
                                    <td>{{ $staff->department }}</td>
                                    <td>
                                        <span class="badge bg-{{ $staff->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $staff->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $staff->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $staff->id }}">
                                                <li>
                                                    <button type="button" class="dropdown-item view-staff-btn" data-staff-id="{{ $staff->id }}">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('staff.edit', $staff->id) }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $staff->id }}">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $staff->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $staff->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $staff->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <strong>{{ $staff->first_name }} {{ $staff->last_name }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <form action="{{ route('staff.delete', $staff->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic View Details Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewModalLabel">
                        <i class="bi bi-person-circle"></i> Staff Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="toggleEditBtn" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button type="button" id="saveStaffBtn" class="btn btn-success d-none">
                        <i class="bi bi-check-circle"></i> Save Changes
                    </button>
                    <button type="button" id="cancelEditBtn" class="btn btn-secondary d-none">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewModal = new bootstrap.Modal(document.getElementById('viewModal'));
            const modalContent = document.getElementById('modalContent');
            const toggleEditBtn = document.getElementById('toggleEditBtn');
            const saveStaffBtn = document.getElementById('saveStaffBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            let currentStaff = null;
            let isEditMode = false;
            let originalContent = '';

            document.querySelectorAll('.view-staff-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const staffId = this.getAttribute('data-staff-id');
                    isEditMode = false;
                    toggleEditBtn.classList.remove('d-none');
                    saveStaffBtn.classList.add('d-none');
                    cancelEditBtn.classList.add('d-none');
                    
                    // Show loading spinner
                    modalContent.innerHTML = `
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `;
                    
                    // Show modal
                    viewModal.show();
                    
                    // Fetch staff data
                    fetch(`/staff/show/${staffId}`)
                        .then(response => response.json())
                        .then(staff => {
                            currentStaff = staff;
                            renderViewMode(staff);
                        })
                        .catch(error => {
                            modalContent.innerHTML = `
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i> Error loading staff details. Please try again.
                                </div>
                            `;
                            console.error('Error:', error);
                        });
                });
            });

            function renderViewMode(staff) {
                // Determine status badge color
                let statusColor = 'secondary';
                if (staff.status === 'active') statusColor = 'success';
                else if (staff.status === 'inactive') statusColor = 'secondary';
                
                // Update modal content
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-person"></i> First Name:</strong>
                            <p class="ms-4">${staff.first_name}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-person"></i> Last Name:</strong>
                            <p class="ms-4">${staff.last_name}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-card-text"></i> Staff ID:</strong>
                            <p class="ms-4">${staff.staff_id}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-envelope"></i> Email:</strong>
                            <p class="ms-4">${staff.email}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-telephone"></i> Contact Number:</strong>
                            <p class="ms-4">${staff.contact_no || 'N/A'}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-briefcase"></i> Role:</strong>
                            <p class="ms-4">${staff.role || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-geo-alt"></i> Address:</strong>
                            <p class="ms-4">${staff.address || 'N/A'}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-phone"></i> Emergency Contact:</strong>
                            <p class="ms-4">${staff.emergency_contact || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-building"></i> Department:</strong>
                            <p class="ms-4">${staff.department || 'N/A'}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-info-circle"></i> Status:</strong>
                            <p class="ms-4">
                                <span class="badge bg-${statusColor}">
                                    ${staff.status}
                                </span>
                            </p>
                        </div>
                    </div>
                `;
                originalContent = modalContent.innerHTML;
            }

            function renderEditMode(staff) {
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_first_name" value="${staff.first_name}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_last_name" value="${staff.last_name}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-card-text"></i> Staff ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_staff_id" value="${staff.staff_id}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" value="${staff.email}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-briefcase"></i> Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_role" value="${staff.role || ''}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-telephone"></i> Contact Number</label>
                            <input type="text" class="form-control" id="edit_contact_no" value="${staff.contact_no || ''}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-geo-alt"></i> Address</label>
                            <input type="text" class="form-control" id="edit_address" value="${staff.address || ''}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-phone"></i> Emergency Contact</label>
                            <input type="text" class="form-control" id="edit_emergency_contact" value="${staff.emergency_contact || ''}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-building"></i> Department</label>
                            <input type="text" class="form-control" id="edit_department" value="${staff.department || ''}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-info-circle"></i> Status</label>
                            <select class="form-select" id="edit_status">
                                <option value="active" ${staff.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${staff.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                    </div>
                `;
            }

            toggleEditBtn.addEventListener('click', function() {
                isEditMode = true;
                renderEditMode(currentStaff);
                toggleEditBtn.classList.add('d-none');
                saveStaffBtn.classList.remove('d-none');
                cancelEditBtn.classList.remove('d-none');
            });

            cancelEditBtn.addEventListener('click', function() {
                isEditMode = false;
                modalContent.innerHTML = originalContent;
                toggleEditBtn.classList.remove('d-none');
                saveStaffBtn.classList.add('d-none');
                cancelEditBtn.classList.add('d-none');
            });

            saveStaffBtn.addEventListener('click', function() {
                const updatedData = {
                    first_name: document.getElementById('edit_first_name').value,
                    last_name: document.getElementById('edit_last_name').value,
                    staff_id: document.getElementById('edit_staff_id').value,
                    email: document.getElementById('edit_email').value,
                    role: document.getElementById('edit_role').value,
                    contact_no: document.getElementById('edit_contact_no').value,
                    address: document.getElementById('edit_address').value,
                    emergency_contact: document.getElementById('edit_emergency_contact').value,
                    department: document.getElementById('edit_department').value,
                    status: document.getElementById('edit_status').value
                };

                // Show loading
                saveStaffBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Saving...';
                saveStaffBtn.disabled = true;

                // Send update request
                fetch(`/staff/update/${currentStaff.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(updatedData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update currentStaff with new data
                        currentStaff = {...currentStaff, ...updatedData};
                        
                        // Switch back to view mode
                        renderViewMode(currentStaff);
                        isEditMode = false;
                        toggleEditBtn.classList.remove('d-none');
                        saveStaffBtn.classList.add('d-none');
                        cancelEditBtn.classList.add('d-none');
                        
                        // Update table row
                        const row = document.querySelector(`button[data-staff-id="${currentStaff.id}"]`).closest('tr');
                        row.querySelector('td:nth-child(2)').textContent = updatedData.first_name;
                        row.querySelector('td:nth-child(3)').textContent = updatedData.last_name;
                        row.querySelector('td:nth-child(4)').textContent = updatedData.staff_id;
                        row.querySelector('td:nth-child(5)').textContent = updatedData.email;
                        row.querySelector('td:nth-child(6)').textContent = updatedData.role;
                        row.querySelector('td:nth-child(7)').textContent = updatedData.department;
                        
                        // Update status badge
                        let statusColor = updatedData.status === 'active' ? 'success' : 'secondary';
                        row.querySelector('td:nth-child(8)').innerHTML = `<span class="badge bg-${statusColor}">${updatedData.status}</span>`;
                        
                        // Show success message
                        const successAlert = document.createElement('div');
                        successAlert.className = 'alert alert-success alert-dismissible fade show';
                        successAlert.innerHTML = `
                            <i class="bi bi-check-circle"></i> Staff updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        modalContent.insertBefore(successAlert, modalContent.firstChild);
                        
                        setTimeout(() => successAlert.remove(), 3000);
                    } else {
                        throw new Error(data.message || 'Update failed');
                    }
                })
                .catch(error => {
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                    errorAlert.innerHTML = `
                        <i class="bi bi-exclamation-triangle"></i> Error updating staff. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    modalContent.insertBefore(errorAlert, modalContent.firstChild);
                    console.error('Error:', error);
                })
                .finally(() => {
                    saveStaffBtn.innerHTML = '<i class="bi bi-check-circle"></i> Save Changes';
                    saveStaffBtn.disabled = false;
                });
            });
        });
    </script>
</body>
</html>