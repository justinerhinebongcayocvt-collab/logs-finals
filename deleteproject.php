<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php';
$p = getProjectByID($pdo, $_GET['project_id']);
?>
<!DOCTYPE html>
<html>
<head><title>Terminate Game Project</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container" style="border-top: 4px solid #dc3545;">
        <h1 style="color: #dc3545;">Cancel Project Pipeline?</h1>
        <p>Are you sure you want to wipe out the database logs for <b><?php echo htmlspecialchars($p['project_title']); ?></b>?</p>

        <form action="core/handleForms.php?project_id=<?php echo $_GET['project_id']; ?>&developer_id=<?php echo $_GET['developer_id']; ?>" method="POST">
            <input type="submit" name="deleteProjectBtn" value="Confirm Permanent Drop" style="background-color: #dc3545;">
        </form>
        <br>
        <a href="viewprojects.php?developer_id=<?php echo $_GET['developer_id']; ?>" style="color: #6c757d;">Cancel and Go Back</a>
    </div>
</body>
</html>