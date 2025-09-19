<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Registrasi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      text-align: center;
      background: #fff;
      border: 1px solid #ddd;
      padding: 30px;
      width: 420px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .register-container h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 18px;
      color: #333;
      border: 2px solid #101010;
      border-radius: 8px;
      padding: 10px;
      display: inline-block;
      background-color: #f0f8ff;
    }

    .form-group {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .form-group label {
      width: 120px;
      font-weight: bold;
      font-size: 14px;
    }

    .form-group input,
    .form-group select {
      flex: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .gender-options {
      flex: 1;
    }

    .gender-options label {
      font-weight: normal;
      margin-right: 10px;
    }

    .form-actions {
      text-align: center;
      margin-top: 20px;
    }

    .form-actions button {
      background: #007bff;
      color: #fff;
      border: none;
      padding: 8px 20px;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      margin: 0 5px;
    }

    .form-actions button.clear {
      background: #dc3545;
    }

    .form-actions button:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>

  <div class="register-container">
    <h2>FORM REGISTRASI</h2>
    <form action="{{ route('register.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="retype">Retype Password:</label>
        <input type="password" id="retype" name="password_confirmation" required>
      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="date_of_birth">
      </div>

      <div class="form-group">
        <label>Gender:</label>
        <div class="gender-options">
          <label><input type="radio" name="gender" value="Male" required> Male</label>
          <label><input type="radio" name="gender" value="Female" required> Female</label>
        </div>
      </div>

      <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address">
      </div>

      <div class="form-group">
        <label for="city">City:</label>
        <select id="city" name="city">
          <option value="">--Pilih Kota--</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Jakarta">Jakarta</option>
          <option value="Surabaya">Surabaya</option>
          <option value="Bandung">Bandung</option>
        </select>
      </div>

      <div class="form-group">
        <label for="contact">Contact No:</label>
        <input type="text" id="contact" name="contact_no">
      </div>

      <div class="form-group">
        <label for="paypal">Pay-pal ID:</label>
        <input type="text" id="paypal" name="paypal_id">
      </div>

      <div class="form-actions">
        <button type="submit">Submit</button>
        <button type="reset" class="clear">Clear</button>
      </div>
    </form>
  </div>

</body>
</html>
