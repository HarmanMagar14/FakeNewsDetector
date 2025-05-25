<?php
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $user['usertype'] ?? 'user';

            // Log activity after successful login
            log_activity($conn, $user['id'], $user['username'], $user['usertype'], 'Login', 'User logged in');

            // Redirect based on usertype
            if ($user["usertype"] == "admin") {
                header("Location: ../admin/admin_dashboard.php");
                exit();
            } elseif ($user["usertype"] == "user") {
                header("Location: ../user/user_dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=" . urlencode("Invalid user type."));
                exit();
            }
        } else {
            header("Location: index.php?error=" . urlencode("Invalid password. Please try again."));
            exit();
        }
    } else {
        header("Location: index.php?error=" . urlencode("No user found with that username."));
        exit();
    }
}

?>