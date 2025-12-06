<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student List</title>
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
                                        <span class="badge bg-{{ $staff->status == 'Active' ? 'success' : 'secondary' }}">
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
                                                    <button type="button" class="dropdown-item view-student-btn" data-student-id="{{ $staff->id }}">
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
                        <i class="bi bi-person-circle"></i> Student Details
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
                    <button type="button" id="saveStudentBtn" class="btn btn-success d-none">
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
            const saveStudentBtn = document.getElementById('saveStudentBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            let currentStudent = null;
            let isEditMode = false;
            let originalContent = '';

            document.querySelectorAll('.view-student-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-student-id');
                    isEditMode = false;
                    toggleEditBtn.classList.remove('d-none');
                    saveStudentBtn.classList.add('d-none');
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
                    
                    // Fetch student data
                    fetch(`/student/show/${studentId}`)
                        .then(response => response.json())
                        .then(student => {
                            currentStudent = student;
                            renderViewMode(student);
                        })
                        .catch(error => {
                            modalContent.innerHTML = `
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i> Error loading student details. Please try again.
                                </div>
                            `;
                            console.error('Error:', error);
                        });
                });
            });

            function renderViewMode(student) {
                // Format date
                let formattedDate = 'N/A';
                if (student.date_of_birth) {
                    const date = new Date(student.date_of_birth);
                    formattedDate = date.toLocaleDateString('en-US', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                }
                
                // Determine status badge color
                let statusColor = 'secondary';
                if (student.status === 'Active') statusColor = 'success';
                else if (student.status === 'Graduated') statusColor = 'info';
                
                // Update modal content
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-person"></i> First Name:</strong>
                            <p class="ms-4">${student.first_name}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-person"></i> Last Name:</strong>
                            <p class="ms-4">${student.last_name}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-card-text"></i> Student ID:</strong>
                            <p class="ms-4">${student.student_id}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-envelope"></i> Email:</strong>
                            <p class="ms-4">${student.email}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-telephone"></i> Contact Number:</strong>
                            <p class="ms-4">${student.contact_no || 'N/A'}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-calendar"></i> Date of Birth:</strong>
                            <p class="ms-4">${formattedDate}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong><i class="bi bi-geo-alt"></i> Address:</strong>
                            <p class="ms-4">${student.address || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <strong><i class="bi bi-building"></i> Department:</strong>
                            <p class="ms-4">${student.department || 'N/A'}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="bi bi-calendar-event"></i> Enrollment Year:</strong>
                            <p class="ms-4">${student.enrollment_year || 'N/A'}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong><i class="bi bi-trophy"></i> CGPA:</strong>
                            <p class="ms-4">${student.cgpa || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong><i class="bi bi-info-circle"></i> Status:</strong>
                            <p class="ms-4">
                                <span class="badge bg-${statusColor}">
                                    ${student.status}
                                </span>
                            </p>
                        </div>
                    </div>
                `;
                originalContent = modalContent.innerHTML;
            }

            function renderEditMode(student) {
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_first_name" value="${student.first_name}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_last_name" value="${student.last_name}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-card-text"></i> Student ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_student_id" value="${student.student_id}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="edit_email" value="${student.email}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-telephone"></i> Contact Number</label>
                            <input type="text" class="form-control" id="edit_contact_no" value="${student.contact_no || ''}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-calendar"></i> Date of Birth</label>
                            <input type="date" class="form-control" id="edit_date_of_birth" value="${student.date_of_birth || ''}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="bi bi-geo-alt"></i> Address</label>
                            <input type="text" class="form-control" id="edit_address" value="${student.address || ''}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-building"></i> Department</label>
                            <input type="text" class="form-control" id="edit_department" value="${student.department || ''}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-calendar-event"></i> Enrollment Year</label>
                            <input type="number" class="form-control" id="edit_enrollment_year" value="${student.enrollment_year || ''}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="bi bi-trophy"></i> CGPA</label>
                            <input type="number" step="0.01" class="form-control" id="edit_cgpa" value="${student.cgpa || ''}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="bi bi-info-circle"></i> Status</label>
                            <select class="form-select" id="edit_status">
                                <option value="Active" ${student.status === 'Active' ? 'selected' : ''}>Active</option>
                                <option value="Inactive" ${student.status === 'Inactive' ? 'selected' : ''}>Inactive</option>
                                <option value="Graduated" ${student.status === 'Graduated' ? 'selected' : ''}>Graduated</option>
                            </select>
                        </div>
                    </div>
                `;
            }

            toggleEditBtn.addEventListener('click', function() {
                isEditMode = true;
                renderEditMode(currentStudent);
                toggleEditBtn.classList.add('d-none');
                saveStudentBtn.classList.remove('d-none');
                cancelEditBtn.classList.remove('d-none');
            });

            cancelEditBtn.addEventListener('click', function() {
                isEditMode = false;
                modalContent.innerHTML = originalContent;
                toggleEditBtn.classList.remove('d-none');
                saveStudentBtn.classList.add('d-none');
                cancelEditBtn.classList.add('d-none');
            });

            saveStudentBtn.addEventListener('click', function() {
                const updatedData = {
                    first_name: document.getElementById('edit_first_name').value,
                    last_name: document.getElementById('edit_last_name').value,
                    student_id: document.getElementById('edit_student_id').value,
                    email: document.getElementById('edit_email').value,
                    contact_no: document.getElementById('edit_contact_no').value,
                    date_of_birth: document.getElementById('edit_date_of_birth').value,
                    address: document.getElementById('edit_address').value,
                    department: document.getElementById('edit_department').value,
                    enrollment_year: document.getElementById('edit_enrollment_year').value,
                    cgpa: document.getElementById('edit_cgpa').value,
                    status: document.getElementById('edit_status').value
                };

                // Show loading
                saveStudentBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Saving...';
                saveStudentBtn.disabled = true;

                // Send update request
                fetch(`/student/update/${currentStudent.id}`, {
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
                        // Update currentStudent with new data
                        currentStudent = {...currentStudent, ...updatedData};
                        
                        // Switch back to view mode
                        renderViewMode(currentStudent);
                        isEditMode = false;
                        toggleEditBtn.classList.remove('d-none');
                        saveStudentBtn.classList.add('d-none');
                        cancelEditBtn.classList.add('d-none');
                        
                        // Update table row
                        const row = document.querySelector(`button[data-student-id="${currentStudent.id}"]`).closest('tr');
                        row.querySelector('td:nth-child(2)').textContent = updatedData.first_name;
                        row.querySelector('td:nth-child(3)').textContent = updatedData.last_name;
                        row.querySelector('td:nth-child(4)').textContent = updatedData.student_id;
                        row.querySelector('td:nth-child(5)').textContent = updatedData.email;
                        
                        // Update status badge
                        let statusColor = updatedData.status === 'Active' ? 'success' : (updatedData.status === 'Graduated' ? 'info' : 'secondary');
                        row.querySelector('td:nth-child(6)').innerHTML = `<span class="badge bg-${statusColor}">${updatedData.status}</span>`;
                        
                        // Show success message
                        const successAlert = document.createElement('div');
                        successAlert.className = 'alert alert-success alert-dismissible fade show';
                        successAlert.innerHTML = `
                            <i class="bi bi-check-circle"></i> Student updated successfully!
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
                        <i class="bi bi-exclamation-triangle"></i> Error updating student. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    modalContent.insertBefore(errorAlert, modalContent.firstChild);
                    console.error('Error:', error);
                })
                .finally(() => {
                    saveStudentBtn.innerHTML = '<i class="bi bi-check-circle"></i> Save Changes';
                    saveStudentBtn.disabled = false;
                });
            });
        });
    </script>
</body>
</html>