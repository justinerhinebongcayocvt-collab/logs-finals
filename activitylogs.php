<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html>
<head><title>Studio Master Logs</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="dashboard-container">
        <a href="index.php">← Back to Dashboard</a>
        <h1 style="margin-top:15px;">System Audit Activity Logs</h1>
        <table>
            <tr><th>Operation Type</th><th>Performed By</th><th>Activity Details</th><th>Timestamp</th></tr>
            <?php $logs = getAllLogs($pdo); foreach ($logs as $l) { ?>
            <tr>
                <td><b><?php echo htmlspecialchars($l['operation']); ?></b></td>
                <td><?php echo htmlspecialchars($l['done_by']); ?></td>
                <td><?php echo htmlspecialchars($l['description']); ?></td>
                <td><?php echo htmlspecialchars($l['date_added']); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>