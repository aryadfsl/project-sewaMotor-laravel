<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // --- AUTH ---
    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
        session(['user' => $user->name]);
        return redirect()->route('landing');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $user = User::where('name', $credentials['username'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            session(['user' => $user->name]);
            if ($user->role === 'admin') {
                return redirect()->route('admin');
            } else {
                return redirect()->route('landing');
            }
        }
        return back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // --- CART ---
    public function cartIndex(Request $request)
    {
        $cart = session()->get('cart', []);
        $products = \App\Models\Product::whereIn('id', array_keys($cart))->get();
        // Load wishlist products
        $wishlistIds = session()->get('wishlist', []);
        $wishlistProducts = collect();
        if (!empty($wishlistIds)) {
            $wishlistProducts = \App\Models\Product::whereIn('id', $wishlistIds)->get();
        }
        return view('cart', compact('products', 'cart', 'wishlistProducts'));
    }

    public function cartAdd(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1,
            ];
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function cartRemove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function cartClear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang dikosongkan!');
    }

    // --- WISHLIST ---
    public function wishlistAdd($id)
    {
        $wishlist = session()->get('wishlist', []);
        if (!in_array($id, $wishlist)) {
            $wishlist[] = $id;
            session(['wishlist' => $wishlist]);
            // Kurangi stok produk
            $product = \App\Models\Product::find($id);
            if ($product && $product->stock > 0) {
                $product->stock -= 1;
                $product->save();
            }
        }
        $productName = \App\Models\Product::find($id)?->name ?? 'Produk';
        return redirect()->route('landing')->with('success', $productName . ' ditambahkan ke Wishlist');
    }

    public function wishlistRemove(Request $request, $id)
    {
        $wishlist = session()->get('wishlist', []);
        if (($key = array_search($id, $wishlist)) !== false) {
            unset($wishlist[$key]);
            $wishlist = array_values($wishlist);
            session(['wishlist' => $wishlist]);
        }
        $productName = \App\Models\Product::find($id)?->name ?? 'Produk';
        return redirect()->back()->with('success', $productName . ' dihapus dari Wishlist');
    }

    public function wishlistClear()
    {
        session()->forget('wishlist');
        return redirect()->route('landing')->with('success', 'Wishlist dikosongkan!');
    }
}
