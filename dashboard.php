<?php
session_start();

// Cek apakah pengguna sudah login dan apakah dia admin
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'admin') {
    // Redirect jika belum login atau bukan admin
    header("Location: index.php");
    exit();
}
?>

<?php include 'navbar.php'; ?>

<?php
require_once 'env.php';
$product_query = mysqli_query($connection, "SELECT COUNT(*) AS jumlah_produk FROM tb_product");
$product_data = mysqli_fetch_array($product_query);
$total_product = $product_data['jumlah_produk'];
$marketing_query = mysqli_query($connection, "SELECT COUNT(*) AS jumlah_marketing_activity FROM tb_marketing_activity");
$marketing_data = mysqli_fetch_array($marketing_query);
$total_marketing = $marketing_data['jumlah_marketing_activity'];
$customer_query = mysqli_query($connection, "SELECT COUNT(*) AS jumlah_customer FROM tb_user_interest");
$customer_data = mysqli_fetch_array($customer_query);
$total_customer = $customer_data['jumlah_customer'];
?>

<!-- Main Content -->
<main class="container mx-auto px-6 py-10">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 mb-10 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Total Product E-Katalog</h2>
            <p class="text-2xl font-bold text-blue-600 mt-2"><?php echo $total_product ?> Product</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Marketing Frequently Activity</h2>
            <p class="text-2xl font-bold text-green-600 mt-2"><?php echo $total_marketing ?> Activites</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-700">Total Customer</h2>
            <p class="text-2xl font-bold text-yellow-600 mt-2"><?php echo $total_customer ?> Customer</p>
        </div>
    </div>

    <!-- Table -->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded-2xl shadow-lg bg-white w-full md:w-5/6 xl:w-full"> <!-- Diubah lebar card menjadi lebih besar -->
        <h1 class="text-lg font-semibold text-gray-800 mb-5">Marketing Activity (Latest)</h1>
        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">No</th>
                    <th data-priority="2">Customer Name</th>
                    <th data-priority="2">Type of Activity</th>
                    <th data-priority="2">Description</th>
                    <th data-priority="2">Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                require('env.php');
                $no = 1;
                $query = mysqli_query($connection, "SELECT 
                    tb_user_interest.name AS customer_name,
                    tb_activity.nama_activity AS activity_type,
                    tb_marketing_activity.deskripsi,
                    tb_marketing_activity.tanggal,
                    tb_marketing_activity.admin_id
                FROM 
                    tb_marketing_activity
                JOIN 
                    tb_user_interest ON tb_marketing_activity.user_interest_id = tb_user_interest.no_telp
                JOIN 
                    tb_activity ON tb_marketing_activity.activity_id = tb_activity.id
                ORDER BY 
                    tb_marketing_activity.tanggal DESC;
                ");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $no++ ?></td>
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['customer_name'] ?></td>
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['activity_type'] ?></td>
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['deskripsi'] ?></td>
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['tanggal'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {

        var table = $('#example').DataTable({
                responsive: true
            })
            .columns.adjust()
            .responsive.recalc();
    });
</script>

<?php include 'footer.php'; ?>