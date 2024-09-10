<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Search functionality
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Get all users except the logged-in user, filtered by search query if provided
if (!empty($search_query)) {
    $users_stmt = $pdo->prepare("SELECT * FROM users WHERE id != ? AND username LIKE ?");
    $users_stmt->execute([$user_id, '%' . $search_query . '%']);
} else {
    $users_stmt = $pdo->prepare("SELECT * FROM users WHERE id != ?");
    $users_stmt->execute([$user_id]);
}
$users = $users_stmt->fetchAll();

// Get connection requests
$requests_stmt = $pdo->prepare("SELECT u.*, c.id AS connection_id FROM users u JOIN connections c ON u.id = c.user_id WHERE c.friend_id = ? AND c.status = 'pending'");
$requests_stmt->execute([$user_id]);
$requests = $requests_stmt->fetchAll();

// Get all accepted connections
$connections_stmt = $pdo->prepare("SELECT u.* FROM users u JOIN connections c ON u.id = c.friend_id WHERE c.user_id = ? AND c.status = 'accepted'");
$connections_stmt->execute([$user_id]);
$connections = $connections_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Your Profile</h1>
    </header>

    <main>
        <section class="container">
            <h2>All Users</h2>

            <!-- Search bar for users -->
            <form method="GET" action="profile.php">
                <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit">Search</button>
            </form>

            <ul class="user-list">
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <li>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                            <form action="send_request.php" method="POST">
                                <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                                <button type="submit">Connect</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </ul>
        </section>

        <section class="container">
            <h2>Connection Requests</h2>
            <ul class="user-list">
                <?php foreach ($requests as $request): ?>
                    <li>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($request['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($request['email']); ?></p>
                        <form action="accept_request.php" method="POST" style="display:inline;">
                            <input type="hidden" name="connection_id" value="<?php echo $request['connection_id']; ?>">
                            <button type="submit">Accept</button>
                        </form>
                        <form action="reject_request.php" method="POST" style="display:inline;">
                            <input type="hidden" name="connection_id" value="<?php echo $request['connection_id']; ?>">
                            <button type="submit" class="reject">Reject</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="container">
            <h2>Your Connections</h2>
            <ul class="user-list">
                <?php foreach ($connections as $connection): ?>
                    <li>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($connection['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($connection['email']); ?></p>
                        <a href="view_messages.php?user_id=<?php echo $connection['id']; ?>"><button>Chat</button></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

    </main>
</body>
</html>
