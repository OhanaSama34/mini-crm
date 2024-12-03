<?php

include('../env.php');

//get id
$id = $_GET['id'];

$query = "DELETE FROM tb_product WHERE id = '$id'";

if($connection->query($query)) {
    header("location: ./view.php");
} else {
    echo "DATA GAGAL DIHAPUS!";
}

?>