<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $reservation_date = mysqli_real_escape_string($conn, $_POST['date']);
    $reservation_time = mysqli_real_escape_string($conn, $_POST['time']);
    $guests = mysqli_real_escape_string($conn, $_POST['guests']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO reservation (name, email, phone, reservation_date, reservation_time, guests, message)
            VALUES ('$name', '$email', '$phone', '$reservation_date', '$reservation_time', '$guests', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Reservation completed successfully! We will contacct you soon.');
                window.location.href = 'reservation.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
