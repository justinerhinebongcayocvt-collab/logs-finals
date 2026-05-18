<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php';
$p = getProjectByID($pdo, $_GET['project_id']);
?>
<!DOCTYPE html>
<html>
<head><title>Edit Game Profile</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h1>Edit Game Specifications</h1>
        <form action="core/handleForms.php?project_id=<?php echo $_GET['project_id']; ?>&developer_id=<?php echo $_GET['developer_id']; ?>" method="POST">
            <input type="text" name="pTitle" value="<?php echo htmlspecialchars($p['project_title']); ?>" required>
            <input type="number" step="0.01" name="budget" value="<?php echo htmlspecialchars($p['budget']); ?>" required>
            <input type="submit" name="editProjectBtn" value="Update Project Info">
        </form>
        <a href="viewprojects.php?developer_id=<?php echo $_GET['developer_id']; ?>" style="color: #6c757d;">Cancel</a>
    </div>
</body>
</html>