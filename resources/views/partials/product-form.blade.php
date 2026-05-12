<div class="mb-3">
    <label for="product_name{{ $product?->product_id }}" class="form-label">Nama Produk</label>
    <input type="text" class="form-control" id="product_name{{ $product?->product_id }}" name="product_name"
        value="{{ old('product_name', $product?->product_name) }}" required>
</div>

<div class="mb-3">
    <label for="category_id{{ $product?->product_id }}" class="form-label">Kategori</label>
    <select class="form-control" id="category_id{{ $product?->product_id }}" name="category_id" required>
        <option value="">Pilih Kategori</option>
        @foreach ($category as $cat)
            <option value="{{ $cat->category_id }}" @selected(old('category_id', $product?->category_id) == $cat->category_id)>
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="brand_id{{ $product?->product_id }}" class="form-label">Brand</label>
    <select class="form-control" id="brand_id{{ $product?->product_id }}" name="brand_id" required>
        <option value="">Pilih Brand</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->brand_id }}" @selected(old('brand_id', $product?->brand_id) == $brand->brand_id)>
                {{ $brand->nama_brand }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="product_price{{ $product?->product_id }}" class="form-label">Harga Produk</label>
    <input type="number" class="form-control" id="product_price{{ $product?->product_id }}" name="product_price"
        value="{{ old('product_price', $product?->product_price) }}" required>
</div>

<div class="mb-3">
    <label for="product_stock{{ $product?->product_id }}" class="form-label">Stok Produk</label>
    <input type="number" class="form-control" id="product_stock{{ $product?->product_id }}" name="product_stock"
        value="{{ old('product_stock', $product?->product_stock) }}" required>
</div>

<div class="mb-3">
    <label for="image{{ $product?->product_id }}" class="form-label">Gambar Produk</label>
    <input type="file" class="form-control" id="image{{ $product?->product_id }}" name="image" accept="image/*">
    @if($product?->image)
        <small class="text-muted">Gambar saat ini sudah tersimpan di storage.</small>
    @endif
</div>
