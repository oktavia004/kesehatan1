<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Toko Alat Kesehatan</title>
  <style>
    /* Tetap sama dengan style kamu */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: #fff;
      padding: 30px 40px 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
      width: 450px;
    }

    .header {
      display: grid;
      grid-template-columns: 60px 1fr;
      align-items: center;
      margin-bottom: 30px;
    }

    .header img {
      width: 100px;
      justify-self: start;
    }

    .header h2 {
      text-align: center;
      font-size: 18px;
      color: #333;
      margin: 0;
      line-height: 1.4;
    }

    .form-group {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .form-group label {
      width: 100px;
      font-weight: bold;
      font-size: 14px;
      text-align: left;
    }

    .form-group input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .btn-login {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 10px;
      width: 50%;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin: 10px auto 0;
      display: block;
    }

    .btn-login:hover {
      background: #0056b3;
    }

    .note {
      margin-top: 15px;
      font-size: 13px;
      color: #333;
      text-align: center;
    }

    .note a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    .note a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="header">
      <img src="{{ asset('img/logo.png') }}" alt="Logo">
      <h2>Selamat Datang di<br>Toko Alat Kesehatan</h2>
    </div>

    <form action="{{ route('login.process') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="username">User ID</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="note">
      Belum punya akun? <a href="{{ route('register.show') }}">Register</a>
    </div>
  </div>

</body>
</html>
