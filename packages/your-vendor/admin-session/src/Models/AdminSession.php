<?php

namespace YourVendor\AdminSession\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'ip_address',
        'user_agent',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
