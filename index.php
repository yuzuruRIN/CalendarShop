<?php
require_once('include.php');
require_once('connectionDB.php');

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM product WHERE name LIKE '%$search%'";
} elseif (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $sql = "SELECT * FROM product WHERE category_id = $category_id";
} else {
    $sql = "SELECT * FROM product";
}

$result = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีสินค้าในผลลัพธ์หรือไม่
if (mysqli_num_rows($result) == 0) {
?>
    <h1 style="text-align: center;" class="font-h1">ไม่พบสินค้า</h1>
<?php
} else {
?>
    <title>หน้าแรก</title>

    <div class="flex-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $status_class = ($row['status'] == 1 || $row['amount'] <= 0) ? 'button-cancel' : 'button-buy';
            $disabled_attr = ($row['status'] == 1 || $row['amount'] <= 0) ? 'disabled' : '';
        ?>
            <div class="product-card <?php echo ($row['status'] == 1 || $row['amount'] <= 0) ? 'cancelled' : ''; ?>">
                <form method="post" enctype="multipart/form-data">
                    <img src="assets/images/<?php echo $row['img']; ?>" alt="<?php echo $row['img']; ?>" class="product-card-img center">
                    <div class="container">
                        <h4><b><?php echo $row['name']; ?></b></h4>
                        <p><b>ราคา: <?php echo $row['price']; ?> บาท</b></p>
                        <p><b>จำนวนคงเหลือ:<?php echo $row['amount']; ?></b></p>
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button style="font-size:20px;" type="submit" name="submit" class="<?php echo $status_class; ?>" <?php echo $disabled_attr; ?>>
                            <?php echo ($row['status'] == 1 || $row['amount'] <= 0) ? 'ยกเลิกขาย' : 'สั่งซื้อ'; ?>
                        </button>
                </form>
            </div>
    </div>
<?php
        }
?>
</div>
<?php
}
?>



<?php
require_once('connectionDB.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];

    $sql = "UPDATE product SET amount = amount - 1 WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>showAlert('สำเร็จ', 'สั่งซื้อสำเร็จ', 'success'); setTimeout(function() { location.reload(); }, 1000);</script>";
    } else {
        echo "<script>showAlert('ไม่สำเร็จ', 'สั่งซื้อไม่สำเร็จ', 'error');</script>";
    }
}
