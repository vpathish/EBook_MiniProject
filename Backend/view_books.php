<?php 
    
    $page_title="View Books";

    date_default_timezone_set("Asia/Kolkata");

    require("includes/connection.php");

    $book_id=trim($_GET['book_id']);

    $sql="SELECT * FROM tbl_books WHERE tbl_books.`id`='$book_id' ORDER BY tbl_books.`book_title` DESC";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_assoc($result);

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];

    $url2='book://ebook_app/view_books.php?book_id='.$book_id;

    $download_url='https://play.google.com/store/apps/details?id='.$settings_details['package_name'];

?>
<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8"> 
        <meta property="al:android:package" content="<?=$settings_details['package_name']?>">
        <meta property="al:android:app_name" content="<?php echo APP_NAME;?>">
        <meta property="og:title" content="<?php echo (isset($page_title)) ? $page_title.' | ' : '' ?><?php echo APP_NAME;?>" />
        <meta property="og:type" content="<?php echo APP_NAME;?>" />
        <meta name="viewport" content="width=device-width"> 
        <title><?php echo (isset($page_title)) ? $page_title.' | ' : '' ?><?php echo APP_NAME;?></title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,800&display=swap" rel="stylesheet">

        <style type="text/css">
            @import url('https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,800&display=swap');
            body{
                font-family: "Poppins", Helvetica, Arial, sans-serif; padding:1em;
            }
            .container{
                max-width:800px;
                margin:0 auto;
            }
            .header{
                background:#2d2424;
                box-shadow: 0px 5px 10px 0px #ddd;
                padding: 10px 20px;
                border-radius:6px;
                margin-bottom:25px;                     
            }
            .header img.logo{
                width: 80px;
                height: auto;
                float: left;
                margin-right: 20px
            }
            .header h1{
                color:#ffffff;
                font-size: 32px;
                padding: 20px 10px;
                margin: 0px;
                font-weight:600;
                display: inline-block;
            }
            h3{
                font-size:18px;
                margin-bottom:10px;
                margin-top:0;
                font-weight:600;
            }
            img.add_images{
                max-width:100%;
                border-radius:6px;
                box-shadow: 0px 5px 10px 0px #ddd;
                margin:15px auto;
                text-align:center;  
                display:block;  
            }
            .joinBtn, .downloadBtn {
                color: #ffffff;
                text-transform: uppercase;
                background: #424242;
                padding: 15px;
                border:0;
                border-radius: 6px;
                display: inline-block;
                transition: all 0.3s ease 0s;
                font-size: 14px;
                font-weight:600;
                box-shadow:0 5px 7px rgba(0, 0, 0, 0.2)
            }
            .joinBtn:hover, .downloadBtn:hover {
                color: #424242;
                cursor:pointer;
                border-radius: 6px;
                background: #f9f9f9;
                transition: all 0.3s ease 0s;
                box-shadow:0 5px 5px rgba(0, 0, 0, 0.3)
            }

            @media screen and (max-width: 768px) {
                .header img{
                    width: 60px;
                    height: 60px;
                }
                .header > h1 {
                    font-size: 20px;
                }
            }
            @media screen and (max-width: 639px) {
                .header{
                    text-align:center
                }   
                .header img.logo {
                    width: 70px;
                    height: 70px;
                    float: none;
                    margin-right: 0;
                    margin-top: 10px;
                }
                .header > h1 {
                    font-size: 20px;
                    padding: 10px 0 5px 0;
                }
            }   
        </style>
    </head> 
<body>
<div class="container">
    <div class="header">
        <img class="logo" src="images/<?php echo APP_LOGO;?>" alt="app logo"/>
        <h1><?php echo APP_NAME;?></h1>   
    </div>
    <h3>Book Name: <span style="font-weight:500;color:#424242;font-size:16px"><?=$row['book_title']?></span></h3>
    <!--<img class="add_images" src="banner.jpg" alt="banner" />-->
    <p style="font-weight:500">If you already have the install app then View books details</P>
    <button class="joinBtn" onclick="window.open('<?=$url2?>','_blank')">View books details!</button>
    <p style="font-weight:500">If you don't have the application install then click here</P>
    <button class="downloadBtn" onclick="window.open('<?=$download_url?>','_blank')">Download app</button>
</div>
</body>
</html>