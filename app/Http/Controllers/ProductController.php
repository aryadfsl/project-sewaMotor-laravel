<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products (admin)
    public function index()
    {
        $products = Product::with('categories')->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('admin', compact('products', 'categories'));
    }

    // Show create form
    public function create()
    {
        $products = Product::with('categories')->get();
        $categories = Category::all();
        return view('admin', compact('products', 'categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 'brand' => 'required|in:Yamaha,Honda,Suzuki,Kawasaki,Aston Martin,Harley Davidson',
            'categories' => 'nullable|array', // masih support kategori
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Simpan data produk dengan brand
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'kategori' => $request->kategori,
        ]);

        // Simpan relasi categories jika ada
        if ($request->has('categories') && $request->categories) {
            foreach ($request->categories as $catId) {
                CategoryProduct::create([
                    'product_id' => $product->id,
                    'category_id' => $catId,
                ]);
            }
        }

        return redirect()->route('admin')->with('success', 'Produk motor berhasil ditambahkan!');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        $categories = Category::all();
        $selected = $product->categories->pluck('id')->toArray();
        $products = Product::with('categories')->get();
        return view('admin', compact('product', 'categories', 'selected', 'products'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 'brand' => 'required|in:Yamaha,Honda,Suzuki,Kawasaki,Aston Martin,Harley Davidson',
            'categories' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Update data produk
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->kategori = $request->kategori;
        $product->save();

        // Sync categories (update relasi)
        CategoryProduct::where('product_id', $id)->delete();
        if ($request->has('categories') && $request->categories) {
            foreach ($request->categories as $catId) {
                CategoryProduct::create([
                    'product_id' => $id,
                    'category_id' => $catId,
                ]);
            }
        }

        return redirect()->route('admin')->with('success', 'Produk motor berhasil diupdate!');
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Hapus relasi categories
        CategoryProduct::where('product_id', $id)->delete();
        
        // Hapus produk
        $product->delete();
        
        return redirect()->route('admin')->with('success', 'Produk motor berhasil dihapus!');
    }
}