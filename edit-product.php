<?php
require_once('include.php');

if (isset($_POST['edit_product_id'])) {
    $edit_product_id = $_POST['edit_product_id'];
    $conn = mysqli_connect("localhost", "root", "", "calendar-shop");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM product WHERE product_id = '$edit_product_id'";
    $result = $conn->query($sql);

    if ($result) { // ตรวจสอบว่า query สำเร็จหรือไม่
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $product_name = $row['name'];
                $product_price = $row['price'];
                $product_amount = $row['amount'];
                $product_image = $row['img'];
                $category_id = $row['category_id'];
                $status = $row['status'];
            }
        } else {
            echo "ไม่พบข้อมูลสินค้า";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // แสดง error กรณี query ไม่สำเร็จ
    }
    $conn->close();
}
?>


<title>แก้ไขสินค้า</title>
<div class="square">
    <p class="font-h1">แก้ไขสินค้า</p>
    <form method="post" enctype="multipart/form-data">
        <p class="font-text" style="margin-left:23px;margin-top:20px">ชื่อสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="text" id="product_name" name="product_name" value="<?php echo $product_name; ?>">
        <p class="font-text" style="margin-left:20px;margin-top:20px">ราคาสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="number" id="product_price" name="product_price" min="0" value="<?php echo $product_price; ?>">
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
                    $selected = ($row["category_id"] == $category_id) ? 'selected' : '';
                    echo "<option value='" . $row["category_id"] . "' $selected>" . $row["category_name"] . "</option>";
                }
            } else {
                echo "<option value=''>ไม่พบข้อมูลหมวดหมู่</option>";
            }
            $conn->close();
            ?>
        </select>
        <input style="margin-left:60px" type="checkbox" id="status" name="status" <?php if ($status == 1) echo 'checked'; ?>>
        <label for="status"> ยกเลิกการขาย </label><br>
        <p class="font-text" style="margin-left:20px;margin-top:20px">จำนวนสินค้า</p>
        <input style="margin-left:20px;margin-top:20px" type="number" id="product_amount" name="product_amount" min="0" value="<?php echo $product_amount; ?>">
        <p class="font-text" style="margin-left:20px;margin-top:20px">รูปสินค้า</p>
        <input style="margin-left:10px" type="file" id="product_image" name="product_image" accept="image/*" onchange="readURL(this);" />
        <img style="margin-left:20px" id="blah" src="assets/images/<?php echo $product_image; ?>" alt="your image" /><br>
        <input type="hidden" name="edit_product_id" value="<?php echo $edit_product_id; ?>">
        <button class="button-1" type="submit" name="submit">ยืนยัน</button>
    </form>
</div>

<?php
require_once('connectionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $category = $_POST['category'];
    $product_amount = $_POST['product_amount'];
    $status = isset($_POST['status']) ? 1 : 0;


    if ($_FILES['product_image']['size'] > 0) {
        
        $product_image = $_FILES['product_image'];
        $image_name = $product_image['name'];
        $image_tmp_name = $product_image['tmp_name'];
        $image_error = $product_image['error'];

        
        $image_ext = explode('.', $image_name);
        $image_actual_ext = strtolower(end($image_ext));

        
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($image_actual_ext, $allowed)) {
            if ($image_error === 0) {
                
                $image_new_name = uniqid('', true) . "." . $image_actual_ext;
                $image_destination = 'assets/images/' . $image_new_name;
                
                move_uploaded_file($image_tmp_name, $image_destination);

                
                if (!empty($edit_product_id)) {
                    
                    $sql = "SELECT img FROM product WHERE product_id = '$edit_product_id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $old_image_path = 'assets/images/' . $row['img'];
                        
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                }
            } else {
                echo "<script>showAlert('ไม่สำเร็จ', 'ข้อผิดพลาดในการอัปโหลดไฟล์', 'error');</script>";
                exit();
            }
        } else {
            echo "<script>showAlert('ไม่สำเร็จ', 'นามสกุลไฟล์รูปไม่ถูกต้อง', 'error');</script>";
            exit();
        }
    } else {
        $image_new_name = $product_image;
    }

    $update = "UPDATE product 
    SET name = '$product_name', 
        price = '$product_price', 
        img = '$image_new_name', 
        amount = '$product_amount', 
        category_id = '$category',
        status = '$status'
    WHERE product_id = '$edit_product_id'";

    $query = mysqli_query($conn, $update);
    if ($query) {
        echo "<script>showAlert('สำเร็จ', 'แก้ไขสินค้าสำเร็จ', 'success'); setTimeout(function() { window.location.href = 'config-product.php'; }, 1000);</script>";
    } else {
        echo "<script>showAlert('ไม่สำเร็จ', 'ไม่สามารถแก้ไขสินค้าได้', 'error');</script>";
    }
    
}
?>