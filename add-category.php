<?php
require_once('include.php');

?>

<title>เพิ่มหมวดหมู่สินค้าสินค้า</title>
<div class="small-square">
    <p class="font-h1">เพิ่มหมวดหมู่สินค้า</p>
    <form method="post" enctype="multipart/form-data">
        <p class="font-text" style="display: inline-block;margin-left:50px;margin-top:20px">หมวดหมู่สินค้า</p>
        <input style="margin-left:20px;margin-top:10px" placeholder="กรอกหมวดหมู่ที่ต้องการ" type="text" id="category_name" name="category_name" required>
        <button type="submit" name="submitAdd" class="button-1" style="margin-left:18rem;margin-top:20px;margin-bottom:20px">เพิ่มหมวดหมู่</button>
        <button type="submit" name="submitDelete" class="button-1" style="margin-left:18rem;margin-top:20px;margin-bottom:20px;background-color:red">ลบหมวดหมู่</button>
    </form>
</div>


<?php
require_once('connectionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitAdd'])) {
    $category_name = $_POST['category_name'];


    // Insert into database
    $insert = "INSERT INTO product_category (category_name) VALUES ('$category_name')";
    $query = mysqli_query($conn, $insert);

    if ($query) {
        echo "<script>showAlert('สำเร็จ', 'เพิ่มหมวดหมู่สำเร็จ', 'success');</script>";
    } else {
        echo "<script>showAlert('ไม่สำเร็จ', 'ไม่สามารถเพิ่มหมวดหมู่ได้', 'error');</script>";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitDelete'])) {
    $category_name = $_POST['category_name'];

    
    $check_query = "SELECT * FROM product_category WHERE category_name = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);

    
    mysqli_stmt_bind_param($check_stmt, "s", $category_name);

    
    mysqli_stmt_execute($check_stmt);

    
    mysqli_stmt_store_result($check_stmt);

    
    if (mysqli_stmt_num_rows($check_stmt) == 0) {
        echo "<script>showAlert('ไม่สำเร็จ', 'ไม่พบหมวดหมู่ที่ต้องการลบ', 'error');</script>";
    } else {
        
        $delete = "DELETE FROM product_category WHERE category_name = ?";
        $stmt = mysqli_prepare($conn, $delete);

        
        mysqli_stmt_bind_param($stmt, "s", $category_name);

        
        $queryDelete = mysqli_stmt_execute($stmt);

        if ($queryDelete) {
            echo "<script>showAlert('สำเร็จ', 'ลบหมวดหมู่สำเร็จ', 'success');</script>";
        } else {
            echo "<script>showAlert('ไม่สำเร็จ', 'ไม่สามารถลบหมวดหมู่ได้', 'error');</script>";
        }
    }
}



?>