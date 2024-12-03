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

<?php
include '../navbar.php';
require('../env.php');

$id = $_GET['id'];

$query = "SELECT * FROM tb_product WHERE id = $id LIMIT 1";
$interest_query = mysqli_query($connection, "SELECT COUNT(*) as total_interest FROM tb_user_interest WHERE produk_id = '$id'");
$interest_data = mysqli_fetch_array($interest_query);
$total_interest = $interest_data['total_interest'];
$result = mysqli_query($connection, $query);
$data = mysqli_fetch_array($result);
?>


<!-- Main Content -->
<main class="container mx-auto px-6 py-2">

    <section class="py-3 antialiased md:py-9">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl"><a href="<?php echo base_url('customers/view.php'); ?>">Potential Customers ></a> <?php echo $data['nama_product'] ?></h2>

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                    <div class="space-y-6">
                        <?php
                        $id = $_GET['id'];
                        $query = mysqli_query($connection, "SELECT * FROM tb_user_interest WHERE produk_id = '$id'");
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:p-6 relative">
                                <div class="space-y-4 mb-10 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                    <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                        <a href="#" class="text-base font-medium text-gray-900 hover:underline"> Name : <?php echo $row['name'] ?></a>
                                        <p class="text-base font-normal text-gray-400"> Contact : <?php echo $row['no_telp'] ?> | <?php echo $row['email'] ?></p>
                                        <textarea id="message" name="message" rows="4" class="w-full p-2 border border-gray-300 rounded-lg"><?php echo $row['message'] ?></textarea>
                                    </div>
                                </div>
                                <!-- Tombol WhatsApp -->
                                <a href="https://wa.me/+<?php echo $row['no_telp']; ?>?text=Halo%20<?php echo urlencode($row['name']); ?>,%20saya%20tertarik%20dengan%20produk%20Anda."
                                    target="_blank"
                                    class="absolute bottom-4 right-4 bg-green-500 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition duration-300 flex items-center space-x-2"
                                    title="Hubungi via WhatsApp">
                                    <!-- Icon WhatsApp -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.477 2 2 6.477 2 12c0 1.61.383 3.133 1.051 4.5L2 22l5.5-1.051C8.867 21.617 10.39 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm-.025 18c-1.463 0-2.878-.355-4.142-1.035l-.297-.158-3.259.623.621-3.236-.163-.302A8.022 8.022 0 0 1 3.975 12c0-4.422 3.6-8.025 8.025-8.025 4.422 0 8.025 3.603 8.025 8.025 0 4.425-3.603 8.025-8.025 8.025zm4.803-5.633c-.263-.132-1.558-.77-1.798-.859-.237-.09-.41-.132-.582.132-.173.26-.67.859-.821 1.034-.152.175-.302.197-.566.065-.263-.132-1.11-.407-2.116-1.298-.781-.693-1.309-1.548-1.464-1.811-.152-.263-.016-.407.116-.539.121-.121.26-.316.39-.473.132-.158.173-.263.263-.434.089-.174.044-.328-.021-.46-.066-.132-.582-1.4-.798-1.92-.211-.508-.425-.438-.582-.445h-.498c-.173 0-.454.066-.692.328-.237.263-.907.887-.907 2.161 0 1.273.927 2.5 1.056 2.674.131.175 1.823 2.768 4.426 3.878.618.267 1.1.426 1.475.545.619.196 1.18.168 1.623.103.495-.074 1.558-.637 1.779-1.25.22-.614.22-1.14.154-1.25-.066-.105-.237-.158-.498-.289z" />
                                    </svg>
                                    <span>WhatsApp</span>
                                </a>
                            </div>


                        <?php } ?>
                    </div>
                </div>

                <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                        <p class="text-xl font-semibold text-gray-900"><?php echo $data['nama_product'] ?> Summary</p>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 ">Interest</dt>
                                    <dd class="text-base font-medium text-gray-900 "><?php echo $total_interest ?> </dd>
                                </dl>
                            </div>
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 ">Marketing Activites</dt>
                                    <dd class="text-base font-medium text-gray-900 "><?php echo $total_interest ?> </dd>
                                </dl>
                            </div>

                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2"></dl>
                        </div>

                        <div href="#" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"></div>

                        <div class="flex items-center justify-center gap-2">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> see </span>
                            <a href="<?php echo base_url('marketings/view.php'); ?>" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline dark:text-primary-500">
                                Marketing Tracking
                                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

<?php include '../footer.php'; ?>