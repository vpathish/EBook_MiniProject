<?php $page_title="Users Profile";
	                                                                                                                                                                                                                                                                                                                                                                                                                             
	include('includes/header.php'); 
	include('includes/function.php');
	include('language/language.php');

	error_reporting(0);
    	
	$user_id=strip_tags(addslashes(trim($_GET['user_id'])));

	if(!isset($_GET['user_id']) OR $user_id==''){
		header("Location: manage_users.php");
	}

    $user_qry="SELECT * FROM tbl_users WHERE id='$user_id'";
    $user_result=mysqli_query($mysqli,$user_qry);

    if(mysqli_num_rows($user_result)==0){
    	header("Location: manage_users.php");
    }

    $user_row=mysqli_fetch_assoc($user_result);

    $user_img='';

	if($user_row['user_profile']!='' && file_exists('images/'.$user_row['user_profile'])){
		$user_img='images/'.$user_row['user_profile'];
	}
	else{
		$user_img='assets/images/user-icons.jpg';
	}


    if(isset($_POST['btn_submit']))
    {	

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {
            $_SESSION['class']="warn";
            $_SESSION['msg']="invalid_email_format";
        }
        else{

            $email=cleanInput($_POST['email']);

            $sql="SELECT * FROM tbl_users WHERE `email` = '$email' AND `id` <> '".$user_id."'";

            $res=mysqli_query($mysqli, $sql);

            if(mysqli_num_rows($res) == 0){
                $data = array(
                    'name'  =>  cleanInput($_POST['name']),
                    'email'  =>  cleanInput($_POST['email']),
                    'phone'  =>  cleanInput($_POST['phone'])
                );

                if($_POST['password']!="")
                {

                    $password=md5($_POST['password']);

                    $data = array_merge($data, array("password"=>$password));
                }


                  if($_FILES['user_profile']['name']!="")
               		 {

                    if($user_row['user_profile']!="" OR !file_exists('images/'.$user_row['user_profile']))
                    {
                        unlink('images/'.$user_row['user_profile']);
                    }

                    $ext = pathinfo($_FILES['user_profile']['name'], PATHINFO_EXTENSION);

                    $user_profile=rand(0,99999).'_'.date('dmYhis')."_user.".$ext;

                    //Main Image
                    $tpath1='images/'.$user_profile;   

                    if($ext!='png')  {
                      $pic1=compress_image($_FILES["user_profile"]["tmp_name"], $tpath1, 80);
                    }
                    else{
                      $tmp = $_FILES['user_profile']['tmp_name'];
                      move_uploaded_file($tmp, $tpath1);
                    }

                    $data = array_merge($data, array("user_profile" => $user_profile));

                }

                $user_edit=Update('tbl_users', $data, "WHERE id = '".$user_id."'");

                $_SESSION['class']="success";
                $_SESSION['msg']="11";
            }
            else{
                $_SESSION['class']="warn";
                $_SESSION['msg']="email_exist";
            }
        }

        header("Location:user_profile.php?user_id=".$user_id);
        exit;
    }

  
 
 function get_auth_info($author_id,$field_name) 
    {
      global $mysqli;

      $qry_cat="SELECT * FROM tbl_author WHERE `author_id`='".$author_id."'";
      $query1=mysqli_query($mysqli,$qry_cat);
      $row_cat = mysqli_fetch_array($query1);

      $num_rows1 = mysqli_num_rows($query1);

      if ($num_rows1 > 0)
      {     
        return $row_cat[$field_name];
      }
      else
      {
        return "";
      }
    } 

    function getLastActiveLog($user_id){
    	global $mysqli;

    	$sql="SELECT * FROM tbl_active_log WHERE `user_id`='$user_id'";
        $res=mysqli_query($mysqli, $sql);

        if(mysqli_num_rows($res) == 0){
        	echo 'no available';
        }
        else{

        	$row=mysqli_fetch_assoc($res);
			return calculate_time_span($row['date_time'],true);	
        }
    }
  function get_cat_info($cat_id,$field_name) 
    {
      global $mysqli;

      $qry_cat="SELECT * FROM tbl_category WHERE cid='".$cat_id."'";
      $query1=mysqli_query($mysqli,$qry_cat);
      $row_cat = mysqli_fetch_array($query1);

      $num_rows1 = mysqli_num_rows($query1);

      if ($num_rows1 > 0)
      {     
        return $row_cat[$field_name];
      }
      else
      {
        return "";
      }
    } 
  
?>

<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip.css">
<style>
#applied_user .dataTables_wrapper .top{
	position: relative;
	width: 100%;
}	
.dataTables_wrapper .top{
	margin-top: -25px;
	padding-right: 15px;
}
</style>
  
<div class="row">
	<div class="col-lg-12">
		<?php
		if(isset($_SERVER['HTTP_REFERER']))
		{
			echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		}
		?>
		<div class="page_title_block user_dashboard_item" style="background-color: #333;border-radius:6px;0 1px 4px 0 rgba(0, 0, 0, 0.14);border-bottom:0">
			<div class="user_dashboard_item">
			  <div class="col-md-12 col-xs-12"> <br>
				<span class="badge badge-success badge-icon">
				  <div class="user_profile_img">
				  	<?php 
		                if($user_row['user_type']=='Google'){
		                  echo '<img src="assets/images/google-logo.png" style="width: 16px;height: 16px;position: absolute;top: 24px;z-index: 1;left: 62px;">';
		                }
		                else if($user_row['user_type']=='Facebook'){
		                  echo '<img src="assets/images/facebook-icon.png" style="width: 16px;height: 16px;position: absolute;top: 24px;z-index: 1;left: 62px;">';
		                }
		              ?>
					<img type="image" src="<?php echo $user_img;?>" alt="image" style=""/>
				  </div>
				  <span style="font-size: 14px;"><?php echo $user_row['name'];?>				
				  </span>
				</span>  
				<span class="badge badge-success badge-icon">
					<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
					<span style="font-size: 14px;text-transform: lowercase;"><?php echo $user_row['email'];?></span>
				</span> 
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;">Registered At:</strong>
				  <span style="font-size: 14px;"><?php echo (date('d-m-Y',$user_row['registration_on']));?></span>
				</span>
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;">Last Activity On:</strong>
				  <span style="font-size: 14px;text-transform: lowercase;"><?php echo getLastActiveLog($user_id)?></span>
				</span>
				<br><br/>
			  </div>
			</div>
		</div>

		  <div class="card card-tab">
			<div class="card-header" style="overflow-x: auto;overflow-y: hidden;">
				<ul class="nav nav-tabs" role="tablist">
		            <li role="dashboard" class="active"><a href="#edit_profile" aria-controls="edit_profile" role="tab" data-toggle="tab">Edit Profile</a></li>
		            <li role="favourite_books"><a href="#favourite_books" aria-controls="favourite_books" role="tab" data-toggle="tab">Favourite Books</a></li>
		            <li role="continue_book"><a href="#continue_book" aria-controls="continue_book" role="tab" data-toggle="tab">Continue Books</a></li>
		        </ul>
			</div>
			<div class="card-body no-padding tab-content">
				<div role="tabpanel" class="tab-pane active" id="edit_profile">
					<div class="row">
						<div class="col-md-12">
							<form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
					          <div class="section">
					            <div class="section-body">
					              <div class="form-group">
					                <label class="col-md-3 control-label">Name :-</label>
					                <div class="col-md-6">
					                  <input type="text" name="name" id="name" value="<?=$user_row['name']?>" class="form-control" required>
					                </div>
					              </div>
					              <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
					                  <div class="form-group"> 
					                    <label class="col-md-3 control-label">Email :-</label>
					                    <div class="col-md-6">
					                      <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
					                    </div>
					                  </div>
					                  <?php }else{?>
					                  	<div class="form-group">
					                    <label class="col-md-3 control-label">Email :-</label>
					                    <div class="col-md-6">
					                      <input type="email" name="email" id="email" readonly="" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
					                    </div>
					                  </div>
					                  	<?php }?>
					                  <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
					                  <div class="form-group">
					                    <label class="col-md-3 control-label">Password :-</label>
					                    <div class="col-md-6">
					                      <input type="password" name="password" id="password" value="" class="form-control" <?php if(!isset($_GET['user_id'])){?>required<?php }?>>
					                    </div>
					                  </div>
					                 <?php }?>
					              <div class="form-group">
					                <label class="col-md-3 control-label">Contact No :-</label>
					                <div class="col-md-6">
					                  <input type="text" name="phone" id="phone" value="<?=$user_row['phone']?>" class="form-control">
					                </div>
					              </div>
				               		<div class="form-group">
					                <label class="col-md-3 control-label">Profile Image :-
					                <p class="control-label-help">(Recommended Resolution: 100x100, 200x200) OR Squre Image</p>
					                </label>
					                <div class="col-md-6">
					                  <div class="fileupload_block">
					                    <input type="file" name="user_profile" value="fileupload" <?php echo (!isset($_GET['user_id'])) ? 'required="require"' : '' ?> id="fileupload" onchange="readURL(this);">
					                    <div class="fileupload_img">
					                    <?php 
					                      $img_src="";
					                      if(!isset($_GET['user_id']) || $user_row['user_profile']==''){
					                          $img_src='assets/images/landscape.jpg';
					                      }else{
					                          $img_src='images/'.$user_row['user_profile'];
					                      }
					                    ?>
					                    <img type="image" id="user_profile" src="<?=$img_src?>" alt="image" id="ImdID" style="width: 100px;height: 100px;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);border-radius: 6px;object-fit: cover;" />
					                    </div>   
					                  </div>
					                </div>
					              </div>
					     			<div class="form-group">
					                <div class="col-md-9 col-md-offset-3">
					                  <button type="submit" name="btn_submit" class="btn btn-primary">Save</button>
					                </div>
					              </div>
					            </div>
					          </div>
					        </form>
						</div>
					  </div>
					</div>
					<div role="tabpanel" class="tab-pane" id="continue_book">
						<div class="row">
							<?php
							  $user_id=$_GET['user_id'];

							  //Favourite list    
							  $tableName="tbl_user_continue";   
							  $targetpage = "user_profile.php";   
							  $limit = 12; 
							  
							  $query = "SELECT COUNT(*) as num FROM $tableName WHERE tbl_user_continue.`user_id` = '$user_id'";
							  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
							  $total_pages = $total_pages['num'];
							  
							  $stages = 1;
							  $page=0;
							  if(isset($_GET['page'])){
							  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
							  }
							  if($page){
								$start = ($page - 1) * $limit; 
							  }else{
								$start = 0; 
							  }

							  $users_qry1="SELECT tbl_user_continue.*,tbl_books.`id`,tbl_books.`book_title`, tbl_books.`book_cover_img`,tbl_books.`cat_id`,tbl_books.`rate_avg`,tbl_books.`book_views`,tbl_books.`aid`,tbl_user_continue.`con_id` FROM tbl_user_continue
							        LEFT JOIN tbl_books ON tbl_user_continue.`book_id` = tbl_books.`id`
							        LEFT JOIN tbl_users ON tbl_user_continue.`user_id`= tbl_books.`id` WHERE tbl_user_continue.`user_id` = '$user_id'
							        GROUP BY tbl_user_continue.`book_id`
							        ORDER BY tbl_user_continue.`con_id` DESC LIMIT $start, $limit";

							$user_result1 = mysqli_query($mysqli,$users_qry1)or die(mysqli_error($mysqli));

							$i=0;
							while ($row_all1=mysqli_fetch_assoc($user_result1)){
							 ?>
							 <div class="col-lg-3 col-sm-4 col-xs-12">
								<div class="block_wallpaper" style="box-shadow:2px 3px 5px #333;">
								  <div class="wall_category_block">
								    <h2><?=ucwords(get_cat_info($row_all1['cat_id'],'category_name'))?></h2>  
								   </div>   
									<div class="wall_image_title">
									<p><?php  if (strlen($row_all1['book_title']) > 40) {
										echo substr(stripslashes($row_all1['book_title']), 0, 40) . '...';
									} else {
										echo $row_all1['book_title'];
									}
									?></p>
									<p style="margin-bottom: 0px">
				                     	By 
				                     	<?=ucwords(get_auth_info($row_all1['aid'],'author_name'))?>
				                    </p>
									<ul>
										<li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row_all1['book_views'];?> Views"><i class="fa fa-eye"></i></a></li>                      
					                    
					                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row_all1['rate_avg'];?> Rating"><i class="fa fa-star"></i></a></li>

					                    <li><a href="" data-id="<?php echo $row_all1['con_id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn_delete_a"><i class="fa fa-trash"></i></a></li>												
									</ul>
								</div>
							<span><img src="images/<?php echo $row_all1['book_cover_img'];?>" /></span>
								</div>
							  </div>
							  <?php
								$i++;
								}
							  ?>
						</div>
					</div>	
					
					<div role="tabpanel" class="tab-pane" id="favourite_books">
						<div class="row">
							<?php
							  $user_id=$_GET['user_id'];

							  //Favourite list    
							  $tableName="tbl_books";   
							  $targetpage = "user_profile.php";   
							  $limit = 12; 
							  
							  $query = "SELECT COUNT(*) as num FROM tbl_favourite WHERE tbl_favourite.`user_id` = '".$user_id."'";
							  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
							  $total_pages = $total_pages['num'];
							  
							  $stages = 1;
							  $page=0;
							  if(isset($_GET['page'])){
							  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
							  }
							  if($page){
								$start = ($page - 1) * $limit; 
							  }else{
								$start = 0; 
							  }

							 $users_qry="SELECT * FROM tbl_favourite
										 LEFT JOIN tbl_users ON tbl_favourite.`user_id`= tbl_users.`id`
										 LEFT JOIN tbl_books ON tbl_favourite.`book_id`= tbl_books.`id`
										 WHERE tbl_favourite.`user_id` = '$user_id'
										 ORDER BY tbl_favourite.`fa_id` DESC LIMIT $start, $limit";

							$user_result = mysqli_query($mysqli,$users_qry)or die(mysqli_error($mysqli));

							$i=0;
							while ($row_all=mysqli_fetch_assoc($user_result)){
							 ?>
							 <div class="col-lg-3 col-sm-4 col-xs-12">
								<div class="block_wallpaper" style="box-shadow:2px 3px 5px #333;">
								  <div class="wall_category_block">
								     <h2><?=ucwords(get_cat_info($row_all['cat_id'],'category_name'))?></h2>  
								   </div>   
									<div class="wall_image_title">
									<p><?php  if (strlen($row_all['book_title']) > 40) {
										echo substr(stripslashes($row_all['book_title']), 0, 40) . '...';
									} else {
										echo $row_all['book_title'];
									}
									?></p>
									<p style="margin-bottom: 0px">
				                     	By 
				                     	<?=ucwords(get_auth_info($row_all['aid'],'author_name'))?>
				                    </p>
									<ul>
										<li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row_all['book_views'];?> Views"><i class="fa fa-eye"></i></a></li>                      
					                    
					                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row_all['rate_avg'];?> Rating"><i class="fa fa-star"></i></a></li>
					 
					                    <li><a href="edit_book.php?book_id=<?php echo $row_all['id'];?>&action=edit&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>														
									</ul>
								</div>
							<span><img src="images/<?php echo $row_all['book_cover_img'];?>" /></span>
								</div>
							  </div>
							  <?php
								$i++;
								}
							  ?>
						</div>
					</div>	
												 
				</div>
			</div>
		</div>
	</div>

<?php include('includes/footer.php');?>

<script type="text/javascript">

 $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=APP_NAME?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#user_profile').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }


$(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids=$(this).data("id");
    
        confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
        init: true,
        dark: false, 
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
            $.ajax({
              type:'post',
              url:'processdata.php',
              dataType:'json',
              data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_user_continue'},
              success:function(res){
                location.reload();
              }
            });

          } 
        }
      });
      confirmDlg.show();
    });

</script>


