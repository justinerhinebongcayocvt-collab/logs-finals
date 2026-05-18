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
    <title>Modify Studio Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Studio Profile</h1>
        <form action="core/handleForms.php?developer_id=<?php echo $_GET['developer_id']; ?>" method="POST">
            <input type="text" name="sName" value="<?php echo htmlspecialchars($studio['studio_name']); ?>" required>
            <input type="text" name="lDev" value="<?php echo htmlspecialchars($studio['lead_developer']); ?>" required>
            <input type="text" name="contact" value="<?php echo htmlspecialchars($studio['contact_number']); ?>" required>
            <input type="text" name="spec" value="<?php echo htmlspecialchars($studio['specialization']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($studio['email']); ?>" required>
            <input type="submit" name="editDeveloperBtn" value="Save Changes">
        </form>
        <a href="index.php" style="color: #6c757d;">Cancel and Return</a>
    </div>
</body>
</html>