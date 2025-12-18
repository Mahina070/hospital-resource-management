<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Booking;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::orderBy('resource_id', 'asc')->get();
        return view('resources.index', compact('resources'));
    }

    public function create()
    {
        return view('resources.create');
    }

    public function show($resource_id)
    {
        $resource = Resource::find($resource_id);
        return response()->json($resource);
    }

    public function store(Request $request)
    {
        $resource = new Resource();
        $resource->resource_id = $request->input('resource_id');
        $resource->name = $request->input('name');
        $resource->type = $request->input('type');
        $resource->quantity_total = $request->input('quantity_total');
        $resource->quantity_available = $request->input('quantity_total'); // Auto-set to total
        $resource->save();

        return redirect()->route('resource.index');
    }

    public function edit($resource_id)
    {
        $resource = Resource::find($resource_id);
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, $resource_id)
    {
        $resource = Resource::find($resource_id);
        
        // Check if request is JSON (AJAX)
        if ($request->wantsJson() || $request->expectsJson()) {
            $resource->resource_id = $request->input('resource_id');
            $resource->name = $request->input('name');
            $resource->type = $request->input('type');
            $resource->quantity_total = $request->input('quantity_total');
            // Keep existing quantity_available (managed by allocation process)
            $resource->save();
            
            return response()->json(['success' => true, 'message' => 'Resource updated successfully']);
        }
        
        // Regular form submission
        $resource->resource_id = $request->input('resource_id');
        $resource->name = $request->input('name');
        $resource->type = $request->input('type');
        $resource->quantity_total = $request->input('quantity_total');
        // Keep existing quantity_available (managed by allocation process)
        $resource->save();
        return redirect()->route('resource.index');
    }

    public function delete($resource_id)
    {
        $resource = Resource::find($resource_id);
        $resource->delete();

        return redirect()->route('resource.index');
    }

    // Search and Filter functionality
    public function searchFilter(Request $request)
    {
        $searchTerm = $request->input('search');
        
        if ($searchTerm) {
            $resources = Resource::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('type', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('resource_id', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $resources = Resource::orderBy('name', 'asc')->get();
        }
        
        return view('resources.index', compact('resources', 'searchTerm'));
    }

    // Display available resources in ascending order
    public function availableAscending()
    {
        $resources = Resource::orderBy('quantity_available', 'asc')->get();
        return view('resources.index', compact('resources'));
    }

    // Display available resources in descending order
    public function availableDescending()
    {
        $resources = Resource::orderBy('quantity_available', 'desc')->get();
        return view('resources.index', compact('resources'));
    }

    // Staff can submit booking requests
    public function bookResource(Request $request, $id)
    {
        $resource = Resource::find($id);
        
        if (!$resource) {
            return response()->json(['success' => false, 'message' => 'Resource not found'], 404);
        }
        
        $quantityRequested = $request->input('quantity');
        $requestedBy = $request->input('requested_by', 'Unknown Staff');
        $requestedPosition = $request->input('requested_position', 'Staff');
        $department = $request->input('department', '');
        $reason = $request->input('reason', '');
        
        if (!$quantityRequested || $quantityRequested <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid quantity'], 400);
        }
        
        if ($resource->quantity_available < $quantityRequested) {
            return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available resources'], 400);
        }
        
        // Create a booking request (pending approval)
        $booking = Booking::create([
            'resource_id' => $resource->id,
            'resource_name' => $resource->name,
            'resource_type' => $resource->type,
            'quantity_requested' => $quantityRequested,
            'requested_by' => $requestedBy,
            'requested_position' => $requestedPosition,
            'department' => $department,
            'reason' => $reason,
            'status' => 'pending',
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Booking request submitted successfully. Awaiting administrator approval.',
            'booking_id' => $booking->id
        ]);
    }

    // Admin can view all booking requests
    public function approveBookings()
    {
        $pendingBookings = Booking::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $approvedBookings = Booking::where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(20)
            ->get();
            
        $rejectedBookings = Booking::where('status', 'rejected')
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();
            
        return view('resources.approve', compact('pendingBookings', 'approvedBookings', 'rejectedBookings'));
    }
    
    // Admin approves a booking request
    public function approveBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }
        
        if ($booking->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Booking has already been processed'], 400);
        }
        
        $resource = Resource::find($booking->resource_id);
        
        if (!$resource) {
            return response()->json(['success' => false, 'message' => 'Resource not found'], 404);
        }
        
        // Check if sufficient quantity is available
        if ($resource->quantity_available < $booking->quantity_requested) {
            return response()->json(['success' => false, 'message' => 'Insufficient available resources'], 400);
        }
        
        // Deduct from available quantity
        $resource->quantity_available -= $booking->quantity_requested;
        $resource->save();
        
        // Update booking status
        $booking->status = 'approved';
        $booking->approved_at = now();
        $booking->approved_by = $request->input('approved_by', 'Administrator');
        $booking->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Booking request approved successfully',
            'new_available' => $resource->quantity_available
        ]);
    }
    
    // Admin rejects a booking request
    public function rejectBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }
        
        if ($booking->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Booking has already been processed'], 400);
        }
        
        // Update booking status
        $booking->status = 'rejected';
        $booking->approved_at = now();
        $booking->approved_by = $request->input('approved_by', 'Administrator');
        $booking->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Booking request rejected'
        ]);
    }

    // Generate report of all bookings
    public function generateReport()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('resources.report', compact('bookings'));
    }

    // Dashboard view
    public function dashboard()
    {
        $totalResources = Resource::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        return view('welcomePage.dashboard', compact('totalResources', 'totalBookings', 'pendingBookings'));
    }

    // Resource shortage alerts
    public function resourceAlerts()
    {
        $lowStockResources = Resource::where('quantity_available', '<', 10)->orderBy('quantity_available', 'asc')->get();
        return view('resources.alerts', compact('lowStockResources'));
    }
}