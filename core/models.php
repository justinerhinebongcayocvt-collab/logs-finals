<?php 
require_once 'dbConfig.php';

/* USER MANAGEMENT */
function insertUser($pdo, $username, $password) {
    $check = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $check->execute([$username]);
    if ($check->rowCount() == 0) {
        return $pdo->prepare("INSERT INTO users (username, password) VALUES (?,?)")->execute([$username, $password]);
    }
    return false;
}

function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if (password_verify($password, $user['password'])) return $user;
    }
    return false;
}

/* ACTIVITY LOGS */
function insertLog($pdo, $operation, $developer_id, $username, $description) {
    $sql = "INSERT INTO activity_logs (operation, developer_id, done_by, description) VALUES(?,?,?,?)";
    return $pdo->prepare($sql)->execute([$operation, $developer_id, $username, $description]);
}

function getAllLogs($pdo) {
    return $pdo->query("SELECT * FROM activity_logs ORDER BY date_added DESC")->fetchAll();
}

/* DEVELOPER FUNCTIONS */
function getAllDevelopers($pdo) {
    return $pdo->query("SELECT * FROM developers ORDER BY date_added DESC")->fetchAll();
}

function getDeveloperByID($pdo, $developer_id) {
    $stmt = $pdo->prepare("SELECT * FROM developers WHERE developer_id = ?");
    $stmt->execute([$developer_id]);
    return $stmt->fetch();
}

function searchDevelopers($pdo, $search) {
    $stmt = $pdo->prepare("SELECT * FROM developers WHERE studio_name LIKE ? OR lead_developer LIKE ? OR specialization LIKE ?");
    $q = "%".$search."%"; 
    $stmt->execute([$q, $q, $q]);
    return $stmt->fetchAll();
}

function insertDeveloper($pdo, $sName, $lDev, $contact, $spec, $email) {
    $sql = "INSERT INTO developers (studio_name, lead_developer, contact_number, specialization, email) VALUES (?,?,?,?,?)";
    return $pdo->prepare($sql)->execute([$sName, $lDev, $contact, $spec, $email]);
}

function updateDeveloper($pdo, $sName, $lDev, $contact, $spec, $email, $id) {
    $sql = "UPDATE developers SET studio_name=?, lead_developer=?, contact_number=?, specialization=?, email=? WHERE developer_id=?";
    return $pdo->prepare($sql)->execute([$sName, $lDev, $contact, $spec, $email, $id]);
}

function deleteDeveloper($pdo, $id) {
    // Optional: First delete dependent game projects to ensure no foreign key crashes
    $pdo->prepare("DELETE FROM game_projects WHERE developer_id = ?")->execute([$id]);
    return $pdo->prepare("DELETE FROM developers WHERE developer_id = ?")->execute([$id]);
}

/* GAME PROJECT FUNCTIONS */
function getProjectsByDeveloper($pdo, $developer_id) {
    $stmt = $pdo->prepare("SELECT * FROM game_projects WHERE developer_id = ?");
    $stmt->execute([$developer_id]);
    return $stmt->fetchAll();
}

function getProjectByID($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM game_projects WHERE project_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function insertProject($pdo, $title, $budget, $developer_id) {
    return $pdo->prepare("INSERT INTO game_projects (project_title, budget, developer_id) VALUES (?,?,?)")->execute([$title, $budget, $developer_id]);
}

function updateProject($pdo, $title, $budget, $id) {
    return $pdo->prepare("UPDATE game_projects SET project_title=?, budget=? WHERE project_id=?")->execute([$title, $budget, $id]);
}

function deleteProject($pdo, $id) {
    return $pdo->prepare("DELETE FROM game_projects WHERE project_id = ?")->execute([$id]);
}
?>