<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Staff</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.btn-vertical { display: flex; flex-direction: column; gap: 2rem; max-width: 180px; max-height: 300px; }
		.btn-vertical .btn { width: 100%; height: 50px;}
	</style>
</head>
<body>
	<div class="container mt-5">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h2>Manage Staff</h2>
		</div>

		<div class="card shadow-sm">
			<div class="card-body">
				<div class="mb-3 btn-vertical mx-auto">
					<a href="{{ route('staff.index') }}" class="btn btn-primary">View Staff</a>
					<a href="{{ route('staff.create') }}" class="btn btn-success">Add Staff</a>
					<a href="#" class="btn btn-warning disabled" role="button" aria-disabled="true">Edit Staff</a>
					<button type="button" class="btn btn-danger" disabled>Delete Staff</button>
				</div>

				<p class="text-muted small">Edit/Delete actions require selecting a staff record — integrate selection logic or supply an ID in the route.</p>
			</div>
		</div>
	</div>
</body>
</html>
