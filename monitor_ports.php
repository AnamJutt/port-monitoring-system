<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

include("includes/db.php");
?>

<?php include("includes/header.php"); ?>

<?php include("includes/sidebar.php"); ?>

<div class="main-content">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h2>
                Monitor Ports
            </h2>

            <p>
                Manage and monitor network ports
            </p>

        </div>

    </div>

    <!-- REAL TIME LIVE MONITOR -->

<div class="table-card" style="margin-bottom:30px;">

    <div class="table-header">

        <h3>
            Real-Time Port Monitoring
        </h3>

    </div>

    <div style="padding:20px;">

        <input
            type="text"
            id="ipAddress"
            placeholder="Enter IP Address"
            value="127.0.0.1"
            style="
            padding:12px;
            width:300px;
            border:none;
            border-radius:8px;
            outline:none;
            margin-right:10px;
            ">

        <button
            onclick="scanPorts()"
            style="
            padding:12px 20px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            ">

            Scan Ports

        </button>

        <br><br>

        <div
            id="scanResults"
            style="
            background:#0f172a;
            color:#ffffff;
            padding:20px;
            border-radius:10px;
            min-height:200px;
            overflow:auto;
            font-family:monospace;
            ">
        </div>

    </div>

</div>

    <!-- TABLE CARD -->

    <div class="table-card">

        <div class="table-header">

            <h3>
                Port List
            </h3>

            <a href="admin/add_port.php"
               class="add-btn">

                + Add Port

            </a>

        </div>

        <!-- TABLE -->

        <div class="table-responsive">

            <table class="custom-table">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Port</th>
                        <th>Protocol</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $query =
                "SELECT * FROM ports";

                $result =
                mysqli_query($conn, $query);

                while($row =
                mysqli_fetch_assoc($result))
                {
                ?>

                    <tr>

                        <td>
                            <?php echo $row['id']; ?>
                        </td>

                        <td>
                            <?php echo $row['port_number']; ?>
                        </td>

                        <td>
                            <?php echo $row['protocol']; ?>
                        </td>

                        <td>
                            <?php echo $row['service_name']; ?>
                        </td>

                        <td>

                            <?php
                            if($row['status']
                               == "Active")
                            {
                                echo "
                                <span class='status status-active'>
                                    Active
                                </span>";
                            }
                            else
                            {
                                echo "
                                <span class='status status-inactive'>
                                    Inactive
                                </span>";
                            }
                            ?>

                        </td>

                        <td>

                            <!-- EDIT -->

                            <a href="admin/edit_port.php?id=<?php echo $row['id']; ?>"
                               class="edit-btn">

                                Edit

                            </a>

                            <!-- DELETE -->

                            <a href="admin/delete_port.php?id=<?php echo $row['id']; ?>" class="delete-btn delete-confirm">
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include("includes/footer.php"); ?>

<!-- SUCCESS ALERT -->

<?php
if(isset($_SESSION['success']))
{
?>

<script>

Swal.fire({

    icon:'success',

    title:'Success',

    text:'<?php echo $_SESSION['success']; ?>',

    confirmButtonColor:'#2563eb',

    background:'#0f172a',

    color:'#ffffff'

});

</script>

<?php

unset($_SESSION['success']);

}
?>

<!-- ERROR ALERT -->

<?php
if(isset($_SESSION['error']))
{
?>

<script>

Swal.fire({

    icon:'error',

    title:'Error',

    text:'<?php echo $_SESSION['error']; ?>',

    confirmButtonColor:'#ef4444',

    background:'#0f172a',

    color:'#ffffff'

});

</script>

<?php

unset($_SESSION['error']);

}
?>

<!-- REAL TIME SCANNER -->

<script>

function scanPorts()
{
    let ip =
    document.getElementById("ipAddress").value;

    document.getElementById("scanResults")
    .innerHTML =
    "Real-time scanning in progress...";

    fetch("scan.php?ip=" + ip)

    .then(response => response.text())

    .then(data => {

        document.getElementById("scanResults")
        .innerHTML = data;

    })

    .catch(error => {

        document.getElementById("scanResults")
        .innerHTML =
        "Error scanning ports.";

    });
}

/* AUTO REFRESH EVERY 20 SECONDS */

setInterval(() => {

    if(document.getElementById("ipAddress").value != "")
    {
        scanPorts();
    }

}, 20000);

</script>