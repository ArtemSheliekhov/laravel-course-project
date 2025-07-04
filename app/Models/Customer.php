<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Customer extends Model
{
    use HasFactory;
    const CREATED_AT = "CreatedAt";
    const UPDATED_AT = "UpdatedAt";
    protected $table = "Customers";
    protected $primaryKey = "Id";

     protected $fillable = [
        'Name',
        'Email',
        'Phone',
        'IsActive',
        'UserId'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'badge_customer')
                    ->withTimestamps();
    }

}