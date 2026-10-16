<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("includes/db.php");

/* TOTAL PORTS */

$total_ports_query =
"SELECT COUNT(*) AS total_ports
 FROM traffic_logs";

$total_ports_result =
mysqli_query($conn, $total_ports_query);

$total_ports =
mysqli_fetch_assoc($total_ports_result);


/* ACTIVE PORTS */
$active_ports_query =
"SELECT COUNT(*) AS active_ports
 FROM traffic_logs
 WHERE status='open'";

$active_ports_result =
mysqli_query($conn, $active_ports_query);

$active_ports =
mysqli_fetch_assoc($active_ports_result);


/* INACTIVE PORTS */

$inactive_ports_query =
"SELECT COUNT(*) AS inactive_ports
 FROM traffic_logs
 WHERE status!='open'";

$inactive_ports_result =
mysqli_query($conn, $inactive_ports_query);

$inactive_ports =
mysqli_fetch_assoc($inactive_ports_result);


/* TOTAL TRAFFIC */

$total_traffic_query =
"SELECT SUM(traffic_count) AS total_traffic
 FROM traffic_logs";

$total_traffic_result =
mysqli_query($conn, $total_traffic_query);

$total_traffic =
mysqli_fetch_assoc($total_traffic_result);
?>


<?php include("includes/header.php"); ?>

<?php include("includes/sidebar.php"); ?>

<div class="main-content">

    <div class="topbar">

    <div>

        <h2>Dashboard</h2>

        <p>
            Welcome,
            <?php echo $_SESSION['admin']; ?>
        </p>

    </div>

    <div class="live-clock">

        <h3 id="liveTime"></h3>

        <p id="liveDate"></p>

    </div>

</div>

<div class="cards">

    <div class="card-box">

        <h3>Total Ports</h3>

        <p>
            <?php echo $total_ports['total_ports']; ?>
        </p>

    </div>

    <div class="card-box">

        <h3>Open Ports</h3>

        <p>
            <?php echo $active_ports['active_ports']; ?>
        </p>

    </div>

    <div class="card-box">

        <h3>Filtered Ports</h3>

        <p>
            <?php echo $inactive_ports['inactive_ports']; ?>
        </p>

    </div>

    <div class="card-box">

        <h3>Total Traffic</h3>

        <p>
            <?php echo $total_traffic['total_traffic']; ?> MB
        </p>

    </div>

</div>


<!-- REAL TIME LIVE SCANNER -->

<div class="chart-card" style="margin-top:30px;">

    <h3>Real-Time Port Scanner</h3>

    <br>

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
        background:#3b82f6;
        border:none;
        border-radius:8px;
        color:white;
        cursor:pointer;
        ">

        Scan Now

    </button>

    <br><br>

    <div
        id="scanResults"
        style="
        background:#0f172a;
        padding:20px;
        border-radius:10px;
        min-height:200px;
        overflow:auto;
        color:#ffffff;
        font-family:monospace;
        ">
    </div>

</div>
<div class="charts-section">

    <!-- BAR CHART -->

    <div class="chart-card">

        <h3>Port Traffic Overview</h3>

        <canvas id="trafficChart"></canvas>

    </div>

    <!-- PIE CHART -->

    <div class="chart-card">

        <h3>Port Status Analysis</h3>

        <canvas id="statusChart"></canvas>

    </div>

</div>

</div>


<?php include("includes/footer.php"); ?>

<script>
    /* LIVE CLOCK */

function updateClock()
{
    const now = new Date();

    const time =
    now.toLocaleTimeString();

    const date =
    now.toDateString();

    document.getElementById("liveTime")
    .innerHTML = time;

    document.getElementById("liveDate")
    .innerHTML = date;
}

setInterval(updateClock, 1000);

updateClock();

/* BAR CHART */

const trafficChart =
document.getElementById('trafficChart');

new Chart(trafficChart, {

    type: 'bar',

    data: {

    labels:
<?php

$protocol_labels = [];
$traffic_data = [];

$chart_query =
"SELECT protocol,
SUM(traffic_count) AS total
FROM traffic_logs
GROUP BY protocol";

$chart_result =
mysqli_query($conn, $chart_query);

while($chart =
mysqli_fetch_assoc($chart_result))
{
    $protocol_labels[] =
    $chart['protocol'];

    $traffic_data[] =
    $chart['total'];
}

echo json_encode($protocol_labels);

?>,

datasets: [{

    label: 'Traffic Usage',

    data:
    <?php echo json_encode($traffic_data); ?>,

       

            backgroundColor: [
                '#3b82f6',
                '#8b5cf6',
                '#06b6d4',
                '#10b981',
                '#f59e0b'
            ],

            borderRadius: 10,
            borderWidth: 0

        }]
    },

    options: {

        responsive: true,
        maintainAspectRatio: false,

        plugins: {

            legend: {

                labels: {
                    color: '#ffffff',
                    font: {
                        size: 14
                    }
                }
            }
        },

        scales: {

            x: {

                ticks: {
                    color: '#e2e8f0'
                },

                grid: {
                    color: 'rgba(255,255,255,0.05)'
                }
            },

            y: {

                beginAtZero: true,

                ticks: {
                    color: '#e2e8f0'
                },

                grid: {
                    color: 'rgba(255,255,255,0.05)'
                }
            }
        }
    }
});


/* PIE CHART */

const statusChart =
document.getElementById('statusChart');

new Chart(statusChart, {

    type: 'doughnut',

    data: {

        labels: [
            'Active',
            'Inactive'
        ],

        datasets: [{

            data: [
                <?php echo $active_ports['active_ports']; ?>,
                <?php echo $inactive_ports['inactive_ports']; ?>
            ],

            backgroundColor: [
                '#10b981',
                '#ef4444'
            ],

            borderWidth: 0
        }]
    },

    options: {

        responsive: true,
        maintainAspectRatio: false,

        plugins: {

            legend: {

                labels: {

                    color: '#ffffff',

                    font: {
                        size: 14
                    }
                }
            }
        }
    }
});

/* REAL TIME PORT SCANNER */

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


/* AUTO REFRESH EVERY 10 SECONDS */

setInterval(() => {

    if(document.getElementById("ipAddress").value != "")
    {
        scanPorts();
    }

}, 20000); 

</script>