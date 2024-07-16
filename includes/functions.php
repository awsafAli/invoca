<?php
function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function secureSessionStart() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}
?>
