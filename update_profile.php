<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $phone = mysqli_real_escape_string($koneksi, $_POST['phone']);
    $address = mysqli_real_escape_string($koneksi, $_POST['address']);
    
    // Check if password is being updated
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "UPDATE users SET name = '$name', phone = '$phone', address = '$address', password = '$hashed_password' WHERE id = '$user_id'";
    } else {
        $query = "UPDATE users SET name = '$name', phone = '$phone', address = '$address' WHERE id = '$user_id'";
    }

    if (mysqli_query($koneksi, $query)) {
        // Update session name if it was changed
        $_SESSION['name'] = $name;
        $_SESSION['flash_msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>Profil berhasil diperbarui!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } else {
        $_SESSION['flash_msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Gagal memperbarui profil: " . mysqli_error($koneksi) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
    
    // Redirect back to the page they came from
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $referer");
    exit;
}
?>
