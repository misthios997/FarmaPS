<?php
session_start();

// --- KONFIGURASI DATABASE GTPS.CLOUD ---
$db_host = "91.134.85.13"; 
$db_user = "MehanGG"; 
$db_pass = "123mehansgg456";
$db_name = "Mehangg";

$pesan_login = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek langsung ke database
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        // Pesan error diubah agar menampilkan detail dari server jika diblokir
        $pesan_login = "<div class='alert error'>Koneksi database gagal: " . $conn->connect_error . "</div>";
    } else {
        $user_safe = $conn->real_escape_string($username);
        $pass_safe = $conn->real_escape_string($password);

        $sql = "SELECT * FROM users WHERE username='$user_safe' AND password='$pass_safe'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $pesan_login = "<div class='alert success'>Login Sukses! Akun <b>$username</b> ditemukan di database FarmaPS.</div>";
        } else {
            $pesan_login = "<div class='alert error'>Login Gagal: Username atau Password salah/tidak ada di server.</div>";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel - FarmaPS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #1e1e1e;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 350px;
            text-align: center;
            border-top: 4px solid #00a8ff;
        }
        .login-container h1 {
            margin-top: 0;
            color: #00a8ff;
            font-size: 24px;
        }
        .login-container p {
            color: #aaa;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 4px;
            color: white;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #00a8ff;
        }
        .btn-login {
            background-color: #00a8ff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background-color: #008ecc;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }
        .success {
            background-color: rgba(46, 204, 113, 0.2);
            border: 1px solid #2ecc71;
            color: #2ecc71;
        }
        .error {
            background-color: rgba(231, 76, 60, 0.2);
            border: 1px solid #e74c3c;
            color: #e74c3c;
        }
        .server-info {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>FarmaPS Login</h1>
        <p>Login menggunakan akun In-Game kamu</p>

        <?php echo $pesan_login; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">GrowID (Username)</label>
                <input type="text" id="username" name="username" required autocomplete="off" placeholder="Masukkan GrowID">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan Password">
            </div>
            <button type="submit" class="btn-login">Login ke Web</button>
        </form>

        <div class="server-info">
            Server ID: 3587
        </div>
    </div>

</body>
</html>
