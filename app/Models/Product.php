<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Toplu atama için izin verilen alanlar.
     *
     * @var array
     */
    protected $fillable = ['name', 'price', 'cover_image', 'description', 'dealer_id'];

    /**
     * Bayi ile ilişki
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
    /**
     * Medya koleksiyonlarını kaydet
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile(); // Kapak fotoğrafı için özel koleksiyon
        $this->addMediaCollection('images'); // Ek fotoğraflar için koleksiyon
    }
}
