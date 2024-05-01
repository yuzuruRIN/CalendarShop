<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- css style -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style-tablet.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style-mobile.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap style -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- JavaScript -->
  <script src="assets/js/function.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<div class="topnav">
  <span style="font-size:30px;cursor:pointer;color:white" onclick="openNav()">&#9776;</span>
  <div class="search-container">
    <form method="GET">
      <input type="text" placeholder="ค้นหา" name="search">
    </form>
  </div>
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <p style="text-align: center;color:gray">Website by:Atipun Pongmun</p>
  <div class="font-text">
    <a href="index.php" style="font-size:24px;color:white;">Calendar Shop</a>
    <a href="add-product.php">เพิ่มสินค้า</a>
    <a href="add-category.php">เพิ่มหมวดหมู่สินค้าสินค้า</a>
    <a href="config-product.php">แก้ไขสินค้า</a>
    <div class="dropdown" style="margin-left: 32px">
      <form action="index.php" method="GET">
        <span style="color:white">หมวดหมู่สินค้า</span>
        <div class="dropdown-content">
          <ul>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "calendar-shop");
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT category_id, category_name FROM product_category";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<li><button type='submit' name='category_id' value='" . $row["category_id"] . "' class='category-button'>" . $row["category_name"] . "</button></li>";
              }
            }
            $conn->close();
            ?>
          </ul>
        </div>
      </form>
    </div>
  </div>
</div>