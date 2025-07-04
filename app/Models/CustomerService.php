<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerService extends Model
{
    use HasFactory;

    protected $table = 'CustomerServices';
    protected $primaryKey = 'Id';
    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'ServiceId', 'Id');
    }

    protected $fillable = [
        'Name', 'Description', 'Price', 'Duration', 'IsActive', 'UserId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
}
