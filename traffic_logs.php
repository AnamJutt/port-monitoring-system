<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
}

include("includes/db.php");
?>

<?php include("includes/header.php"); ?>

<?php include("includes/sidebar.php"); ?>

<div class="main-content">

    <div class="topbar">

        <div>
            <h2>Traffic Logs</h2>
            <p>Monitor network traffic activity</p>
        </div>

    </div>

    <!-- SEARCH BAR -->

    <div class="search-box">

        <input type="text"
               id="searchInput"
               placeholder="Search logs...">

    </div>

    <!-- TABLE -->

    <div class="table-card">

        <div class="table-header">

            <h3>Traffic History</h3>

        </div>

        <div class="table-responsive">

            <table class="custom-table"
                   id="logsTable">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Port</th>
                        <th>Protocol</th>
                        <th>Traffic</th>
                        <th>Status</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                <?php

$query =
"SELECT * FROM traffic_logs
 ORDER BY id DESC";

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
        <?php echo $row['traffic_count']; ?> MB
    </td>

    <td>

        <?php
        if($row['status']=="open")
        {
            echo "<span class='status active'>Open</span>";
        }
        else
        {
            echo "<span class='status inactive'>Filtered</span>";
        }
        ?>

    </td>

    <td>
        <?php echo $row['log_time']; ?>
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

<!-- SEARCH SCRIPT -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
    document.getElementById("searchInput");

    const rows =
    document.querySelectorAll("#logsTable tbody tr");

    searchInput.addEventListener("keyup", function () {

        const filter =
        searchInput.value.toLowerCase();

        rows.forEach(function(row) {

            const text =
            row.textContent.toLowerCase();

            if(text.includes(filter))
            {
                row.style.display = "";
            }
            else
            {
                row.style.display = "none";
            }

        });

    });

});

</script>

<?php include("includes/footer.php"); ?>