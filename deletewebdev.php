<?php 
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Fetches developer details using the updated model function
$studio = getDeveloperByID($pdo, $_GET['developer_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>De-register Studio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="border-top: 4px solid #dc3545;">
        <h1 style="color: #dc3545;">Remove Studio Portfolio?</h1>
        <p>Are you sure you want to delete <b><?php echo htmlspecialchars($studio['studio_name']); ?></b>? This action completely purges linked game development pipelines.</p>
        <form action="core/handleForms.php?developer_id=<?php echo $_GET['developer_id']; ?>" method="POST">
            <input type="submit" name="deleteDeveloperBtn" value="Confirm Permanent Deletion" style="background-color: #dc3545;">
        </form>
        <a href="index.php" style="color: #6c757d;">Cancel</a>
    </div>
</body>
</html>