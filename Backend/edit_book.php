<?php  $page_title="Edit Books";
$current_page="Books";
$active_page="books";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

$file_path = getBaseUrl();

	//All Category
$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
$cat_result=mysqli_query($mysqli,$cat_qry);

$author_qry="SELECT * FROM tbl_author ORDER BY author_name";
$author_result=mysqli_query($mysqli,$author_qry);

if(isset($_GET['book_id']))
{

	$qry="SELECT * FROM tbl_books WHERE id='".$_GET['book_id']."'";
	$result=mysqli_query($mysqli,$qry);
	$row=mysqli_fetch_assoc($result);

      //Get Sub Category 
	$sub_cat_qry="SELECT * FROM tbl_sub_category WHERE sid='".$row['sub_cat_id']."'";
	$sub_cat_result=mysqli_query($mysqli,$sub_cat_qry);

}

$book_file=$row['book_file_url'];

if($row['book_file_type']=='local'){

	$book_file=$file_path.'uploads/'.basename($row['book_file_url']);
}

if(isset($_POST['submit']))
{  

	if ($_POST['book_file_type']=='server_url')
	{
		$book_file_url=$_POST['book_file_server_url'];

		if($row['book_file_type']=='local'){

			unlink('uploads/'.basename($row['book_file_url']));
		}
	} 
	else{

		if($_FILES['book_file_local']['name']!="")
		{

			$path = "uploads/"; 
			$book_file_local=rand(0,99999)."_".str_replace(" ", "-", $_FILES['book_file_local']['name']);

			$tmp = $_FILES['book_file_local']['tmp_name'];              
			move_uploaded_file($tmp, $path.$book_file_local);

			$book_file_url=$book_file_local;

		}
		else
		{	
			if($row['book_file_type']=='server_url'){

				   $_SESSION['msg']="book_required";
				   $_SESSION['class']='error';
			       if(isset($_GET['redirect'])){
			      	header( "Location:edit_book.php?book_id=".$_POST['book_id']."&action=edit&".$_GET['redirect']);
			      }
			      else{
			      	header( "Location:edit_book.php?book_id=".$_POST['book_id']."&action=edit");
			      }
			      exit;
			}

			$book_file_url= $_POST['book_file_local_old'];
		}

      }

      if($_FILES['book_bg_img']['name']!="")
      {		
      	if($row['book_bg_img']!="")
      	{
      		unlink('images/thumbs/'.$row['book_bg_img']);
      		unlink('images/'.$row['book_bg_img']);
      	}

      	$file_name2= str_replace(" ","-",$_FILES['book_bg_img']['name']);

      	$book_bg_img=rand(0,99999)."_".$file_name2;

         //Main Image
      	$tpath2='images/'.$book_bg_img;        
      	$pic2=compress_image($_FILES["book_bg_img"]["tmp_name"], $tpath2, 80);

      }
      else
      {
      	$book_bg_img=$_POST['book_bg_img_hidden'];
      }    

      if($_FILES['book_cover_img']['name']!="")
      {

      	if($row['book_cover_img']!="")
      	{
      		unlink('images/thumbs/'.$row['book_cover_img']);
      		unlink('images/'.$row['book_cover_img']);
      	}

      	$file_name= str_replace(" ","-",$_FILES['book_cover_img']['name']);

      	$book_cover_img=rand(0,99999)."_".$file_name;

           //Main Image
      	$tpath1='images/'.$book_cover_img;        
      	$pic1=compress_image($_FILES["book_cover_img"]["tmp_name"], $tpath1, 80);

           //Thumb Image 
      	$thumbpath='images/thumbs/'.$book_cover_img;   
      	$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'250','350');   

      	$data = array( 
      		'cat_id'  =>  $_POST['cat_id'],
      		'sub_cat_id'  =>  $_POST['sub_cat_id'],
      		'aid'  =>  $_POST['aid'],
      		'book_title'  =>  addslashes($_POST['book_title']),
      		'book_description'  =>  addslashes($_POST['book_description']),         
      		'book_cover_img'  =>  $book_cover_img,
      		'book_bg_img'  =>  $book_bg_img,
      		'book_file_type'  =>  $_POST['book_file_type'],
      		'book_file_url'  =>  $book_file_url
      	);    

      }
      else
      {
      	$data = array( 
      		'cat_id'  =>  $_POST['cat_id'],
      		'sub_cat_id'  =>  $_POST['sub_cat_id'],
      		'aid'  =>  $_POST['aid'],
      		'book_title'  =>  addslashes($_POST['book_title']),
      		'book_description'  =>  addslashes($_POST['book_description']),
      		'book_file_type'  =>  $_POST['book_file_type'],
      		'book_file_url'  =>  $book_file_url,
      		'book_bg_img'  =>  $book_bg_img     
      	);  
      }   

      $book_edit=Update('tbl_books', $data, "WHERE id = '".$_POST['book_id']."'");

      $_SESSION['msg']="11";
      if(isset($_GET['redirect'])){
      	header("Location:".$_GET['redirect']);
      }
      else{
      	header( "Location:edit_book.php?book_id=".$_POST['book_id']."&action=edit");
      }
      exit;

  }

  $ck_file_path = getBaseUrl();

  ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript">
  	$(document).ready(function(e) {
  		$("#book_file_type").change(function(){

  			var type=$("#book_file_type").val();

  			if(type=="server_url")
  			{
  				$("#book_url_display").show();
  				$("#book_local_display").hide();
  				$("#book_local").hide();
  			}
  			else
  			{   
  				$("#book_url_display").hide();               
  				$("#book_local_display").show();
  				$("#book_local").show();
  			}    
  		});
  	});

  	function fileValidation(fileInput){

  		var fileInput = document.getElementById('fileupload');
  		var filePath = fileInput.value;
  		var allowedExtensions = /(\.pdf|.epub)$/i;
  		if(!allowedExtensions.exec(filePath)){
  			alert('Please Select file having extension .pdf, .epub only.');
  			fileInput.value = '';
  			return false;	
  		}else{
  			return true;
  		}
  	}

  </script>

  <div class="row">
  	<div class="col-md-12">
  		<?php
  		if(isset($_GET['redirect'])){
  			echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
  		}
  		else{
  			echo '<a href="manage_books.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
  					<input  type="hidden" name="book_id" value="<?php echo $_GET['book_id'];?>" />
  					<div class="section">
  						<div class="section-body">                 
  							<div class="form-group">
  								<label class="col-md-3 control-label">Book Title :-</label>
  								<div class="col-md-6">
  									<input type="text" name="book_title" id="book_title" value="<?php echo stripslashes($row['book_title']);?>" class="form-control" required>
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
  									<label class="col-md-3 control-label">Sub Category :-</label>
  									<div class="col-md-6">
  										<select name="sub_cat_id" id="sub_cat_id" class="select2">
  											<option value="">--Select Sub Category--</option>
  											<?php
  											while($sub_cat_row=mysqli_fetch_array($sub_cat_result))
  												{?>
  													<option value="<?php echo $sub_cat_row['sid'];?>" <?php if($sub_cat_row['sid']==$row['sub_cat_id']){?> selected<?php }?>><?php echo $sub_cat_row['sub_cat_name'];?></option>

  												<?php }?>
  											</select>
  										</div>
  									</div>
  									<div class="form-group">
  										<label class="col-md-3 control-label">Author :-</label>
  										<div class="col-md-6">
  											<select name="aid" id="aid" class="select2" required>
  												<option value="">--Select Author--</option>
  												<?php
  												while($author_row=mysqli_fetch_array($author_result))
  													{?>                       
  														<option value="<?php echo $author_row['author_id'];?>" <?php if($author_row['author_id']==$row['aid']){?>selected<?php }?>><?php echo $author_row['author_name'];?></option>                           
  													<?php } ?>
  												</select>
  											</div>
  										</div>
  										<div class="form-group">
  											<label class="col-md-3 control-label">Book Description :-</label>
  											<div class="col-md-6">

  												<textarea name="book_description" id="book_description" class="form-control"><?php echo stripslashes($row['book_description']);?></textarea>
  												<script>
  													var roxyFileman = '<?php echo $ck_file_path;?>/fileman/index.html?integration=ckeditor';
  													$(function(){
  														CKEDITOR.replace( 'book_description',{filebrowserBrowseUrl:roxyFileman, 
  															filebrowserImageBrowseUrl:roxyFileman+'&type=image',
  															removeDialogTabs: 'link:upload;image:upload'});
  													});
  												</script>
  											</div>
  										</div>                  
  										<div class="form-group">&nbsp;</div>
  										<div class="form-group">
  											<label class="col-md-3 control-label">Book Image :-
  												<p class="control-label-help">(Recommended Resolution: 300x500, 300x550 or 500x800)</p></label>
  												<div class="col-md-6">
  													<div class="fileupload_block">
  														<input type="file" name="book_cover_img" value="fileupload" onchange="readURL(this)" id="fileupload">
  														<?php if(isset($_GET['book_id']) AND $row['book_cover_img']!="") {?>

  															<div class="fileupload_img"><img id="book_cover_img" type="image" src="images/<?php echo $row['book_cover_img'];?>" alt="video thumbnail" style="width: 110px;height: 150px" /></div>
  														<?php } else {?>

  															<div class="fileupload_img"><img id="book_cover_img" type="image" src="assets/images/portrait.jpg" alt="recipe image" style="width: 110px;height: 150px" /></div>
  														<?php }?>
  													</div>
  												</div>
  											</div>
  											<div  class="form-group">
  												<label class="col-md-3 control-label">Book Background Image :-
  													<p class="control-label-help">(Recommended Resolution: 590x300, 600x300)</p>
  												</label>
  												<div class="col-md-6">
  													<div class="fileupload_block">
  														<input type="file" name="book_bg_img" value="fileupload" onchange="readURL1(this)" id="fileupload">
  														<input type="hidden" name="book_bg_img_hidden" id="book_bg_img_hidden" value="<?php echo $row['book_bg_img'];?>">

  														<?php if(isset($_GET['book_id']) AND $row['book_bg_img']!="") {?>

  															<div class="fileupload_img"><img id="book_bg_img" type="image" src="images/<?php echo $row['book_bg_img'];?>" alt="video thumbnail" style="width: 170px;height: 90px" /></div>
  														<?php } else {?>

  															<div class="fileupload_img"><img id="book_bg_img" type="image" src="assets/images/portrait.jpg" alt="recipe image" style="width: 170px;height: 90px" /></div>
  														<?php }?>
  													</div>
  												</div>
  											</div>
  											<div class="form-group">
  												<label class="col-md-3 control-label">Book Upload Type :- </label>
  												<div class="col-md-6">                       
  													<select name="book_file_type" id="book_file_type" style="width:280px; height:25px;" class="select2" required>
  														<option value="">--Select Type--</option>
  														<option value="server_url" <?php if($row['book_file_type']=='server_url'){?>selected<?php }?>>Server URL</option>
  														<option value="local" <?php if($row['book_file_type']=='local'){?>selected<?php }?>>Browse From Syatem</option>
  													</select>
  												</div>
  											</div>
  											<div id="book_url_display" class="form-group" <?php if($row['book_file_type']=='local'){?>style="display:none;"<?php }else{?>style="display:block;"<?php }?>>
  												<label class="col-md-3 control-label">Live URL :- <p style="color:red" class="control-label-help">(Note : Live URL .pdf and .epub)</p></label>
  												<div class="col-md-6">
  													<input type="text" name="book_file_server_url" id="book_file_server_url" value="<?php echo $row['book_file_url']?>" class="form-control">
  												</div>
  											</div>
  											<div id="book_local_display" class="form-group" <?php if($row['book_file_type']=='local'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
  												<label class="col-md-3 control-label">Browse Book :- <p style="color:red" class="control-label-help">(Note : Uploads .pdf and .epub)</p></label>
  												<div class="col-md-6">
  													<div class="fileupload_block">
  														<input type="hidden" name="book_file_local_old" value="<?php echo $row['book_file_url']?>">
  														<input type="file" name="book_file_local" value="fileupload" id="fileupload" onchange="ValidateSingleInput(this);">

  													</div>
  												</div>
  											</div>
  											<div id="book_local" class="form-group" <?php if($row['book_file_type']=='local'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
  												<label class="col-md-3 control-label">&nbsp;</label>
  												<div class="col-md-6">
  													<div><label class="control-label">Current URL :-</label> <?php echo $file_path.'uploads/'.basename($row['book_file_url'])?>
  												</div><br> 
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

  				function readURL1(input) {
  					if (input.files && input.files[0]) {
  						var reader = new FileReader();

  						reader.onload = function(e) {
  							$('#book_bg_img').attr('src', e.target.result);
  						}

  						reader.readAsDataURL(input.files[0]);
  					}
  				}

  				function readURL(input) {
  					if (input.files && input.files[0]) {
  						var reader = new FileReader();

  						reader.onload = function(e) {
  							$("input[name='book_cover_img']").next(".fileupload_img").find("img").attr('src', e.target.result);
  						}
  						reader.readAsDataURL(input.files[0]);
  					}
  				}
  				$("input[name='book_cover_img']").change(function() { 
  					readURL(this);
  				});

  				var _validFileExtensions = [".pdf", ".epub"];   

  				function ValidateSingleInput(oInput) {
  					if (oInput.type == "file") {
  						var sFileName = oInput.value;
  						if (sFileName.length > 0) {
  							var blnValid = false;
  							for (var j = 0; j < _validFileExtensions.length; j++) {
  								var sCurExtension = _validFileExtensions[j];
  								if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
  									blnValid = true;
  									break;
  								}
  							}

  							if (!blnValid) {
  								alert("Sorry, is invalid extensions, allowed extensions are .pdf .epub");
  								oInput.value = "";
  								return false;
  							}
  						}
  					}
  					return true;
  				}

// getting sub categories
$("select[name='cat_id']").on("change",function(e){

	var _cat_id=$(this).val();

	$.ajax({
		type:'post',
		url:'processdata.php',
		data:{cat_id:_cat_id,'action':'sub_category'},
		success:function(data){
			$("select[name='sub_cat_id']").html(data);
		}
	});
});
</script>