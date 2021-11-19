

<!DOCTYPE html>
<html>
<head>
  <title>Shop AuGarden</title>
  <link rel="stylesheet" type="text/css" href="css/rauqua.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;500;600&family=Markazi+Text:wght@600&family=Merriweather:wght@300&family=Noto+Sans:wght@400;700&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;500;600&family=Markazi+Text:wght@600&family=Merriweather:wght@300&family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">



</head>
<body>
  <?php
   session_start();
  $search = isset($_GET['name']) ? $_GET['name'] : "";
  if ($search) {
    $where = "WHERE `name` LIKE '%" . $search . "%'";
  }
  include './connect_db.php';
  $item_per_page = !empty($_GET['per_page']) ? $_GET['per_page'] : 8;
        $current_page = !empty($_GET['page']) ? $_GET['page'] : 1; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;
        if ($search) {
          $products = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%' ORDER BY `id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
          $totalRecords = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%" . $search . "%'");
        } else {
          $products = mysqli_query($con, "SELECT * FROM `product` ORDER BY `id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
          $totalRecords = mysqli_query($con, "SELECT * FROM `product`");
        }
        $totalRecords = $totalRecords->num_rows;
        $totalPages = ceil($totalRecords / $item_per_page);
        ?>
        
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


              echo '<a >Xin chào: 
              ';
              echo " " .$_SESSION['current_user'];
              echo '<ul class="sub-menu">';
      if (!empty($_SESSION['current_admin']) && $_SESSION['current_admin'] == 1) {
                echo '<a href="admin/product_listing.php">Quản trị</a>';
              }
              ?>
               <!--  <a href="#">Đăng Ký</a> -->
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

<!-- --------------------------------------------NOI DUNG GIOI THIEU------------------------------------- -->



            <div class="imformation">
                <div id="top-imformation">
                Công ty Cổ phần Thương mại và Đầu tư Au-Garden- đơn vị chuyên cung cấp phân phối giống cây trồng và các loại trái cây cao cấp trong nước và từ các nước trên thế giới đang từng bước phát triển và chiếm được lòng tin của người tiêu dùng Việt Nam.
                <br>
                 <img src="images/gioithieu1.jpg" >

                 <br>

               <strong><p>
                   Tên công ty: Công ty Cổ phần Thương mại và đầu tư Au-Garden
                   <br><br></p></strong> 

                  <strong><p>   Mã số thuế: 0101628217
                   <br><br></p></strong> 


                     <strong><p>  Địa chỉ: Phú Lâm - Tiên Du - Bắc Ninh - Việt Nam
                   <br><br></p></strong> 

                  <strong><p> Số điện thoại:0866795136<br><br></p></strong> 

                   <strong><p>Hotline: 02438313999/0972747899<br><br></p></strong> 

                   <strong><p>Số máy bàn: 02437956090<br><br></p></strong> 

                   <strong><p>Website: http://augarden.com.vn/<br><br></p></strong> 


                </div>
            </div>
















  


                  <!-- -------------------------footer------------------------------------------- -->

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


                  <style>












/*---------------------footer------------------------*/




                    body{
                      font-family: arial;height: 100vh;
                      margin: 50px auto;
                      background-color:   #fff;
                     /* background-image: url("images/main.jpg");*/
                      background-repeat: no-repeat;
                      background-size: cover;
                      background-position: center center;
                      background-attachment: fixed; 
                      margin: 0px auto;
                      float: left;
                      z-index: -1;
                    }

                    
         

                    .container{
                      width: 1100px;
                      margin-left: 90px;
                    }
                    h1{
                      text-align: center;
                    }
                    .product-items{
                      padding: 30px;
                    }
                    .product-item{
                      float: left;
                      width: 23%;
                      margin: 1%;
                      padding: 10px;
                      box-sizing: border-box;
                      /*border: 1px solid #ccc;*/
                      line-height: 26px;
                      background-color: #fff;
                    }
  
    .product-item:hover
    {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        
    }



                    .product-item label{
                      font-weight: bold;
                    }
                    .product-item p{
                      margin: 0;
                      line-height: 26px;
                      max-height: 52px;
                      overflow: hidden;
                    }
                    .product-price{
                      color: red;
                      font-weight: bold;
                    }
                    .product-img{
                      padding: 5px;

                      margin-bottom: 5px;
                    }
                    .product-item img{
                      width: 150px;
                      height: 130px; 
                      padding-left: 30px;
                    }
                    .product-item ul{
                      margin: 0;
                      padding: 0;
                      border-right: 2px solid green;
                    }
                    .product-item ul li{
                      float: left;
                      width: 33.3333%;
                      list-style: none;
                      text-align: center;
                      border: 1px solid green;
                      border-right: 0;
                      box-sizing: border-box;
                    }
                    .clear-both{
                      clear: both;
                    }
                    a{
                      text-decoration: none;
                    }
                    .buy-button{
                      text-align: right;
                      margin-top: 10px;
                    }

                    .buy-button a:hover
                    {
                      background-color: #f3c110;
                      color: #008000;
                      font-size: 20px;
                    }
                    .buy-button a{
                      background: green;
                      padding: 5px;
                      color: #fff;
                    }
                    #pagination{
                      text-align: right;
                      margin-top: 15px;
                    }
                    .page-item{
                      border: 1px solid #ccc;
                      padding: 5px 9px;
                      color: #000;
                    }
                    .current-page{
                      background: #000;
                      color: #FFF;
                    }
                    #wrapper-product{
                   /*   border: 1px solid #ccc;*/
                     font-family: 'Bitter', serif;
font-family: 'Markazi Text', serif;
font-family: 'Merriweather', serif;
font-family: 'Source Sans Pro', sans-serif;
margin-bottom: 20px;
                    }
                    #product-search{
                      margin: 0 40px;
                      padding-bottom: 20px;
                      border-bottom: 1px solid #ccc;
                    }
             #product-search input[type='submit']

              {
                width: 150px;
                float: right;
              }
                #product-search input[type='text']

              {
                width: 710px;
                
              }

                    .introduce{
                      display: flex;
                         width: 1100px;
                      margin-left: 90px;

                    }

                    .left-container{
                      width: 300px;
                      height: 306px;
                      margin-top: 10px;
                      border: 1px solid #ccc;
                     
                    }


                    .left-container ul li 
                    {
                          text-decoration: none; 
                          list-style: none; font-family: 'Bitter', serif;
font-family: 'Markazi Text', serif;
font-family: 'Merriweather', serif;
font-family: 'Noto Sans', sans-serif;
font-family: 'Source Sans Pro', sans-serif;
                        
                    }


                    .left-container #danhsach
                    {
                      height: 53px;
                      background-color: #4CAF50;
                      line-height: 53px;
                      text-align: center;

                    }

                    .left-container #danhsach p
                    {
                      margin:auto;color: white;

                    }


                    #nd:hover
                    {
                     background-color:  #F3C110;
                     font-size: 25px;
                     color: white;
                    }


                    .left-container #nd a
                    {
                      color: #000;
                    }

                     .left-container #nd a:hover
                    {
                      color: #fff;
                       font-size: 25px;

                    }
                    .left-container #nd
                    {
                      height: 50px;

                      padding-left: 10px;
                      padding-bottom: -1px;
                      line-height: 50px;
                      border-bottom: 0.5px dotted #ccc;
                     
                    }







                    .slideshow-container {
                      width: 700px;
                      position: relative;
                      margin-top: -10px;
                      margin-right: 50px;
                      margin-bottom: 180px;
                      margin-left: 20px;
                      height: 150px;
                    }


                    .slideshow-container #tin-phoi-giong{
                      width: 900px;
                      min-height: 250px;
                      /* border: 1px solid #F3C110;*/
                      padding: 10px 10px 10px 10px;

                    }
                    .slideshow-container #detail{
                      background-color: lightgreen;
                      height: 40px;
                      color: #FFF;
                      padding-left: 10px;
                      line-height: 40px;
                      width: 945px;

                    }

                    .slideshow-container #tin-phoi-giong #anh{


                      float: left;

                    }

                    .slideshow-container #tin-phoi-giong #anh img{
                      padding-top:  12px;
                   
                      padding-left:   30px;
                      width: 700px;
                      height: 300px;
                    }
                    .slideshow-container #tin-phoi-giong #chi-tiet{
                      width: 450px;
                      min-height: 100px;
                      padding-left: 15px;
                      float: left;
                    }







                    /* Next & previous buttons */
                    .prev, .next {
                      cursor: pointer;
                      position: absolute;
                      top: 50%;
                      width: auto;
                      padding: 16px;
                      margin-top: -22px;
                      color: white;
                      font-weight: bold;
                      font-size: 18px;
                      transition: 0.6s ease;
                      border-radius: 0 3px 3px 0;
                      user-select: none;
                    }

                    /* Position the "next button" to the right */
                    .next {
                      right: 0;
                      border-radius: 3px 0 0 3px;
                    }

                    /* On hover, add a black background color with a little bit see-through */
                    .prev:hover, .next:hover {
                      background-color: rgba(0,0,0,0.8);
                    }

                    /* Caption text */
                    .text {
                      color: #f2f2f2;
                      font-size: 15px;
                      padding: 8px 12px;
                      position: absolute;
                      bottom: 8px;
                      width: 100%;
                      text-align: center;
                    }

                    /* Number text (1/3 etc) */
                    .numbertext {
                      color: #f2f2f2;
                      font-size: 14px;
                      padding: 8px 12px 0px 390px;
                      position: absolute;
                      top: 0;
                    }

                    /* The dots/bullets/indicators */
                    #dott
                    {
                     margin:auto;

                     margin-left: 200px;
                     height: 30px;
                     /*  margin-top: -5px;*/
                   }
                   .dot {
                    cursor: pointer;
                    height: 15px;
                    width: 15px;
                    margin: 8px;
                    background-color: #bbb;
                    border-radius: 50%;
                    display: inline-block;
                    transition: background-color 0.6s ease;
                  }

                  .active, .dot:hover {
                    background-color: #717171;
                  }

                  /* Fading animation */
                  .fade {
                    -webkit-animation-name: fade;
                    -webkit-animation-duration: 0s;
                    animation-name: fade;
                    animation-duration: 0s;
                  }

                  @-webkit-keyframes fade {
                    from {opacity: .4} 
                    to {opacity: 1}
                  }

                  @keyframes fade {
                    from {opacity: .4} 
                    to {opacity: 1}
                  }

                  /* On smaller screens, decrease text size */
                  @media only screen and (max-width: 300px) {
                    .prev, .next,.text {font-size: 11px}
                    }a






</style>


</body>
</html>