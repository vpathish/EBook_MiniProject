<?php $page_title=(isset($_GET['user_id'])) ? 'Edit User' : 'Add User'; 

include('includes/header.php');
include('includes/function.php');
include('language/language.php'); 

require_once("thumbnail_images.class.php");
	 
if(isset($_POST['submit']) and isset($_GET['add']))
	{		
    if($_FILES['user_profile']['name']!="")
      {
       
       $user_profile=rand(0,99999)."_".$_FILES['user_profile']['name'];
         
       //Main Image
       $tpath1='images/'.$user_profile;        
       $pic1=compress_image($_FILES["user_profile"]["tmp_name"], $tpath1, 80);

       $data = array(
       	'user_type'=>'Normal',	
        'name'  =>  $_POST['name'],
        'email'  =>  $_POST['email'],
		'password'  =>  md5(trim($_POST['password'])),
        'phone'  =>  $_POST['phone'],
        'user_profile' => $user_profile,
        'registration_on'  =>  strtotime(date('d-m-Y h:i:s A'))
      );
       
    }
    else
    {
       $data = array(
       	'user_type'=>'Normal',	
        'name'  =>  $_POST['name'],
        'email'  =>  $_POST['email'],
        'password'  =>  md5(trim($_POST['password'])),
        'phone'  =>  $_POST['phone'],
        'registration_on'  =>  strtotime(date('d-m-Y h:i:s A'))
      );
    } 
 
		$qry = Insert('tbl_users',$data);

		$_SESSION['msg']="10";
		header("location:manage_users.php");	 
		exit;
	
	}
	
	if(isset($_GET['user_id']))
	{
			 
		$user_qry="SELECT * FROM tbl_users WHERE `id`='".$_GET['user_id']."'";
		$user_result=mysqli_query($mysqli,$user_qry);
		$user_row=mysqli_fetch_assoc($user_result);
		
	}
	
if(isset($_POST['submit']) and isset($_POST['user_id']))
	{ 

      if($_FILES['user_profile']['name']!="")
      {	
	      	if($user_row['user_profile']!="")
	        {
	            unlink('images/'.$user_row['user_profile']);
	        }

          $user_profile=rand(0,99999)."_".$_FILES['user_profile']['name'];

          //Main Image
          $tpath1='images/'.$user_profile;        
          $pic1=compress_image($_FILES["user_profile"]["tmp_name"], $tpath1, 80);

      }
      else
      {
        $user_profile=$_POST['old_user_profile'];
      }  

      if($_POST['password']!="")
       {
          $data = array(
              'name'  =>  $_POST['name'],
              'email'  =>  $_POST['email'],
              'password'  =>  md5(trim($_POST['password'])),
              'phone'  =>  $_POST['phone'],
              'user_profile' => $user_profile
          );
      }
      else
      {
          $data = array(
              'name'  =>  $_POST['name'],
              'email'  =>  $_POST['email'],			 
              'phone'  =>  $_POST['phone'],
              'user_profile' => $user_profile 
         );
      }

      $user_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['user_id']."'");

      $_SESSION['msg']="11";
      if(isset($_GET['page']))
        header( "Location:manage_users.php?page=".$_GET['page']);
      else
        header( "Location:manage_users.php");
      exit;
		
	}
	
?>
 <div class="row">
      <div class="col-md-12">
      	<?php
		      if(isset($_GET['redirect'])){
		            echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		          }
		          else{
		            echo '<a href="manage_users.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		          }
		    ?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addedituser" method="post" class="form form-horizontal" enctype="multipart/form-data" >
            	<input  type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>" />

              <div class="section">
                <div class="section-body">                   
                  <div class="form-group">
                    <label class="col-md-3 control-label">Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['user_id'])){echo $user_row['name'];}?>" class="form-control" required>
                    </div>
                  </div>
                 <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
                  <div class="form-group"> 
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <?php }else {?>
                  	<div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="email" name="email" id="email" readonly="" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                    </div>
                  </div>
                  	<?php } ?>
                  <?php if (!isset($_GET['user_id']) OR ($user_row['user_type']) == 'Normal') { ?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Password :-</label>
                    <div class="col-md-6">
                      <input type="password" name="password" id="password" value="" class="form-control" <?php if(!isset($_GET['user_id'])){?>required<?php }?>>
                    </div>
                  </div>
                 <?php } ?>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Phone :-</label>
                    <div class="col-md-6">
                      <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['user_id'])){echo $user_row['phone'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">User Image :- <p class="control-label-help">(Recommended resolution: 100x100, 200x200) OR Squre image</p> 
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="user_profile" value="" id="fileupload" onchange="readURL(this)">
                            <?php if(isset($_GET['user_id']) and $user_row['user_profile']!="") {?>
                            <input type="hidden" name="old_user_profile" value="<?php echo $user_row['user_profile'];?>" id="fileupload">
                            <div class="fileupload_img"><img type="image" id="user_profile" src="images/<?php echo $user_row['user_profile'];?>" style="width: 90px;height: 90px" alt=" image" /></div>
                          <?php } else { ?>
                            <div class="fileupload_img"><img type="image" id="user_profile" src="assets/images/landscape.jpg" style="width: 90px;height: 90px" alt="category image" /></div>
                          <?php } ?>
                      </div>
                    </div>
                  </div>
                    
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
   

<?php include('includes/footer.php');?>                  

<script type="text/javascript">

function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function(e) {
    $('#user_profile').attr('src', e.target.result);
  }

  reader.readAsDataURL(input.files[0]);
}
}
</script>  