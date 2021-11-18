<?php if(isset($_GET['cat_id'])){ 
		$page_title= 'Edit Category';
	}
	else{ 
		$page_title='Add Category'; 
	}
	$current_page="category";
  	$active_page="books";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");
  
  if(isset($_POST['submit']) and isset($_GET['add']))
  {
  
       $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
       
       //Main Image
       $tpath1='images/'.$category_image;        
       $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
   
       //Thumb Image 
       $thumbpath='images/thumbs/'.$category_image;   
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');   
          
       $data = array( 
          'category_name'  =>  cleanInput($_POST['category_name']),
          'category_image'  =>  $category_image
      );    

    $qry = Insert('tbl_category',$data);  
 
    $_SESSION['msg']="10";
    header( "Location:manage_category.php");
    exit; 
    
  }
  
  if(isset($_GET['cat_id']))
  {
       
      $qry="SELECT * FROM tbl_category WHERE tbl_category.`cid` ='".$_GET['cat_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);

  }

if(isset($_POST['submit']) and isset($_POST['cat_id']))
  {
     
     if($_FILES['category_image']['name']!="")
     {    
      
          if($row['category_image']!="")
            {
              unlink('images/thumbs/'.$row['category_image']);
              unlink('images/'.$row['category_image']);
           }

           $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
       
           //Main Image
           $tpath1='images/'.$category_image;        
           $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
         
           //Thumb Image 
           $thumbpath='images/thumbs/'.$category_image;   
           $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');

            $data = array(
              'category_name'  =>  cleanInput($_POST['category_name']),
              'category_image'  =>  $category_image
            );

           $category_edit=Update('tbl_category', $data, "WHERE `cid` = '".$_POST['cat_id']."'");
     }
     else
     {
           $data = array(
                'category_name'  =>  cleanInput($_POST['category_name'])
            );  
 
           $category_edit=Update('tbl_category', $data, "WHERE `cid` = '".$_POST['cat_id']."'");
     }
 
    $_SESSION['msg']="11"; 
    header( "Location:add_category.php?cat_id=".$_POST['cat_id']);
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
	            echo '<a href="manage_category.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          } ?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Category Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
	                <label class="col-md-3 control-label">Select Image :-
	                  <p class="control-label-help">(Recommended Resolution: 300x300,400x400 or Square Image)</p></label>
	                <div class="col-md-6">
	                  <div class="fileupload_block">
	                    <input type="file" name="category_image" value="" id="fileupload">
	                    <div class="fileupload_img featured_image">
	                      <?php if ($row['category_image'] != "") { ?>
	                        <img type="image" src="images/<?= $row['category_image'] ?>" alt="Featured image" id="ImdID" style="width: 100px;height: 100px;"/>
	                      <?php } else { ?>
	                        <img id="ImdID" type="image" src="assets/images/square-img.jpg" alt="Featured image" style="width: 100px;height: 100px;"/>
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
    $("input[name='category_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
}
}
$("input[name='category_image']").change(function() { 
readURL(this);
});

</script> 