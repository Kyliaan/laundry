<?php
session_start();
include 'database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $role = $_POST['role'];

  $data = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username='$username' AND password='$password' AND role='$role'");
  $cek = mysqli_num_rows($data);

  if ($cek > 0) {
    $user = mysqli_fetch_assoc($data);
    
    $_SESSION["id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["nama"] = $user["nama"];
    $_SESSION["role"] = $user["role"];    

    if ($user["role"] == "admin"){
      header("Location: admin/dashboard.php");
    } elseif ($user["role"] == "kasir") {
      header("Location: kasir/dashboard.php");
    } else {
      header("Location: owner/dashboard.php");
    }
    exit();
  } else {
      $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aplikasi Laundry</title>
  <link rel="stylesheet" href="style/style.css" />
</head>
<body>
  <div class="background">
    <div class="login-card">
      <h2>Login</h2>
      <?php if (isset($error)) : ?>
        <p style="color:red;"><?= $error ?></p>
      <?php endif; ?>
      <form method="POST">
        <input type="username" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <select name="role" required>
          <option value="" disabled selected hidden>Role</option>
          <option value="admin">admin</option>
          <option value="kasir">kasir</option>
          <option value="owner">owner</option>
        </select>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
