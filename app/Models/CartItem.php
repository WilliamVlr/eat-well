<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional tapi sangat direkomendasikan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    // public $incrementing = false; // Disable auto-incrementing for composite primary key
    // protected $primaryKey = ['cartId', 'packageId'];
    // protected $keyType = 'string'; // Memberitahu Eloquent bahwa primary key bukanlah integer tunggal

    protected $fillable = [
        'cartId',
        'packageId',
        'breakfastQty',
        'lunchQty',
        'dinnerQty',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cartId', 'cartId');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'packageId', 'packageId');
    }

    protected static function booted()
    {
        // Event ini akan dipicu SETELAH sebuah CartItem berhasil dihapus
        static::deleted(function (CartItem $cartItem) {
            Log::info('CartItem deleted event triggered for cartId: ' . $cartItem->cartId . ' packageId: ' . $cartItem->packageId);
            // Dapatkan Cart yang terkait dengan CartItem yang baru saja dihapus
            $cart = $cartItem->cart; // Ini akan memuat relasi cart

            // Periksa apakah Cart ini masih ada (belum dihapus oleh cascade dari user/vendor)
            // dan apakah Cart ini tidak memiliki CartItem lagi. Jika tidak ada CartItem tersisa untuk Cart ini, hapus Cartnya
            // if ($cart && $cart->cartItems()->count() === 0) {
            //     $cart->delete();
            //     Log::info('Cart ' . $cart->cartId . ' deleted because it has no more items.');
            // }

            if ($cart) {
                // Memaksa refresh relasi cartItems pada objek $cart ini
                // Ini PENTING untuk memastikan hitungan item yang tersisa adalah yang paling baru dari DB
                $cart->load('cartItems');
                $remainingItemsCount = $cart->cartItems->count(); // Menghitung item setelah relasi direload

                Log::info('Cart ' . $cart->cartId . ' has ' . $remainingItemsCount . ' remaining items AFTER CartItem DELETE event.');

                if ($remainingItemsCount === 0) { // <--- KONDISI INI
                    $cart->delete(); // <--- DAN EKSEKUSI INI
                    Log::info('MAIN CART ' . $cart->cartId . ' DELETED SUCCESSFULLY by CartItem event.');
                } else {
                    Log::info('MAIN CART ' . $cart->cartId . ' NOT deleted, still has ' . $remainingItemsCount . ' items.');
                }
            } else {
                Log::info('Related Cart object for CartItem ' . $cartItem->id . ' was null (maybe already deleted).');
            }
            Log::info('--- CartItem deleted event finished ---');
        });
    }
}
