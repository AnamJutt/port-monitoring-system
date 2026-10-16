<?php

$conn = mysqli_connect("localhost", "root", "", "port_monitoring");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>