
	<!-- Wishlist Button & Modal (Dari landing.blade.php) -->
	<div class="d-flex justify-content-end mb-3">
		<button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal"
			data-bs-target="#wishlistModal">
			Wishlist (<span id="wishlist-count">{{ session('wishlist') ? count(session('wishlist')) : 0 }}</span>)
		</button>
	</div>

	<div class="modal fade" id="wishlistModal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title">Daftar Wishlist Saya</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body">
					<ul class="list-group" id="daftar-wishlist">
						@forelse($wishlistProducts as $item)
							<li class="list-group-item py-3 px-2">
								<div class="d-flex align-items-center gap-3">
									@if($item->image)
										<img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
									@else
										<div style="width:48px;height:48px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;border-radius:8px;">
											<span class="text-muted">No Image</span>
										</div>
									@endif
									<div class="flex-grow-1">
										<div class="fw-bold mb-1" style="font-size:1.08em;">{{ $item->name }}</div>
										<div class="text-danger mb-1" style="font-size:1.02em;">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
										<div class="text-muted mb-1" style="font-size:0.97em;">Stok: {{ $item->stock }}</div>
										@if($item->categories && count($item->categories))
											<div class="mb-1">
												@foreach($item->categories as $cat)
													<span class="badge bg-secondary" style="font-size:0.82em;">{{ $cat->name }}</span>
												@endforeach
											</div>
										@endif
									</div>
									<form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="ms-auto" style="display:inline;">
										@csrf
										<button type="submit" class="btn btn-danger btn-sm px-3">Hapus</button>
									</form>
								</div>
							</li>
						@empty
							<li class="list-group-item text-muted">Wishlist kosong</li>
						@endforelse
					</ul>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
					<form action="{{ route('wishlist.clear') }}" method="POST" style="display:inline;">
						@csrf
						<button type="submit" class="btn btn-danger">Kosongkan</button>
					</form>
				</div>

			</div>
		</div>
	</div>
