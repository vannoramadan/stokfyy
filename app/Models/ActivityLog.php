<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ActivityLog extends Model
{
    protected $fillable = [
        'activity',
        'type',
        'user_id',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMasuk($query)
    {
        return $query->where('type', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('type', 'keluar');
    }
}
