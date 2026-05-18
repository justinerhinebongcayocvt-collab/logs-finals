<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html>
<head><title>Game Studio Directory</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="dashboard-container">
        <div class="meta-nav">
            <p>Active Operator: <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></p>
            <div>
                <a href="activitylogs.php">System Logs</a> | 
                <a href="core/handleForms.php?logout=1" style="color:#dc3545;">Logout</a>
            </div>
        </div>

        <h1>Game Developer Studio Registry</h1>
        
        <form action="core/handleForms.php" method="POST">
            <input type="text" name="sName" placeholder="Studio Name" required>
            <input type="text" name="lDev" placeholder="Lead Developer" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <input type="text" name="spec" placeholder="Specialization (e.g., RPG, Mobile, VR)" required>
            <input type="email" name="email" placeholder="Studio Business Email" required>
            <input type="submit" name="insertDeveloperBtn" value="Register Studio Portfolio">
        </form>

        <div class="search-box">
            <form action="index.php" method="GET">
                <input type="text" name="searchQuery" placeholder="Search studios by name, lead, or specialization..." value="<?php echo htmlspecialchars($_GET['searchQuery'] ?? ''); ?>">
                <input type="submit" value="Search Database" style="width: auto; padding: 8px 15px;">
                <a href="index.php" style="margin-left:10px; color:#6c757d;">Reset</a>
            </form>
        </div>

        <table>
            <tr><th>Studio Name</th><th>Lead Developer</th><th>Specialization</th><th>Actions</th></tr>
            <?php 
            $studios = (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) ? searchDevelopers($pdo, $_GET['searchQuery']) : getAllDevelopers($pdo);
            foreach ($studios as $row) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['studio_name']); ?></td>
                <td><?php echo htmlspecialchars($row['lead_developer']); ?></td>
                <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                <td>
                    <a href="viewprojects.php?developer_id=<?php echo $row['developer_id']; ?>">View Projects</a> | 
                    <a href="editwebdev.php?developer_id=<?php echo $row['developer_id']; ?>">Edit</a> | 
                    <a href="deletewebdev.php?developer_id=<?php echo $row['developer_id']; ?>" style="color:#dc3545;">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>