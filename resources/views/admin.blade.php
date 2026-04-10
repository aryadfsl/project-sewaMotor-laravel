<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .modal-header {
            background-color: #0d6efd;
            color: white;
        }
        .product-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .badge {
            margin: 2px;
            font-size: 14px;
            padding: 6px 12px;
        }
        .kategori-Matic { background-color: #0d6efd; }
        .kategori-Bebek { background-color: #dc3545; }
        .kategori-Sport { background-color: #198754; }
        .kategori-Adventure { background-color: #fd7e14; }
        .kategori-Listrik { background-color: #6f42c1; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-kategori" href="#">Admin Panel - Showroom Motor</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="py-4">
        <div class="container mt-4">
            <h2>Manajemen Produk Motor</h2>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
                + Tambah Produk Motor
            </button>
            
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Motor</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>Rp{{ number_format($product->price,0,',','.') }}</td>
                        <td>
                            @if($product->stock > 0)
                                <span class="badge bg-success">{{ $product->stock }} unit</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $kategori = $product->kategori ?? ($product->categories[0]->name ?? null);
                                $kategoriClass = '';
                                switch(strtolower($kategori)) {
                                    case 'matic': $kategoriClass = 'kategori-Matic'; break;
                                    case 'bebek': $kategoriClass = 'kategori-Bebek'; break;
                                    case 'sport': $kategoriClass = 'kategori-Sport'; break;
                                    case 'adventure': $kategoriClass = 'kategori-Adventure'; break;
                                    case 'listrik': $kategoriClass = 'kategori-Listrik'; break;
                                    default: $kategoriClass = 'bg-secondary';
                                }
                            @endphp
                            <span class="badge {{ $kategoriClass }}">{{ strtoupper($kategori) }}</span>
                        </td>
                        <td>
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                Edit
                            </button>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin hapus produk {{ $product->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    
                    <!-- Edit Product Modal -->
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Produk Motor - {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Motor *</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Harga (Rp) *</label>
                                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Stok *</label>
                                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required min="0">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kategori *</label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="">Pilih kategori Motor</option>
                                                <option value="Matic" {{ (isset($product) && ($product->kategori == 'Matic' || (isset($selected) && in_array('Matic', $product->categories->pluck('name')->toArray() ?? [])))) ? 'selected' : '' }}>Matic</option>
                                                <option value="Bebek" {{ (isset($product) && ($product->kategori == 'Bebek' || (isset($selected) && in_array('Bebek', $product->categories->pluck('name')->toArray() ?? [])))) ? 'selected' : '' }}>Bebek</option>
                                                <option value="Sport" {{ (isset($product) && ($product->kategori == 'Sport' || (isset($selected) && in_array('Sport', $product->categories->pluck('name')->toArray() ?? [])))) ? 'selected' : '' }}>Sport</option>
                                                <option value="Adventure" {{ (isset($product) && ($product->kategori == 'Adventure' || (isset($selected) && in_array('Adventure', $product->categories->pluck('name')->toArray() ?? [])))) ? 'selected' : '' }}>Adventure</option>
                                                <option value="Listrik" {{ (isset($product) && ($product->kategori == 'Listrik' || (isset($selected) && in_array('Listrik', $product->categories->pluck('name')->toArray() ?? [])))) ? 'selected' : '' }}>Listrik</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gambar Motor</label>
                                            @if($product->image)
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url($product->image) }}" alt="Current image" style="max-width: 150px">
                                                    <br>
                                                    <small class="text-muted">Gambar saat ini</small>
                                                </div>
                                            @endif
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Update Motor</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data motor. Silakan tambah motor baru!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Motor Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Motor *</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Matic NMAX 155" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Masukkan deskripsi motor..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp) *</label>
                                <input type="number" name="price" class="form-control" placeholder="Contoh: 25000000" required min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok *</label>
                                <input type="number" name="stock" class="form-control" placeholder="Jumlah unit" required min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori *</label>
                            <select name="kategori" class="form-control" required>
                                <option value="">Pilih Kategori Motor</option>
                                <option value="Matic">Matic</option>
                                <option value="Bebek">Bebek</option>
                                <option value="Sport">Sport</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Listrik">Listrik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Motor</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Upload gambar motor (opsional)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Motor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>