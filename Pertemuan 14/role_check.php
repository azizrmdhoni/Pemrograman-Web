<?php
function check_role($allowed_roles = []) {
    if (!in_array($_SESSION['user']['role'], $allowed_roles)) {
        echo "<h2>403 - Forbidden</h2>";
        echo "<p>Anda tidak memiliki akses ke halaman ini.</p>";
        exit;
    }
}
?>