const btnTheme = document.getElementById('btn-theme');
const body = document.body;

if (btnTheme && localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    btnTheme.innerText = "Mode Terang";
}

if (btnTheme) {
    btnTheme.addEventListener('click', function () {
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            btnTheme.innerText = "Mode Terang";
        } else {
            localStorage.removeItem('theme');
            btnTheme.innerText = "Mode Gelap";
        }
    });
}

function aktifkanTombolBeli() {
    const tombolBeli = document.querySelectorAll('.btn-detail');
    tombolBeli.forEach(function (button) {
        button.replaceWith(button.cloneNode(true));
    });

    const tombolBaru = document.querySelectorAll('.btn-detail');
    tombolBaru.forEach(function (button) {
        button.addEventListener('click', function (e) {
            const cardBody = e.target.closest('.card-body');
            const stokElement = cardBody.querySelector('.stok-text');
            let stok = parseInt(stokElement.innerText.replace("Stok: ", ""));

            if (stok > 0) {
                stok--;
                stokElement.innerText = "Stok: " + stok;
                const namaBarang = cardBody.querySelector('.card-title').innerText;
                alert("Berhasil membeli " + namaBarang);
            } else {
                alert("Stok Habis!");
                e.target.disabled = true;
                e.target.innerText = "Habis";
            }
        });
    });
}

aktifkanTombolBeli();


// Wishlist/Keranjang Section 
document.addEventListener('DOMContentLoaded', function () {
    if (!document.getElementById('wishlist-count')) {
        return;
    }

    // Ambil wishlist dari sessionStorage atau buat array baru
    let wishlist = JSON.parse(sessionStorage.getItem("wishlist")) || [];
    sessionStorage.setItem("wishlist", JSON.stringify(wishlist));

    // Update jumlah wishlist di badge header
    function updateWishlistCount() {
        document.getElementById('wishlist-count').innerText = wishlist.length;
    }

    // Simpan wishlist ke sessionStorage
    function simpanWishlist() {
        sessionStorage.setItem("wishlist", JSON.stringify(wishlist));
    }

    // Render isi wishlist di modal, tiap item ada tombol hapus
    function tampilkanWishlist() {
        const daftar = document.getElementById('daftar-wishlist');
        daftar.innerHTML = "";
        wishlist.forEach(function (item, idx) {
            const li = document.createElement('li');
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                <span>${item}</span>
                <button class="btn btn-sm btn-danger btn-remove-wishlist" data-idx="${idx}">Hapus</button>
            `;
            daftar.appendChild(li);
        });
        // Pasang event listener untuk tombol hapus pada setiap item
        daftar.querySelectorAll('.btn-remove-wishlist').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                const idx = parseInt(e.target.getAttribute('data-idx'));
                hapusItemWishlist(idx);
            });
        });
    }

    // Hapus satu item wishlist berdasarkan index
    function hapusItemWishlist(idx) {
        wishlist.splice(idx, 1);
        simpanWishlist();
        updateWishlistCount();
        tampilkanWishlist();
    }

    // Hapus semua isi wishlist
    function hapusWishlist() {
        wishlist = [];
        simpanWishlist();
        updateWishlistCount();
        tampilkanWishlist();
    }

    // Tambahkan item ke wishlist jika belum ada
    function tambahWishlist(nama) {
        if (wishlist.includes(nama)) {
            alert(nama + " sudah ada di Wishlist!");
            return;
        }
        wishlist.push(nama);
        simpanWishlist();
        updateWishlistCount();
        alert(nama + " ditambahkan ke Wishlist");
    }

    // Event tombol wishlist pada setiap card
    document.querySelectorAll('.btn-wishlist').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            let nama = e.target.closest('.card-body')
                .querySelector('.card-title').innerText;
            tambahWishlist(nama);
        });
    });

    // Ekspor fungsi ke global agar bisa dipanggil dari HTML
    window.tampilkanWishlist = tampilkanWishlist;
    window.hapusWishlist = hapusWishlist;
});
