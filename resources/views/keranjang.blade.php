<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f9f9f9;
    }
    .wrapper {
      width: 85%;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }
    .title-box {
      text-align: center; /* membuat isi di tengah */
      margin-bottom: 20px;
    }
    .title-box h2 {
      display: inline-block; 
      padding: 10px 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f1f1f1;
      margin: 0; /* hilangkan margin default h2 */
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th {
      background-color: #f1f1f1;
      padding: 10px;
      text-align: center;
    }
    td {
      padding: 10px;
      text-align: center;
    }
    .total {
      text-align: left;
      margin-top: 15px;
      font-weight: bold;
      font-size: 18px;
    }
    .highlight {
      color: #d9534f;
    }
  </style>
</head>
<body>

  <div class="wrapper">
    <div class="title-box">
      <h2>Keranjang Belanja</h2>
    </div>

    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Produk dengan ID</th>
          <th>Jumlah</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Tensimeter Digital DrPro-012</td>
          <td>1</td>
          <td>Rp. 180.000</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Thermometer Digital DrPro-007</td>
          <td>2</td>
          <td>Rp. 40.000</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Kursi Roda Travel-016</td>
          <td>1</td>
          <td>Rp. 1.300.000</td>
        </tr>
      </tbody>
    </table>

    <div class="total">
      Total belanja (termasuk pajak): 
      <span class="highlight">Rp. 1.520.000</span>
    </div>
  </div>

</body>
</html>
