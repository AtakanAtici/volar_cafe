<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'description',
        'status',
        'drink_id',
    ];

    // Siparişi veren kullanıcı
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    // Durumlar listesi
    public static function statusList()
{
    return ['bekliyor', 'onaylandı', 'hazır', 'teslim edildi'];
}

}
