<?php if(isset($_GET['author_id'])){ 
		$page_title= 'Edit Author';
	}
	else{ 
		$page_title='Add Author'; 
	}
	$current_page="author";
  	$active_page="books";

include("includes/header.php");
require("includes/function.php");
require("language/language.php");

	require_once("thumbnail_images.class.php");

if(isset($_POST['submit']) and isset($_GET['add']))
	{  
      $file_name= str_replace(" ","-",$_FILES['author_image']['name']);

       $author_image=rand(0,99999)."_".$file_name;
         
       //Main Image
       $tpath1='images/'.$author_image;        
       $pic1=compress_image($_FILES["author_image"]["tmp_name"], $tpath1, 80);
     
       //Thumb Image 
       $thumbpath='images/thumbs/'.$author_image;   
       $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','300');

	 
        $data = array( 
			    'author_name'  =>  addslashes($_POST['author_name']),
			    'author_city_name'  => $_POST['author_city_name'],
			    'author_description'  =>  addslashes($_POST['author_description']),
			    'author_instagram'  =>  $_POST['author_instagram'],
		        'author_facebook'  =>  $_POST['author_facebook'],
		        'author_website'  =>  $_POST['author_website'],
		        'author_youtube'  =>  $_POST['author_youtube'],
                'author_image'  =>  $author_image
			);		

 		$qry = Insert('tbl_author',$data);			

		$_SESSION['msg']="10";
		header( "Location:add_author.php?add=yes");
		exit;	
		
	}
	
if(isset($_GET['author_id']))
	{
			 
	$qry="SELECT * FROM tbl_author WHERE author_id='".$_GET['author_id']."'";
	$result=mysqli_query($mysqli,$qry);
	$row=mysqli_fetch_assoc($result);

}
	
if(isset($_POST['submit']) and isset($_POST['author_id']))
	{    

      if($_FILES['author_image']['name']!="")
    	 {

          if($row['author_image']!="")
            {
              unlink('images/thumbs/'.$row['author_image']);
              unlink('images/'.$row['author_image']);
           }
         
         $file_name= str_replace(" ","-",$_FILES['author_image']['name']);

         $author_image=rand(0,99999)."_".$file_name;
           
         //Main Image
         $tpath1='images/'.$author_image;        
         $pic1=compress_image($_FILES["author_image"]["tmp_name"], $tpath1, 80);
       
         //Thumb Image 
         $thumbpath='images/thumbs/'.$author_image;   
         $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','300');

     
          $data = array( 
          		    'author_name'  =>  cleanInput($_POST['author_name']),
					'author_city_name'  => cleanInput($_POST['author_city_name']),
					'author_description'  =>  addslashes($_POST['author_description']), 
					'author_instagram'  =>  $_POST['author_instagram'],
		            'author_facebook'  =>  $_POST['author_facebook'],
		            'author_website'  =>  $_POST['author_website'],
		            'author_youtube'  =>  $_POST['author_youtube'],          
					'author_image'  =>  $author_image
            );    
     }
     else
     {
        $data = array(
            'author_name'  =>  cleanInput($_POST['author_name']),
			'author_city_name'  => cleanInput($_POST['author_city_name']),
		    'author_description'  =>  addslashes($_POST['author_description']),
		    'author_instagram'  =>  $_POST['author_instagram'],
	        'author_facebook'  =>  $_POST['author_facebook'],
	        'author_website'  =>  $_POST['author_website'],
	        'author_youtube'  =>  $_POST['author_youtube']
        );
    	
   	}
		  
        $author_edit=Update('tbl_author', $data, "WHERE tbl_author.`author_id` = '".$_POST['author_id']."'");

		$_SESSION['msg']="11";
	     if(isset($_GET['redirect'])){
	      header("Location:".$_GET['redirect']);
	    }
	    else{
		header( "Location:add_author.php?author_id=".$_POST['author_id']);
	    }
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
	            echo '<a href="manage_author.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
	          }?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="" method="post" class="form form-horizontal" enctype="multipart/form-data">
            	<input  type="hidden" name="author_id" value="<?php echo $_GET['author_id'];?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Author Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_name" id="author_name" value="<?php if(isset($_GET['author_id'])){echo $row['author_name'];}?>" class="form-control" required>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-md-3 control-label">City Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_city_name" id="author_city_name" value="<?php if(isset($_GET['author_id'])){echo $row['author_city_name'];}?>" class="form-control" required>
                    </div>
                  </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Author Description :-</label>
                    <div class="col-md-6">
                      <textarea rows="5" name="author_description" id="author_description" class="form-control"><?php echo stripslashes($row['author_description']);?></textarea>
                    </div>
                  </div>                             
                   <br>                        
                  <div class="form-group">
	                <label class="col-md-3 control-label">Author Image :- <p class="control-label-help">(Recommended Resolution: 300x300, 400x400 or 500x500)</p></label>
	                <div class="col-md-6">
	                  <div class="fileupload_block">
	                    <input type="file" name="author_image" value="" id="fileupload">
	                    <div class="fileupload_img featured_image">
	                     <?php if(isset($_GET['author_id']) and $row['author_image']!="") {?>
	                        <img type="image" src="images/<?= $row['author_image'] ?>" alt="Featured image" id="ImdID" style="width: 100px;height: 100px;"/>
	                      <?php } else { ?>
	                        <img id="ImdID" type="image" src="assets/images/square-img.jpg" alt="Featured image" style="width: 100px;height: 100px;"/>
	                      <?php } ?>
	                    </div>
	                  </div>
	                </div>
                 	</div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">YouTube URL :-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_youtube" id="author_youtube" value="<?php if(isset($_GET['author_id'])){echo $row['author_youtube'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Instagram URL:-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_instagram" id="author_instagram" value="<?php if(isset($_GET['author_id'])){echo $row['author_instagram'];}?>" class="form-control">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Facebook URL :-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_facebook" id="author_facebook" value="<?php if(isset($_GET['author_id'])){echo $row['author_facebook'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Website URL:-</label>
                    <div class="col-md-6">
                      <input type="text" name="author_website" id="author_website" value="<?php if(isset($_GET['author_id'])){echo $row['author_website'];}?>" class="form-control">
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
        
<?php include("includes/footer.php");?>      

<script type="text/javascript">

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='author_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='author_image']").change(function() { 
    readURL(this);
  });

</script> 