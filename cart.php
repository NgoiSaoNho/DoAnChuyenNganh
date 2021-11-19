<?php session_start();

    
 ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Shop AuGarden</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css//style.css" >

         <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;500;600&family=Markazi+Text:wght@600&family=Merriweather:wght@300&family=Noto+Sans:wght@400;700&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;500;600&family=Markazi+Text:wght@600&family=Merriweather:wght@300&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
    </head>
    <body>


         <div class="main">
          <div class="top">
            <img src="images/topp.jpg" style="width: 1100px;height: 270px;">
          </div>

       <div id="menu">
    <ul>
      <li>
        <a href="index.php"> Trang Chủ</a>
      </li>
      <li>
        <a href="index.php"> Kỹ Thuật Gieo Trồng</a>
      </li>
      <li>
        <a href="#"> Danh Mục Sản Phẩm</a>
        <ul class="sub-menu">
          <a href="./index.php">Hạt Giống Cây Ăn Qủa</a>
          <a href="">Hạt Giống Cây Lấy Củ</a>
          <a href="">Hạt Giống Cây Lấy Lá</a>
        </ul>
      </li>
       <li>
        <a href="index.php">Kỹ Thuật Trồng Cây</a>
      </li>
        <li>
        <a href="index.php">Giới Thiệu</a>
      </li>
      
     
     
      <li>
        <!-- dang nhap -->
        
        
          <?php 
            if (!empty($_SESSION['current_user'])) {
              echo '<a >';
              echo " " .$_SESSION['current_user'];
              echo '<ul class="sub-menu">';
      if (!empty($_SESSION['current_admin']) && $_SESSION['current_admin'] == 1) {
                echo '<a href="admin/product_listing.php">Quản trị</a>';
              }
              ?>
              
                 <a href="#">Thông tin</a>
                   <a href="logout.php">Đăng xuất</a>   
              </ul>
          <?php
            }else{
             echo '<a href="Login-Form/index.html">'; 
             echo " Đăng nhập";
            }
            
          ?>
          
        </a>


      </li>

    </ul>
  </div>






        <?php
         if (empty($_SESSION['current_user'])) {
              echo '<a href="Login-Form/index.html">'; 
              echo "<script>alert('Bạn phải đăng nhập để dùng chức năng này!');
                location.href='Login-Form/index.html'</script>";
        }
        
        include './connect_db.php';
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }


         $user_name = $_SESSION['current_user'];
         $user1 = mysqli_query($con, "SELECT * FROM `user` WHERE `username` = '$user_name'");
        $rowUser =  mysqli_fetch_array($user1);


        $error = false;
        $success = false;
        if (isset($_GET['action'])) {

            function update_cart($add = false) {
                foreach ($_POST['quantity'] as $id => $quantity) {
                    if ($quantity == 0) {
                        unset($_SESSION["cart"][$id]);
                    } else {
                        if ($add) {
                            $_SESSION["cart"][$id] += $quantity;
                        } else {
                            $_SESSION["cart"][$id] = $quantity;
                        }
                    }
                }
            }

            switch ($_GET['action']) {
                case "add":
                    update_cart(true);
                    header('Location: ./cart.php');
                    break;
                case "delete":
                    if (isset($_GET['id'])) {
                        unset($_SESSION["cart"][$_GET['id']]);
                    }
                    header('Location: ./cart.php');
                    break;
                case "submit":
                    if (isset($_POST['update_click'])) { //Cập nhật số lượng sản phẩm
                        update_cart();
                        header('Location: ./cart.php');
                    } elseif ($_POST['order_click']) { //Đặt hàng sản phẩm
                        if (empty($_POST['name'])) {
                            $error = "Bạn chưa nhập tên của người nhận";
                        } elseif (empty($_POST['phone'])) {
                            $error = "Bạn chưa nhập số điện thoại người nhận";
                        } elseif (empty($_POST['address'])) {
                            $error = "Bạn chưa nhập địa chỉ người nhận";
                        } elseif (empty($_POST['quantity'])) {
                            $error = "Giỏ hàng rỗng";
                        }
                        if ($error == false && !empty($_POST['quantity'])) { //Xử lý lưu giỏ hàng vào db
                            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
                            $total = 0;
                            $orderProducts = array();
                            while ($row = mysqli_fetch_array($products)) {
                                $orderProducts[] = $row;
                                $total += $row['price'] * $_POST['quantity'][$row['id']];
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['name'] . "', '" . $_POST['phone'] . "', '" . $_POST['address'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
                            $orderID = $con->insert_id;
                            $insertString = "";
                            foreach ($orderProducts as $key => $product) {
                                $insertString .= "(NULL, '" . $orderID . "', '" . $product['id'] . "', '" . $_POST['quantity'][$product['id']] . "', '" . $product['price'] . "', '" . time() . "', '" . time() . "')";
                                if ($key != count($orderProducts) - 1) {
                                    $insertString .= ",";
                                }
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
                            $success = "Đặt hàng thành công";
                            unset($_SESSION['cart']);
                        }
                    }
                    break;
            }
        }
        if (!empty($_SESSION["cart"])) {
            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }
//        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
//        $product = mysqli_fetch_assoc($result);
//        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
//        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
        <div class="container">
            <?php if (!empty($error)) { ?> 
                <div id="notify-msg">
                    <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
                </div>
            <?php } elseif (!empty($success)) { ?>
                <div id="notify-msg">
                    <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
                </div>
            <?php } else { ?>
                <!-- <a href="index.php">Trang chủ</a> -->
                <strong><p>Giỏ hàng</p></strong>
                <form id="cart-form" action="cart.php?action=submit" method="POST">
                    <table>
                        <tr>
                            <th class="product-number">STT</th>
                            <th class="product-name">Tên sản phẩm</th>
                            <th class="product-img">Ảnh sản phẩm</th>
                            <th class="product-price">Đơn giá</th>
                            <th class="product-quantity">Số lượng</th>
                            <th class="total-money">Thành tiền</th>
                            <th class="product-delete">Xóa</th>
                        </tr>
                        <?php
                        if (!empty($products)) {
                            $total = 0;
                            $num = 1;
                            while ($row = mysqli_fetch_array($products)) {
                                ?>
                                <tr>
                                    <td class="product-number"><?= $num++; ?></td>
                                    <td class="product-name"><?= $row['name'] ?></td>
                                    <td class="product-img"><img src="<?= $row['image'] ?>" /></td>
                                    <td class="product-price"><?= number_format($row['price'], 0, ",", ".") ?></td>
                                    <td class="product-quantity"><input type="text" value="<?= $_SESSION["cart"][$row['id']] ?>" name="quantity[<?= $row['id'] ?>]" /></td>
                                    <td class="total-money"><?= number_format($row['price'] * $_SESSION["cart"][$row['id']], 0, ",", ".") ?></td>
                                    <td class="product-delete"><a href="cart.php?action=delete&id=<?= $row['id'] ?>">Xóa</a></td>
                                </tr>
                                <?php
                                $total += $row['price'] * $_SESSION["cart"][$row['id']];
                                $num++;
                            }
                            ?>
                            <tr id="row-total">
                                <td class="product-number">&nbsp;</td>
                                <td class="product-name"><h2 style="color: red">Tổng tiền</h2></td>
                                <td class="product-img">&nbsp;</td>
                                <td class="product-price">&nbsp;</td>
                                <td class="product-quantity">&nbsp;</td>
                                <td class="total-money"><?= number_format($total, 0, ",", ".") ?></td>
                                <td class="product-delete">Xóa</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <div id="form-button">
                        <input type="submit" name="update_click" value="Cập nhật" />
                    </div>
                    <hr>
                    <div><strong><p>Thông Tin Người Nhận</p></strong></div>
                    <div><label>Người nhận: </label><input type="text" value='<?= $rowUser['fullname'] ?>' name="name" /></div>
                    <div><label>Điện thoại: </label><input type="text" value='<?= $rowUser['sdt'] ?>' name="phone" /></div>
                    <div><label>Địa chỉ: </label><input type="text" value='<?= $rowUser['diachi'] ?>' name="address" /></div>
                    <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
                

                    <input id="order" type="submit" name="order_click" value="Đặt hàng" />
                    <!-- <button><a href="HoadonKH.php">Đặt Hàng</a> </button> -->

                </form>
            <?php } ?>
        </div>



        <!-- -------------------------------footer--------------------- -->
 <div class="footer">
                        
                        <div class=f1>
                          <ul>
                            <li><a href="#" id="a">Giờ Bán hàng</a> </li>
                            <li><a href="#">Siêu Thị Hạt Giống Và Cây Trồng Như Ngọc</a><li>
                            <li><a href="#">Thứ 2 - Thứ 6: 8h sáng - 22h tối</a></li>
                            
                            <li><a href="#">Thứ 7: 10h sáng-21h tối(gọi khi cần gấp)               </a></li>
                            <li><a href="#">Chủ nhật: Đóng cửa</a></li><br>
                          </ul>

                        </div>

                        <div class=f2>
                          
                           <div class=f1>
                          <ul>
                            <li><a href="#" id="a">Liên hệ mua hàng</a> </li>
                            <li><a href="#">Địa chỉ: 1922,HH2H, Linh Đàm, Hoàng Mai, Hà Nội</a><li>
                            <li><a href="#">SĐT:0866795136</a></li>
                            
                            <li><a href="#">Email:shopnhungon@gmail.com<br></a></li>
                     
                          </ul>

                        </div>

                        </div>

                        <div class=f3>
                          
                            <div class=f1>
                          <ul>
                            <li><a href="#" id="a">Thông Tin </a> </li>
                            <li><a href="#">Địa chỉ:1922,HH2H, Linh Đàm, Hoàng Mai, Hà Nội</a><li>
                            <li><a href="#">SĐT:0866795136</a></li>
                            
                            <li><a href="#">Email:shopnhungon@gmail.com<br></a></li>
                         </ul>
 
                        </div>

                        </div>

                  </div>

                  <div class="coppy">
                <p>Copyright © 2020 HATGIONGTOT - All rights reserved code by Le Thi Thu</p>
                  </div>



    </body>
</html>