<?php
require_once('include.php');
?>

<title>เพิ่มสินค้า</title>
<div class="square">
    <p class="font-h1">เพิ่มสินค้า</p>
    <form method="post" enctype="multipart/form-data">
        <p class="font-text" style="margin-left:23px;margin-top:20px">ชื่อสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="text" id="product_name" name="product_name" required>
        <p class="font-text" style="margin-left:20px;margin-top:20px">ราคาสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="number" id="product_price" name="product_price" min="0" required>
        <p class="font-text" style="margin-left:20px;margin-top:20px">หมวดหมู่สินค้า</p>

        <select style="margin-left:20px" name="category" id="category">
            <?php

            $conn = mysqli_connect("localhost", "root", "", "calendar-shop");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT category_id, category_name FROM product_category";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                }
            } else {
                echo "<option value=''>ไม่พบข้อมูลหมวดหมู่</option>";
            }
            $conn->close();
            ?>
        </select>

        <p class="font-text" style="margin-left:20px;margin-top:20px">จำนวนสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="number" id="product_amount" name="product_amount" min="0" required>
        <p class="font-text" style="margin-left:20px;margin-top:20px">รูปสินค้า</p>
        <input style="margin-left:10px" type="file" id="product_image" name="product_image" accept="image/*" onchange="readURL(this);" required />
        <img style="margin-left:20px" id="blah" src="http://placehold.it/200" alt="your image" /><br>
        <button class="button-1" type="submit" name="submit">ยืนยัน</button>
    </form>
</div>



<?php
require_once('connectionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $category = $_POST['category'];
    $product_amount = $_POST['product_amount'];

    // Get image details
    $product_image = $_FILES['product_image'];
    $image_name = $product_image['name'];
    $image_tmp_name = $product_image['tmp_name'];
    $image_size = $product_image['size'];
    $image_error = $product_image['error'];

    // Get file extension
    $image_ext = explode('.', $image_name);
    $image_actual_ext = strtolower(end($image_ext));

    // Allowed extensions
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($image_actual_ext, $allowed)) {
        if ($image_error === 0) {
            // Generate unique filename
            $image_new_name = uniqid('', true) . "." . $image_actual_ext;
            $image_destination = 'assets/images/' . $image_new_name;
            // Move uploaded file to destination
            move_uploaded_file($image_tmp_name, $image_destination);

            // Insert into database
            $insert = "INSERT INTO product (name, price, img, amount,category_id) VALUES ('$product_name', '$product_price', '$image_new_name', '$product_amount', '$category')";
            $query = mysqli_query($conn, $insert);
            if ($query) {
                echo "<script>showAlert('สำเร็จ', 'เพิ่มสินค้าสำเร็จ', 'success');</script>";
            } else {
                echo "<script>showAlert('ไม่สำเร็จ', 'ไม่สามารถเพิ่มสินค้าได้', 'error');</script>";
            }
        } else {
            echo "<script>showAlert('ไม่สำเร็จ', 'ขนาดไฟล์รูปใหญ่เกินไป', 'error');</script>";
        }
    } else {
        echo "<script>showAlert('ไม่สำเร็จ', 'นามสกุลไฟล์รูปไม่ถูกต้อง', 'error');</script>";
    }
}
?>