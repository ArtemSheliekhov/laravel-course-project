<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'TimeSlots';
    protected $primaryKey = 'Id';

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'TimeSlotId');
    }
}