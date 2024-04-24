<?php
// get network interface details using 'ip addr' command
function getNetworkInterfaces() {
    //  return output
    $output = shell_exec('ip addr');
    return $output;
}

//  get server health details like CPU load
function getServerHealth() {
    // CPU Load
    $cpuLoad = sys_getloadavg();
    // Memory Usage
    $memInfo = explode("\n", shell_exec('free -m'));
    $memParts = preg_split('/\s+/', $memInfo[1]);
    $memTotal = $memParts[1];
    $memUsed = $memParts[2];
    // memory usage percentage
    $memUsagePercent = ($memUsed / $memTotal) * 100;
    // Disk Usage
    $diskUsage = shell_exec('df -h');
    $cpuCores = shell_exec("nproc");
    $serverHealth['cpuLoadPercent'] = ($serverHealth['cpuLoad'][0] / $cpuCores) * 100;
    return [
        'cpuLoad' => $cpuLoad,
        'memUsage' => $memUsagePercent,
        'diskUsage' => $diskUsage
    ];
}

// get information
$networkInfo = getNetworkInterfaces();
$serverHealth = getServerHealth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Computer and Network Info List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h1, h2, h3 { margin-bottom: 0.5em; }
        h2 { color: #4A90E2; }
        h3 { color: #7ED321; }
        pre { background-color: #f4f4f4; padding: 10px; border-radius: 5px; border: 1px solid #ddd; }
        .bar-chart { height: 20px; background-color: #7ED321; width: 0%; border-radius: 5px; }
        .bar-container { width: 100%; background-color: #EEE; border-radius: 5px; margin-bottom: 1em; }
        .refresh-button { background-color: #FF3B30; color: white; padding: 10px 20px; text-align: center; border: none; border-radius: 5px; cursor: pointer; }
        .refresh-button:hover { background-color: #FF5E50; }
        .description-container {
        background-color: #f9f9f9; /* Light grey background */
        border-left: 5px solid #4A90E2; /* Colored border on the left */
        padding: 15px;
        margin-bottom: 20px; /* Adds some space below the description */
        font-size: 1.1em; /* Slightly larger font size for better readability */
    }
    .back-to-main-button {
    position: fixed; /* Fixed position */
    top: 10px; /* 10px from the top */
    right: 10px; /* 10px from the right */
    background-color: #FF3B30; /* Red background */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000; /* Make sure it's above other items */
}

.back-to-main-button:hover {
    background-color: #4CAF50; /* Green background on hover */
}

    </style>
</head>



<body>
    <h1>Your Computer and Network Info List</h1>
    <div class="description-container">
        <p>This page provides a simple statistics about your network and computer.</p>
        <p>The info may delay(honestly the number isn't 100% accurate)
        <p>You can click the following buttom to get real-time page:</p>
    </div>
    <button class="refresh-button" onclick="window.location.reload();">Refresh</button>
    <button class="back-to-main-button" onclick="window.location.href='index.php';">Back to Main Page</button>

       
    <h2>Network Interface Details</h2>
    <pre><?= htmlspecialchars($networkInfo) ?></pre>
    
    <h2>Server Health Statistics</h2>
    <h3>CPU Load</h3>
    <div class="bar-container">
        <div class="bar-chart" style="width: <?= $serverHealth['cpuLoad'][0] * 100; ?>%;"><?= $serverHealth['cpuLoad'][0] * 100; ?>%</div>
    </div>
    
    <h3>Memory Usage (Used/Total)</h3>
    <div class="bar-container">
        <div class="bar-chart" style="width: <?= $serverHealth['memUsage']; ?>%;"><?= $serverHealth['memUsage']; ?>%</div>
    </div>
    <pre><?= htmlspecialchars($memInfo[1]); ?></pre>
    
    <h3>Disk Usage</h3>
    <pre><?= htmlspecialchars($serverHealth['diskUsage']) ?></pre>
</body>
</html>
