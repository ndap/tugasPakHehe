<?php
namespace App\Http\Controllers;


use App\Models\Product; 
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index() : View
    {
        $products = Product::latest()->paginate(10); // Pagination 10 items
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create(): View
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        $image = $this->uploadImage($request);

        Product::create([
            'image'         => $image,
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    // Menampilkan detail produk
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    // Menampilkan form edit produk
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Mengupdate produk
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:10000',
            'title'         => 'required|min:3|max:20',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $this->uploadImage($request);
            Storage::delete('public/products/' . $product->image); // Hapus gambar lama
            $product->update(['image' => $image]);
        }

        $product->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    // Menghapus produk
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        Storage::delete('public/products/' . $product->image);

        $product->delete();

        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    // Fungsi untuk menghandle upload gambar
    private function uploadImage(Request $request): string
    {
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());
        return $image->hashName();
    }
    // Metode untuk menangani pembelian produk
public function purchase(Request $request, string $id): RedirectResponse
{
    // Temukan produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Validasi jumlah pembelian
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $quantity = $request->input('quantity');

    // Cek apakah stok cukup
    if ($product->stock < $quantity) {
        return back()->with('error', 'Stok tidak mencukupi.');
    }

    // Kurangi stok produk
    $product->stock -= $quantity;
    $product->save();

    // Logika tambahan (misalnya simpan transaksi, pembayaran, dll)

    return redirect()->route('dashboard')->with('success', 'Pembelian berhasil!');
}

}
