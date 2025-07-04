<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $table = 'Appointments';
    protected $primaryKey = 'Id';

    public function service(): BelongsTo
    {
        return $this->belongsTo(CustomerService::class, 'ServiceId', 'Id');
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'CustomerId', 'Id');
    }
    
}