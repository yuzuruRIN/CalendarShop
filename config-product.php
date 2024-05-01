<?php
require_once('include.php');
require_once('connectionDB.php');

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM product WHERE name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);
}
?>

<title>แก้ไขสินค้า</title>

<div class="flex-container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="product-card">
            <form method="post" enctype="multipart/form-data">
                <img src="assets/images/<?php echo $row['img']; ?>" alt="<?php echo $row['img']; ?>" class="product-card-img center">
                <div class="container">
                    <h4><b><?php echo $row['name']; ?></b></h4>
                    <p><b>ราคา: <?php echo $row['price']; ?> บาท</b></p>
                    <p><b>จำนวนคงเหลือ:<?php echo $row['amount']; ?></b></p>
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                    <button type="submit" name="submit" class="button-4">ลบสินค้า</button>
            </form>
            <form method="post" action="edit-product.php">
                <input type="hidden" name="edit_product_id" value="<?php echo $row['product_id']; ?>">
                <button class="button-3" type="submit">แก้ไขสินค้า</button>
            </form>
        </div>
</div>
<?php
    }
?>
</div>

<?php
require_once('connectionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    $sql_select_img = "SELECT img FROM product WHERE product_id = $product_id";
    $result_select_img = mysqli_query($conn, $sql_select_img);
    $row_select_img = mysqli_fetch_assoc($result_select_img);
    $img_filename = $row_select_img['img'];

    $sql_delete_product = "DELETE FROM product WHERE product_id = $product_id";
    $result_delete_product = mysqli_query($conn, $sql_delete_product);

    if ($result_delete_product) {
        $image_path = "assets/images/$img_filename";
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        echo "<script>showAlert('สำเร็จ', 'ลบสินค้าสำเร็จ', 'success'); setTimeout(function() { location.reload(); }, 1000);</script>";
    } else {
        echo "<script>showAlert('ไม่สำเร็จ', 'ลบไม่สำเร็จ', 'error');</script>";
    }
}
?>
