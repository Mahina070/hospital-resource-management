<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resource</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Resource</h2>
            <a href="{{ route('resource.index') }}" class="btn btn-secondary">Back to Resource List</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted small mb-4"><span class="text-danger">*</span> means required</p>
                <form action="{{ route('resource.update', $resource->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="resource_id" class="form-label">Resource ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="resource_id" name="resource_id" value="{{ old('resource_id', $resource->resource_id) }}" required>
                            @error('resource_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $resource->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $resource->type) }}" required>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantity_total" class="form-label">Total Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity_total" name="quantity_total" value="{{ old('quantity_total', $resource->quantity_total) }}" required>
                            @error('quantity_total')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('resource.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>