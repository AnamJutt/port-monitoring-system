<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("../includes/db.php");

/* ADD PORT */

if(isset($_POST['add_port']))
{
    $port_number = $_POST['port_number'];
    $protocol = $_POST['protocol'];
    $service_name = $_POST['service_name'];
    $status = $_POST['status'];

    $query = "INSERT INTO ports
              (port_number, protocol, service_name, status)
              VALUES
              ('$port_number',
               '$protocol',
               '$service_name',
               '$status')";

   if(mysqli_query($conn, $query))
{
    $_SESSION['success'] =
    "Port Added Successfully";

    header("Location: ../monitor_ports.php");
    exit();
}
    else
    {
        $_SESSION['error'] =
        "Failed To Add Port";
    }
}
?>

<?php include("admin_header.php"); ?>

<?php include("../includes/sidebar.php"); ?>

<div class="main-content">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h2>Add Port</h2>

            <p>
                Create new network port record
            </p>

        </div>

    </div>

    <!-- FORM CARD -->

    <div class="form-card">

        <form method="POST">

            <!-- PORT NUMBER -->

            <div class="form-group">

                <label>
                    Port Number
                </label>

                <input type="number"
                       name="port_number"
                       required>

            </div>

            <!-- PROTOCOL -->

            <div class="form-group">

                <label>
                    Protocol
                </label>

                <input type="text"
                       name="protocol"
                       required>

            </div>

            <!-- SERVICE NAME -->

            <div class="form-group">

                <label>
                    Service Name
                </label>

                <input type="text"
                       name="service_name"
                       required>

            </div>

            <!-- STATUS -->

            <div class="form-group">

                <label>
                    Status
                </label>

                <select name="status"
                        required>

                    <option value="">
                        Select Status
                    </option>

                    <option value="Active">
                        Active
                    </option>

                    <option value="Inactive">
                        Inactive
                    </option>

                </select>

            </div>

            <!-- BUTTON -->

            <button type="submit"
                    name="add_port"
                    class="save-btn">

                Save Port

            </button>

        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>