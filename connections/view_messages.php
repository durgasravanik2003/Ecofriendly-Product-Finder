<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
$other_user_id = $_GET['user_id'];

// Fetch the other user's details
$user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$other_user_id]);
$other_user = $user_stmt->fetch();

// Fetch messages between the two users
$messages_stmt = $pdo->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY created_at ASC");
$messages_stmt->execute([$logged_in_user_id, $other_user_id, $other_user_id, $logged_in_user_id]);
$messages = $messages_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with <?php echo htmlspecialchars($other_user['username']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Chat with <?php echo htmlspecialchars($other_user['username']); ?></h1>
    </header>

    <main>
        <div class="container">
            <div class="chat-box">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?php echo $message['sender_id'] == $logged_in_user_id ? 'sent' : 'received'; ?>">
                        <p><?php echo htmlspecialchars($message['content']); ?></p>
                        <span class="timestamp"><?php echo $message['created_at']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <form action="send_message.php" method="POST" class="message-form">
                <input type="hidden" name="receiver_id" value="<?php echo $other_user_id; ?>">
                <textarea name="content" rows="3" placeholder="Type your message..." required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </main>
</body>
</html>
