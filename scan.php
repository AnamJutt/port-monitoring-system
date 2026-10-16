<?php

include("includes/db.php");

if(isset($_GET['ip']))
{
    $ip = $_GET['ip'];

    $command =
    "nmap -p 1-1000 " . escapeshellarg($ip);

    $output =
    shell_exec($command);

    echo "
    <table style='width:100%; border-collapse:collapse; color:white;'>

        <tr style='background:#1e293b;'>

            <th style='padding:10px;'>Port</th>
            <th style='padding:10px;'>Status</th>
            <th style='padding:10px;'>Service</th>
            <th style='padding:10px;'>Monitoring</th>

        </tr>
    ";

    $lines = explode("\n", $output);

    foreach($lines as $line)
    {
        if(preg_match('/([0-9]+)\/tcp\s+(\w+)\s+(.+)/', $line, $matches))
        {
            $port =
            $matches[1];

            $state =
            $matches[2];

            $service =
            $matches[3];

            /* SAVE LIVE SCAN TO TRAFFIC LOGS */

$traffic =
rand(100,5000);

$current_date =
date("Y-m-d");

$current_time =
date("Y-m-d H:i:s");

/* CHECK IF PORT ALREADY EXISTS */

$check_query =
"SELECT * FROM traffic_logs
 WHERE port_number='$port'
 AND log_date='$current_date'";

$check_result =
mysqli_query($conn, $check_query);

if(mysqli_num_rows($check_result) == 0)
{
    $insert_query =
    "INSERT INTO traffic_logs
    (port_id, traffic_count, status, log_time, port_number, protocol, log_date)

    VALUES

    ('0', '$traffic', '$state', '$current_time',
    '$port', '$service', '$current_date')";

    mysqli_query($conn, $insert_query);
}

            /* CHECK DATABASE */

            $check_query =
            "SELECT * FROM ports
             WHERE port_number='$port'";

            $check_result =
            mysqli_query($conn, $check_query);

            if(mysqli_num_rows($check_result) > 0)
            {
                $monitor_status =
                "<span style='color:lightgreen; font-weight:bold;'>
                Monitored
                </span>";
            }
            else
            {
                $monitor_status =
                "<span style='color:red; font-weight:bold;'>
                Unknown
                </span>";
            }

            echo "

            <tr>

                <td style='padding:10px; border-bottom:1px solid #334155;'>
                    $port
                </td>

                <td style='padding:10px; border-bottom:1px solid #334155;'>
                    $state
                </td>

                <td style='padding:10px; border-bottom:1px solid #334155;'>
                    $service
                </td>

                <td style='padding:10px; border-bottom:1px solid #334155;'>
                    $monitor_status
                </td>

            </tr>
            ";
        }
    }

    echo "</table>";
}

?>