<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: ../login.php");
}

include("../includes/db.php");

$id = $_GET['id'];

$query = "SELECT * FROM ports WHERE id='$id'";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update_port']))
{
    $port_number = $_POST['port_number'];
    $protocol = $_POST['protocol'];
    $service_name = $_POST['service_name'];
    $status = $_POST['status'];

    $update = "UPDATE ports SET

                port_number='$port_number',
                protocol='$protocol',
                service_name='$service_name',
                status='$status'

                WHERE id='$id'";

    if(mysqli_query($conn, $update))
{
    $_SESSION['success'] =
    "Port Updated Successfully";

    header("Location: ../monitor_ports.php");

    exit();
}
else
{
    $_SESSION['error'] =
    "Failed To Update Port";
}
}
?>

<?php include("admin_header.php"); ?>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

    <div class="topbar">

        <div>
            <h2>Edit Port</h2>
            <p>Update port information</p>
        </div>

    </div>

    <div class="form-card">

        <form method="POST">

            <div class="form-group">

                <label>Port Number</label>

                <input type="number"
                       name="port_number"
                       value="<?php echo $row['port_number']; ?>"
                       required>

            </div>

            <div class="form-group">

                <label>Protocol</label>

                <input type="text"
                       name="protocol"
                       value="<?php echo $row['protocol']; ?>"
                       required>

            </div>

            <div class="form-group">

                <label>Service Name</label>

                <input type="text"
                       name="service_name"
                       value="<?php echo $row['service_name']; ?>"
                       required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select name="status" required>

                    <option value="Active"
                    <?php
                    if($row['status'] == "Active")
                    {
                        echo "selected";
                    }
                    ?>>
                    Active
                    </option>

                    <option value="Inactive"
                    <?php
                    if($row['status'] == "Inactive")
                    {
                        echo "selected";
                    }
                    ?>>
                    Inactive
                    </option>

                </select>

            </div>

            <button type="submit"
                    name="update_port"
                    class="save-btn">

                Update Port

            </button>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>