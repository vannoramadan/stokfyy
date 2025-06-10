<?php

// app/Models/StockTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransaction extends Model
{
    protected $fillable = [
        'product_id', 'type', 'quantity', 'note', 'transaction_date', 'user_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

}

