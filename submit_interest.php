<?php

//include koneksi database
include('env.php');

//get data dari form
$idproduct         = $_POST['id_product'];
$nama = $_POST['name'];
$alamatemail       = $_POST['email'];
$phonenumber       = $_POST['phone'];
$message       = $_POST['message'];

//query insert data ke dalam database
$query = "INSERT INTO tb_user_interest (name, no_telp, produk_id, message, email) VALUES ('$nama', '$phonenumber', '$idproduct', '$message', '$alamatemail')";

//kondisi pengecekan apakah data berhasil dimasukkan atau tidak
if($connection->query($query)) {

    //redirect ke halaman index.php 
    header("location: index.php");

} else {

    //pesan error gagal insert data
    echo "Data Gagal Disimpan!";

}

?>