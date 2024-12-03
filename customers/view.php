<!-- Script Protection Page -->
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


<!-- Main Content -->
<main class="container mx-auto px-6 py-10">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Potential Customers</h1>
    </div>

    <!--Card dengan lebar lebih besar-->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded-2xl shadow-lg bg-white w-full md:w-5/6 xl:w-full"> <!-- Diubah lebar card menjadi lebih besar -->
        <h1 class="text-lg font-semibold text-gray-800 mb-5">Product List</h1>
        <table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1">No</th>
                    <th data-priority="2">Product Name</th>
                    <th data-priority="2">Customer Interest</th>
                    <th data-priority="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require('../env.php');
                $no = 1;
                $query = mysqli_query($connection, "SELECT * FROM tb_product");
                while ($row = mysqli_fetch_array($query)) {
                    // Menghitung jumlah user yang tertarik dengan produk ini
                    $id_product = $row['id'];
                    $interest_query = mysqli_query($connection, "SELECT COUNT(*) as total_interest FROM tb_user_interest WHERE produk_id = '$id_product'");
                    $interest_data = mysqli_fetch_array($interest_query);
                    $total_interest = $interest_data['total_interest']; // Menyimpan jumlah ketertarikan
                ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $no++ ?></td>
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['nama_product'] ?></td>
                        <!-- Kolom baru untuk menampilkan jumlah ketertarikan -->
                        <td class="px-6 py-4 border-b text-gray-900"><?php echo $total_interest ?> Customer</td>
                        <td class="px-6 py-4 border-b">
                            <div class="flex items-center space-x-3">
                                <a href="interest-customer.php?id=<?php echo $row['id'] ?>" class="bg-blue-600 text-white py-2 px-4 rounded-3xl hover:bg-indigo-700 transition duration-300">
                                    See Interest Customer
                                </a>
                            </div>

                        </td>
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

<?php include '../footer.php'; ?>