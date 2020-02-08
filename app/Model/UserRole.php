<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
