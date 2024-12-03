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
<?php

include('../env.php');

$number = $_GET['no_telp'];
$query2 = "SELECT DISTINCT name FROM tb_user_interest WHERE no_telp = $number";
$customer = mysqli_query($connection, $query2);
$customer_data = mysqli_fetch_array($customer);


?>
<!-- Main Content -->
<main class="container mx-auto px-6 py-10">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">
      Marketing Logs > <?php echo $customer_data['name']; ?>
    </h1>
  </div>

  <!-- Container untuk table dan form -->
  <div class="flex flex-wrap lg:flex-nowrap gap-6">
    <!-- Table Section -->
    <div id="recipients" class="p-8 rounded-2xl shadow-lg bg-white w-full lg:w-2/3">
      <h1 class="text-lg font-semibold text-gray-800 mb-5">Marketing Activity</h1>
      <table id="example" class="stripe hover w-full" style="padding-top: 1em; padding-bottom: 1em;">
        <thead>
          <tr>
            <th data-priority="1">No</th>
            <th data-priority="2">Type Activity</th>
            <th data-priority="2">Description</th>
            <th data-priority="2">Date</th>
            <th data-priority="3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require('../env.php');
          $no = 1;
          $query = mysqli_query(
            $connection,
            "SELECT 
              tb_marketing_activity.*, 
              tb_activity.nama_activity 
            FROM 
              tb_marketing_activity 
            JOIN 
              tb_activity 
            ON 
              tb_marketing_activity.activity_id = tb_activity.id 
            WHERE 
              tb_marketing_activity.user_interest_id = '$number'"
          );
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 border-b text-gray-900"><?php echo $no++; ?></td>
              <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['nama_activity']; ?></td>
              <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['deskripsi']; ?></td>
              <td class="px-6 py-4 border-b text-gray-900"><?php echo $row['tanggal']; ?></td>
              <td class="px-6 py-4 border-b">
                <div class="flex items-center space-x-3">
                  <a href="edit.php?id=<?php echo $row['id']; ?>" class="bg-indigo-600 text-white py-2 px-4 rounded-3xl hover:bg-indigo-700 transition duration-300">
                    Edit
                  </a>
                  <a href="hapus.php?id=<?php echo $row['id']; ?>" class="bg-red-600 text-white py-2 px-4 rounded-3xl hover:bg-red-700 transition duration-300" onclick="return confirm('Yakin ingin menghapus?')">
                    Delete
                  </a>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Form Section -->
    <div class="p-8 rounded-2xl shadow-lg bg-white w-full lg:w-1/3">
      <h1 class="text-lg font-semibold text-gray-800 mb-5">Add Activity</h1>
      <form action="tambah-activity.php" method="POST">
        <!-- Hidden input for user_interest_id -->
        <input type="hidden" name="user_interest_id" value="<?php echo $number; ?>">

        <div class="mb-4">
          <label for="activity" class="block text-gray-700 font-medium mb-2">Activity Type</label>
          <select name="activity_id" id="activity" class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Select Activity</option>
            <?php
            $activity_query = mysqli_query($connection, "SELECT * FROM tb_activity");
            while ($activity = mysqli_fetch_array($activity_query)) {
              echo "<option value='{$activity['id']}'>{$activity['nama_activity']}</option>";
            }
            ?>
          </select>
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
          <textarea name="deskripsi" id="description" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"></textarea>
        </div>
        <div class="mb-4">
          <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
          <input type="date" name="tanggal" id="date" class="w-full p-2 border border-gray-300 rounded-lg">
        </div>
        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
          Add Activity
        </button>
      </form>
    </div>
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