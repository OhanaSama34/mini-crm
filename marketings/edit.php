<?php
require('../env.php');

// Ambil ID aktivitas dari URL
$id = $_GET['id'];

// Ambil data aktivitas berdasarkan ID
$query = mysqli_query($connection, "SELECT 
    tb_marketing_activity.*, 
    tb_activity.nama_activity 
  FROM 
    tb_marketing_activity 
  JOIN 
    tb_activity 
  ON 
    tb_marketing_activity.activity_id = tb_activity.id 
  WHERE 
    tb_marketing_activity.id = '$id'");
$row = mysqli_fetch_array($query);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data input dari form
    $activity_id = $_POST['activity_id'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];

    // Validasi input
    if (empty($activity_id) || empty($deskripsi) || empty($tanggal)) {
        $error_message = "Semua kolom wajib diisi!";
    } else {
        // Query untuk memperbarui data ke tb_marketing_activity
        $query_update = "UPDATE tb_marketing_activity 
                         SET activity_id = '$activity_id', deskripsi = '$deskripsi', tanggal = '$tanggal'
                         WHERE id = '$id'";

        // Cek apakah query berhasil dieksekusi
        if ($connection->query($query_update)) {
            // Redirect ke halaman view.php setelah berhasil mengedit data
            header("Location: view.php");
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            $error_message = "Data Gagal Diperbarui!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Marketing Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">

    <main class="container mx-auto px-6 py-10">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Edit Marketing Activity</h1>
        </div>

        <div class="flex flex-wrap gap-6">
            <!-- Form Section -->
            <div id="recipients" class="p-8 rounded-2xl shadow-lg bg-white w-full lg:w-2/3">
                <h1 class="text-lg font-semibold text-gray-800 mb-5">Edit Aktivitas Marketing</h1>

                <!-- Tampilkan pesan error jika ada -->
                <?php if (isset($error_message)): ?>
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Form untuk edit aktivitas -->
                <form action="edit.php?id=<?php echo $id; ?>" method="POST">
                    <!-- Hidden input untuk user_interest_id -->
                    <input type="hidden" name="user_interest_id" value="<?php echo $row['user_interest_id']; ?>">

                    <!-- Activity Type -->
                    <div class="mb-4">
                        <label for="activity" class="block text-gray-700 font-medium mb-2">Activity Type</label>
                        <select name="activity_id" id="activity" class="w-full p-2 border border-gray-300 rounded-lg" required>
                            <option value="" disabled>Select Activity</option>
                            <?php
                            $activity_query = mysqli_query($connection, "SELECT * FROM tb_activity");
                            while ($activity = mysqli_fetch_array($activity_query)) {
                                echo "<option value='{$activity['id']}'" . (($row['activity_id'] == $activity['id']) ? ' selected' : '') . ">{$activity['nama_activity']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="deskripsi" id="description" rows="4" class="w-full p-2 border border-gray-300 rounded-lg" required><?php echo $row['deskripsi']; ?></textarea>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                        <input type="date" name="tanggal" id="date" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $row['tanggal']; ?>" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Update Activity
                        </button>

                        <!-- Tombol Kembali -->
                        <a href="view.php" class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
