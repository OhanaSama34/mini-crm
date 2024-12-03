<?php
session_start();

// Cek apakah pengguna sudah login dan apakah dia admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    // Redirect jika belum login atau bukan admin
    header("Location: index.php");
    exit();
}
?>

<?php include '../navbar.php'; ?>

<main class="container mx-auto px-6 py-10">
    <!-- Form Section -->
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-md shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Produk Baru</h2>
        <form action="simpan-product.php" method="POST" enctype="multipart/form-data">
            <!-- Nama Produk -->
            <div class="mb-4">
                <label for="nama_product" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="nama_product" id="nama_product" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <!-- Harga Produk -->
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga Produk</label>
                <input type="number" name="harga" id="harga" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <!-- Deskripsi Produk -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <!-- Gambar Produk -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="image" id="image" required 
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
            </div>
            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</main>


<?php include '../footer.php'; ?>