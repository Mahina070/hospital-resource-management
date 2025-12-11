<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

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
        $resource->quantity_available = $request->input('quantity_available');
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
            $resource->quantity_available = $request->input('quantity_available');
            $resource->save();
            
            return response()->json(['success' => true, 'message' => 'Resource updated successfully']);
        }
        
        // Regular form submission
        $resource->resource_id = $request->input('resource_id');
        $resource->name = $request->input('name');
        $resource->type = $request->input('type');
        $resource->quantity_total = $request->input('quantity_total');
        $resource->quantity_available = $request->input('quantity_available');
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
}