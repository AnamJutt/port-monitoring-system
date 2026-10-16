<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

/* CHECK ID */

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $query =
    "DELETE FROM ports
     WHERE id='$id'";

    if(mysqli_query($conn, $query))
    {
        $_SESSION['success'] =
        "Port Deleted Successfully";
    }
    else
    {
        $_SESSION['error'] =
        "Failed To Delete Port";
    }
}

/* REDIRECT */

header("Location: ../monitor_ports.php");
exit();
?>