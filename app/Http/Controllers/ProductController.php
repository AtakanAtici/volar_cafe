<?php
namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    /**
     * Ürünleri listele.
     */
    public function index()
    {
        $products = Product::with('dealer')->get(); // Ürünleri bayileriyle al
        return view('admin.products.index', compact('products'));
    }

    public function allProducts(Request $request)
    {
        // Bayi filtrelemesi
        $query = Product::query();

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }

        // Ürünler ve bayiler
        $products = $query->with('dealer')->get();
        $dealers = Dealer::all();

        // View'e ürünleri ve bayileri gönder
        return view('admin.product.all', compact('products', 'dealers'));
    }

    public function create()
    {
        $dealers = Dealer::all(); // Bayileri al
        return view('admin.product.create', compact('dealers'));
    }

    /**
     * Yeni ürünü veritabanına kaydet.
     */
    public function store(Request $request)
    {
        // Doğrulama
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'dealer_ids' => 'required|array',
            'dealer_ids.*' => 'exists:dealers,id',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Çoklu fotoğraf
        ]);

        // Kapak fotoğrafını kaydetme
        $coverImagePath = $request->file('cover_image')->store('products', 'public');

        foreach ($request->dealer_ids as $dealer_id) {
            // Ürünü oluştur
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'cover_image' => $coverImagePath,
                'description' => $request->description,
                'dealer_id' => $dealer_id,
            ]);

            // Çoklu fotoğrafları kaydet
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $product->addMedia($photo)->toMediaCollection('images');
                }
            }
        }

        return redirect()->route('products.all')->with('success', 'Ürün başarıyla seçilen bayilere eklendi.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id); // Ürünü bul
        $dealers = Dealer::all(); // Bayiler listesi

        return view('admin.product.edit', compact('product', 'dealers')); // Düzenleme formunu döndür
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        // Validasyon
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'dealer_id' => 'required|exists:dealers,id', // Dealer ID doğrulaması
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Ek fotoğraflar doğrulaması
        ]);
    
        // Ürün bilgilerini güncelle
        $product->update([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'dealer_id' => $validatedData['dealer_id'],
        ]);
    
        // Kapak fotoğrafını güncelle
        if ($request->hasFile('cover_image')) {
            // Sadece kapak fotoğrafını değiştir (Diğer fotoğrafları korur)
            $product->clearMediaCollection('cover'); // Kapak koleksiyonunu temizle
            $product->addMedia($request->file('cover_image'))->toMediaCollection('cover');
        }
    
        // Yeni fotoğrafları ekle
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $product->addMedia($photo)->toMediaCollection('images'); // Ek fotoğrafları "images" koleksiyonuna ekle
            }
        }
    
        return redirect()->route('products.all')->with('success', 'Ürün başarıyla güncellendi.');
    }
    
    public function deleteImage($id)
    {
        $media = Media::findOrFail($id); // Media modeli kullanılmalıdır.
        $media->delete();

        return back()->with('success', 'Fotoğraf başarıyla silindi.');
    }



}
