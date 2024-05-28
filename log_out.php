<?php
    session_start(); 

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    

    // Unset the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    // Redirect the user to the index.php page
    echo "<script>
            alert('Logging out');
            window.location.href='index.php';
            
          </script>";
    exit();
?>
