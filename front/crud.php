<?php
require_once 'db.php';

actionHandler($_POST);

function actionHandler($post) {
    global $conn;
    $action = $post['action'] ?? '';

    if ($action === 'register') {
        $username = $post['username'];
        $email = $post['email'];
        $password = password_hash($post['password'], PASSWORD_DEFAULT);

        // Check for existing username or email
        $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "❌ Email or username already taken.";
            $check->close();
            return;
        }
        $check->close();

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ User registered successfully!');
                window.location.href = 'log in.html'; // 👈 change to your target page
            </script>";
        } else {
            echo "<script>
                alert('❌ Registration failed: " . $stmt->error . "');
                window.history.back();
            </script>";
        }
        $stmt->close();
        

    } elseif ($action === 'login') {
        $username = $post['username'];
        $password = $post['password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                echo "<script>
                alert('✅ login successfully!');
                window.location.href = 'http://localhost/khimaTrip/front/reservation.php'; 
            </script>";
            } else {
                echo "<script>
                alert('❌ login failed: " . $stmt->error . "');
                window.history.back();
            </script>";
            }
        } else {
            echo "❌ Username not found.";
        }
        $stmt->close();

    } elseif ($action === 'update') {
        $id = $post['id'];
        $email = $post['email'];

        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $id);

        if ($stmt->execute()) {
            echo "✅ Email updated.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($action === 'delete') {
        $id = $post['id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "🗑️ User deleted.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();

    } else {
        echo "❗ Unknown action.";
    }

    $conn->close();
}
