<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'resource_bookings';

    protected $fillable = [
        'resource_id',
        'resource_name',
        'resource_type',
        'quantity_requested',
        'requested_by',
        'requested_position',
        'department',
        'reason',
        'status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Relationship with Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
