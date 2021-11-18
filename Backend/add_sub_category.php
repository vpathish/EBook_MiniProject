<?php  if(isset($_GET['cat_id'])){ 
	$page_title= 'Edit Sub-Category';
}
else{ 
	$page_title='Add Sub-Category'; 
}

$current_page="sub-category";
$active_page="books";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
$cat_result=mysqli_query($mysqli,$cat_qry);  

if(isset($_POST['submit']) and isset($_GET['add']))
{
	
	$sub_cat_image=rand(0,99999)."_".$_FILES['sub_cat_image']['name'];
	
       //Main Image
	$tpath1='images/'.$sub_cat_image;        
	$pic1=compress_image($_FILES["sub_cat_image"]["tmp_name"], $tpath1, 80);
	
   	 	//Thumb Image 
	$thumbpath='images/thumbs/'.$sub_cat_image;   
	$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');   
	
	$data = array( 
		'cat_id'  =>  $_POST['cat_id'],
		'sub_cat_name'  =>  $_POST['sub_cat_name'],
		'sub_cat_image'  =>  $sub_cat_image
	);		

	$qry = Insert('tbl_sub_category',$data);	

	$_SESSION['msg']="10";
	header( "Location:manage_sub_category.php");
	exit;	
}

if(isset($_GET['sub_cat_id']))
{
	
	$qry="SELECT * FROM tbl_sub_category WHERE `sid`='".$_GET['sub_cat_id']."'";
	$result=mysqli_query($mysqli,$qry);
	$row=mysqli_fetch_assoc($result);

}
if(isset($_POST['submit']) and isset($_POST['sub_cat_id']))
{
	
	if($_FILES['sub_cat_image']['name']!="")
	{		
		
		if($row['sub_cat_image']!="")
		{
			unlink('images/'.$row['sub_cat_image']);
			unlink('images/thumbs/'.$row['sub_cat_image']);
		}

		$sub_cat_image=rand(0,99999)."_".$_FILES['sub_cat_image']['name'];
		
		       //Main Image
		$tpath1='images/'.$sub_cat_image;        
		$pic1=compress_image($_FILES["sub_cat_image"]["tmp_name"], $tpath1, 80);
		
		   	 	//Thumb Image 
		$thumbpath='images/thumbs/'.$sub_cat_image;   
		$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');   
		
		$data = array(
			'cat_id'  =>  $_POST['cat_id'],
			'sub_cat_name'  =>  $_POST['sub_cat_name'],
			'sub_cat_image'  =>  $sub_cat_image
		);

		$category_edit=Update('tbl_sub_category', $data, "WHERE sid = '".$_POST['sub_cat_id']."'");
	}
	else
	{
		$data = array(
			'cat_id'  =>  $_POST['cat_id'],
			'sub_cat_name'  =>  $_POST['sub_cat_name']
		);	

		$category_edit=Update('tbl_sub_category', $data, "WHERE sid = '".$_POST['sub_cat_id']."'");
	}
	
	$_SESSION['msg']="11"; 
	header( "Location:add_sub_category.php?sub_cat_id=".$_POST['sub_cat_id']);
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
	            echo '<a href="manage_sub_category.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
            	<input  type="hidden" name="sub_cat_id" value="<?php echo $_GET['sub_cat_id'];?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Sub Category Name :-
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="sub_cat_name" id="sub_cat_name" value="<?php if(isset($_GET['sub_cat_id'])){echo $row['sub_cat_name'];}?>" class="form-control" required>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
							<?php
								while($cat_row=mysqli_fetch_array($cat_result))
								{?>          						 
							<option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>	          							 
							<?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
	                <label class="col-md-3 control-label">Select Image :-
	                  <p class="control-label-help">(Recommended Resolution: 450 x 250 or Square Image)</p></label>
	                <div class="col-md-6">
	                  <div class="fileupload_block">
	                    <input type="file" name="sub_cat_image" value="" id="fileupload">
	                    <div class="fileupload_img featured_image">
	                      <?php if ($row['sub_cat_image'] != "") { ?>
	                        <img type="image" src="images/<?= $row['sub_cat_image'] ?>" alt="Featured image" id="ImdID" style="width: 160px;height: 90px;"/>
	                      <?php } else { ?>
	                        <img id="ImdID" type="image" src="assets/images/square-img.jpg" alt="Featured image" style="width: 160px;height: 90px;"/>
	                      <?php } ?>
	                    </div>
	                  </div>
	                </div>                 
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>  

<script type="text/javascript">

function readURL(input) {
if (input.files && input.files[0]) {
  var reader = new FileReader();
  
  reader.onload = function(e) {
    $("input[name='sub_cat_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
}
}
$("input[name='sub_cat_image']").change(function() { 
readURL(this);
});

</script> 