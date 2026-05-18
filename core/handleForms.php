<?php
session_start();
require_once 'dbConfig.php';
require_once 'models.php';

$currentUser = $_SESSION['username'] ?? "System";

/* --- AUTHENTICATION ACTIONS --- */

if (isset($_POST['registerUserBtn'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!empty($username) && !empty($_POST['password'])) {
        if (insertUser($pdo, $username, $password)) {
            header("Location: ../login.php?success=1");
        } else {
            header("Location: ../login.php?error=UsernameExists");
        }
    }
    exit();
}

if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $user = loginUser($pdo, $username, $password);
    if ($user) { 
        $_SESSION['username'] = $user['username']; 
        header("Location: ../index.php"); 
    } else { 
        header("Location: ../login.php?error=1"); 
    }
    exit();
}

if (isset($_GET['logout'])) { 
    session_destroy(); 
    header("Location: ../login.php"); 
    exit(); 
}

/* --- DEVELOPER ACTIONS --- */

if (isset($_POST['insertDeveloperBtn'])) {
    $sName = trim($_POST['sName']);
    $lDev = trim($_POST['lDev']);
    $contact = trim($_POST['contact']);
    $spec = trim($_POST['spec']);
    $email = trim($_POST['email']);

    if (insertDeveloper($pdo, $sName, $lDev, $contact, $spec, $email)) {
        insertLog($pdo, "CREATE", null, $currentUser, "Added Developer Studio: " . $sName);
        header("Location: ../index.php");
    }
    exit();
}

if (isset($_POST['editDeveloperBtn'])) {
    $developer_id = $_GET['developer_id'];
    $sName = trim($_POST['sName']);
    $lDev = trim($_POST['lDev']);
    $contact = trim($_POST['contact']);
    $spec = trim($_POST['spec']);
    $email = trim($_POST['email']);

    if (updateDeveloper($pdo, $sName, $lDev, $contact, $spec, $email, $developer_id)) {
        insertLog($pdo, "UPDATE", $developer_id, $currentUser, "Updated Developer Studio: " . $sName);
        header("Location: ../index.php");
    }
    exit();
}

if (isset($_POST['deleteDeveloperBtn'])) {
    $developer_id = $_GET['developer_id'];
    
    if (deleteDeveloper($pdo, $developer_id)) {
        insertLog($pdo, "DELETE", $developer_id, $currentUser, "Deleted a Developer Studio record.");
        header("Location: ../index.php");
    }
    exit();
}

/* --- GAME PROJECT ACTIONS --- */

if (isset($_POST['insertProjectBtn'])) {
    $developer_id = $_GET['developer_id'];
    $pTitle = trim($_POST['pTitle']);
    $budget = $_POST['budget'];

    if (insertProject($pdo, $pTitle, $budget, $developer_id)) {
        insertLog($pdo, "CREATE", $developer_id, $currentUser, "Added Game Project: " . $pTitle);
        header("Location: ../viewprojects.php?developer_id=" . $developer_id);
    }
    exit();
}

if (isset($_POST['editProjectBtn'])) {
    $project_id = $_GET['project_id'];
    $developer_id = $_GET['developer_id'];
    $pTitle = trim($_POST['pTitle']);
    $budget = $_POST['budget'];

    if (updateProject($pdo, $pTitle, $budget, $project_id)) {
        insertLog($pdo, "UPDATE", $developer_id, $currentUser, "Updated Game Project: " . $pTitle);
        header("Location: ../viewprojects.php?developer_id=" . $developer_id);
    }
    exit();
}

if (isset($_POST['deleteProjectBtn'])) {
    $project_id = $_GET['project_id'];
    $developer_id = $_GET['developer_id'];

    if (deleteProject($pdo, $project_id)) {
        insertLog($pdo, "DELETE", $developer_id, $currentUser, "Deleted a game project record.");
        header("Location: ../viewprojects.php?developer_id=" . $developer_id);
    }
    exit();
}
?>