<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Fetch developer details based on the ID in the URL
$studio = getDeveloperByID($pdo, $_GET['developer_id']); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Studio Project Pipelines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <a href="index.php">← Back to Studios</a>
        <h1 style="margin-top: 15px;">Projects Sandbox: <?php echo htmlspecialchars($studio['studio_name']); ?></h1>

        <div class="search-box">
            <h3>Deploy New Project Pipeline</h3>
            <form action="core/handleForms.php?developer_id=<?php echo $_GET['developer_id']; ?>" method="POST">
                <input type="text" name="pTitle" placeholder="Game Title / Working Codename" required>
                <input type="number" step="0.01" name="budget" placeholder="Allocated Development Budget ($)" required>
                <input type="submit" name="insertProjectBtn" value="Initialize Project">
            </form>
        </div>

        <table>
            <tr><th>Game Title</th><th>Budget Status</th><th>Actions</th></tr>
            <?php 
            // Fetch all projects associated with this developer studio
            $projects = getProjectsByDeveloper($pdo, $_GET['developer_id']); 
            foreach ($projects as $p) { ?>
            <tr>
                <td><?php echo htmlspecialchars($p['project_title']); ?></td>
                <td>$<?php echo number_format($p['budget'], 2); ?></td>
                <td>
                    <a href="editproject.php?project_id=<?php echo $p['project_id']; ?>&developer_id=<?php echo $_GET['developer_id']; ?>">Edit</a> | 
                    <a href="deleteproject.php?project_id=<?php echo $p['project_id']; ?>&developer_id=<?php echo $_GET['developer_id']; ?>" style="color:#dc3545;">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>