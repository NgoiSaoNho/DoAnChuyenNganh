<?php 
    if(isset($_GET['dangxuat'])&&$_GET['dangxuat']==1){
        unset($_SESSION['dangnhap']);
        unset($_SESSION['cart']);
        unset($_SESSION['id_khachhang']);
    }
?>

<div class="menu">
            <ul class="list_menu">
               
                <li><a href="index.php">Trang chủ</a></li>

                <?php if(isset($_SESSION['dangnhap'])){?>
               
                    <li><a href="index.php?dangxuat=1">Đăng xuất</a></li>
                    <li><a href="index.php?quanly=doimatkhau">Đổi mật khẩu</a></li>

                <?php }else{ ?>
                    <li><a href="index.php?quanly=dangnhap">Đăng nhập</a></li>
                <?php }?>
                <li><a href="index.php?quanly=giohang">Giỏ hàng</a></li>
                
                <li><a href="index.php?quanly=tintuc">Tin tức</a></li>
                <li><a href="index.php?quanly=lienhe">Liên hệ</a></li>
            </ul>
            <form action="index.php?quanly=timkiem" method="POST">
                <div style="line-height: 50px;">
                    <input type="text" placeholder="Tìm kiếm..." name="tukhoa">
                    <input type="submit" name="timkiem" value="Tìm kiếm">
                </div>
            </form>

        </div>