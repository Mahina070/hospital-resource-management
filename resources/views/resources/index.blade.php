<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resource List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Resource List</h2>
            <a href="{{ route('resource.create') }}" class="btn btn-primary">Add New Resource</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Resource ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Total Quantity</th>
                                <th scope="col">Available</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resources ?? [] as $resource)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $resource->resource_id }}</td>
                                    <td>{{ $resource->name }}</td>
                                    <td>{{ $resource->type }}</td>
                                    <td>{{ $resource->quantity_total }}</td>
                                    <td>{{ $resource->quantity_available }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $resource->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $resource->id }}">
                                                <li>
                                                    <button type="button" class="dropdown-item view-resource-btn" data-resource-id="{{ $resource->id }}">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('resource.edit', $resource->id) }}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $resource->id }}">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $resource->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $resource->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $resource->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete resource <strong>{{ $resource->name }}</strong> (ID: {{ $resource->resource_id }})?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                <form action="{{ route('resource.delete', $resource->id) }}" method="POST" style="display: inline;">
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
                        <i class="bi bi-box"></i> Resource Details
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
                    <button type="button" id="saveResourceBtn" class="btn btn-success d-none">
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
            const saveResourceBtn = document.getElementById('saveResourceBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            let currentResource = null;
            let isEditMode = false;
            let originalContent = '';

            document.querySelectorAll('.view-resource-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const resourceId = this.getAttribute('data-resource-id');
                    isEditMode = false;
                    toggleEditBtn.classList.remove('d-none');
                    saveResourceBtn.classList.add('d-none');
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
                    
                    // Fetch resource data
                    fetch(`/resource/show/${resourceId}`)
                        .then(response => response.json())
                        .then(resource => {
                            currentResource = resource;
                            renderViewMode(resource);
                        })
                        .catch(error => {
                            modalContent.innerHTML = `
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i> Error loading resource details. Please try again.
                                </div>
                            `;
                            console.error('Error:', error);
                        });
                });
            });

            function renderViewMode(resource) {
                // Update modal content
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-hash"></i> Resource ID:</strong>
                            <p class="ms-4">${resource.resource_id}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-box"></i> Name:</strong>
                            <p class="ms-4">${resource.name}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-tag"></i> Type:</strong>
                            <p class="ms-4">${resource.type}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-stack"></i> Total Quantity:</strong>
                            <p class="ms-4">${resource.quantity_total}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong><i class="bi bi-check-circle"></i> Available Quantity:</strong>
                            <p class="ms-4">${resource.quantity_available}</p>
                        </div>
                    </div>
                `;
                originalContent = modalContent.innerHTML;
            }

            function renderEditMode(resource) {
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-hash"></i> Resource ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_resource_id" value="${resource.resource_id}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-box"></i> Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" value="${resource.name}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-tag"></i> Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_type" value="${resource.type}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-stack"></i> Total Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_quantity_total" value="${resource.quantity_total}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-check-circle"></i> Available Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_quantity_available" value="${resource.quantity_available}" required>
                        </div>
                    </div>
                `;
            }

            toggleEditBtn.addEventListener('click', function() {
                isEditMode = true;
                renderEditMode(currentResource);
                toggleEditBtn.classList.add('d-none');
                saveResourceBtn.classList.remove('d-none');
                cancelEditBtn.classList.remove('d-none');
            });

            cancelEditBtn.addEventListener('click', function() {
                isEditMode = false;
                modalContent.innerHTML = originalContent;
                toggleEditBtn.classList.remove('d-none');
                saveResourceBtn.classList.add('d-none');
                cancelEditBtn.classList.add('d-none');
            });

            saveResourceBtn.addEventListener('click', function() {
                const updatedData = {
                    resource_id: document.getElementById('edit_resource_id').value,
                    name: document.getElementById('edit_name').value,
                    type: document.getElementById('edit_type').value,
                    quantity_total: document.getElementById('edit_quantity_total').value,
                    quantity_available: document.getElementById('edit_quantity_available').value
                };

                // Show loading
                saveResourceBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Saving...';
                saveResourceBtn.disabled = true;

                // Send update request
                fetch(`/resource/update/${currentResource.id}`, {
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
                        // Update currentResource with new data
                        currentResource = {...currentResource, ...updatedData};
                        
                        // Switch back to view mode
                        renderViewMode(currentResource);
                        isEditMode = false;
                        toggleEditBtn.classList.remove('d-none');
                        saveResourceBtn.classList.add('d-none');
                        cancelEditBtn.classList.add('d-none');
                        
                        // Update table row
                        const row = document.querySelector(`button[data-resource-id="${currentResource.id}"]`).closest('tr');
                        row.querySelector('td:nth-child(2)').textContent = updatedData.resource_id;
                        row.querySelector('td:nth-child(3)').textContent = updatedData.name;
                        row.querySelector('td:nth-child(4)').textContent = updatedData.type;
                        row.querySelector('td:nth-child(5)').textContent = updatedData.quantity_total;
                        row.querySelector('td:nth-child(6)').textContent = updatedData.quantity_available;
                        
                        // Show success message
                        const successAlert = document.createElement('div');
                        successAlert.className = 'alert alert-success alert-dismissible fade show';
                        successAlert.innerHTML = `
                            <i class="bi bi-check-circle"></i> Resource updated successfully!
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
                        <i class="bi bi-exclamation-triangle"></i> Error updating resource. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    modalContent.insertBefore(errorAlert, modalContent.firstChild);
                    console.error('Error:', error);
                })
                .finally(() => {
                    saveResourceBtn.innerHTML = '<i class="bi bi-check-circle"></i> Save Changes';
                    saveResourceBtn.disabled = false;
                });
            });
        });
    </script>
</body>
</html>