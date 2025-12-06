<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
    protected $table = 'staffs';

    // Generate the next staff ID in the format "STF001", "STF002", etc.
    public static function generateStaffId()
    {
        $lastStaff = self::orderBy('id', 'desc')->first();

        if (!$lastStaff) {
            return 'STF001';
        }

        // Extract the number from the last staff_id (e.g., "STF001" -> 1)
        $lastNumber = (int) substr($lastStaff->staff_id, 2);
        $newNumber = $lastNumber + 1;

        return 'STF' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}