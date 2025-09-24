<?php
session_start();

// Initialize session array if not set
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// Handle form submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($message)) {
        // Save message in session
        $_SESSION['messages'][] = [
            'name' => htmlspecialchars($name),
            'message' => htmlspecialchars($message)
        ];
    }
}

// Handle filtering (GET)
$filterUser = isset($_GET['user']) ? $_GET['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GuestList</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Welcome to the opening of Revontuli Hotel</h2>

    <!-- Form -->
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
            <textarea name="message" class="form-control" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Message</button>
    </form>

    <h4>Messages</h4>
    <ul class="list-group">
        <?php
        $hasMessages = false;
        foreach ($_SESSION['messages'] as $index => $msg) {
            // Apply filter if GET ?user=name is set
            if ($filterUser && strtolower($msg['name']) !== strtolower($filterUser)) {
                continue;
            }
            $hasMessages = true;
            echo "<li class='list-group-item'><strong>{$msg['name']}:</strong> {$msg['message']} 
            <a href='?user=" . urlencode($msg['name']) . "' class='ms-3 badge bg-info text-dark'>View only this user</a></li>";
        }

        if (!$hasMessages) {
            echo "<li class='list-group-item text-muted'>No messages found.</li>";
        }
        ?>
    </ul>

    <?php if ($filterUser): ?>
        <a href="php-labAct1.php" class="btn btn-secondary mt-3">Clear Filter</a>
    <?php endif; ?>

</body>
</html>
