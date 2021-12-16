<?php
    session_start();
    include('config/conn.php');
    if(isset($_POST['dangnhap'])){
        $taikhoan=$_POST['username'];
        // $matkhau=md5($_POST['password']);
        $matkhau=$_POST['password'];
        $sql = "SELECT * FROM tbl_admin WHERE username='$taikhoan' AND password='$matkhau' LIMIT 1";
        $row = mysqli_query($con,$sql);
        $count = mysqli_num_rows($row);
        if($count>0){
            $_SESSION['admin'] = $taikhoan;
            header("location:index.php");
        }else{
            //echo 'Đăng nhập thất bại!'
            header("location:login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body{
            background: #f2f2f2;
        }
        .wrapper_login{
            width: 20%;
            margin: 0 auto;
        }
        table tr{
            height: 30px;
        }
    </style>
</head>
<body>
<div class="wrapper_login">
    <form action="" autocomplete="off" method="POST">
    <table style="text-align:center;">
        <tr>
            <td colspan="2"><h3>Đăng nhập Admin</h3></td>
        </tr>
        <tr>
            <td>Tài khoản</td>
            <td><input type="text" name="username"></td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="dangnhap" value="Đăng nhập"></td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>
