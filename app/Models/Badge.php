<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    use HasFactory;
    protected $table = 'badges';
    protected $primaryKey = 'Id';
    
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = ['Name', 'Color', 'IsActive'];


    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'badge_customer')
                    ->withTimestamps();
    }
}