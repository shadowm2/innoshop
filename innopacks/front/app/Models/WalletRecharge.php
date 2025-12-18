<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRecharge extends Model
{
    protected $table = 'wallet_recharges';
    protected $fillable = [
        'customer_id', 'amount', 'status', 'gateway', 'authority', 'ref_id', 'paid_at', 'error', 'meta',
    ];
    protected $casts = [
        'amount' => 'float',
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    // روابط
    public function customer() { return $this->belongsTo(Customer::class, 'customer_id'); }
}
