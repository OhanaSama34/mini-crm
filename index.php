<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Katalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // JavaScript untuk membuka dan menutup modal, serta menambahkan id_product
        function openModal(id_product) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('id_product').value = id_product; // Set id_product di form
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">E-Katalog</h1>
            <nav>
                <a href="./login.php" class="text-gray-600 hover:text-blue-600 transition">CRM</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            include('env.php');
            $query = mysqli_query($connection, "SELECT * FROM tb_product");
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition">
                    <img src="uploads/<?php echo $row['image'] ?>" alt="" class="rounded-t-lg w-full h-40 object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-700 truncate"><?php echo $row['nama_product'] ?></h2>
                        <p class="text-blue-600 font-bold mt-2">Rp <?php echo $row['harga'] ?></p>
                        <button onclick="openModal(<?php echo $row['id']; ?>)" class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                            I'm Interested
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Modal Form -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">I'm Interested</h2>
            <form action="submit_interest.php" method="POST">
                <input type="hidden" id="id_product" name="id_product"> <!-- Hidden input untuk id_product -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Your Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Your Email</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700">Your Phone Number</label>
                    <input type="number" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 E-Katalog. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
