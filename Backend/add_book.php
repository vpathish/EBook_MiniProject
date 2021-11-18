<?php  $page_title="Add Book";
$current_page="Books";
$active_page="books";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

//All Category
$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
$cat_result=mysqli_query($mysqli,$cat_qry);

$author_qry="SELECT * FROM tbl_author ORDER BY author_name";
$author_result=mysqli_query($mysqli,$author_qry);

if(isset($_POST['submit']))
{

	$file_name= str_replace(" ","-",$_FILES['book_cover_img']['name']);

	$book_cover_img=rand(0,99999)."_".$file_name;

    //Main Image
	$tpath1='images/'.$book_cover_img; 			 
	$pic1=compress_image($_FILES["book_cover_img"]["tmp_name"], $tpath1, 80);

	//Thumb Image 
	$thumbpath='images/thumbs/'.$book_cover_img;		
	$thumb_pic1=create_thumb_image($tpath1,$thumbpath,'250','350');

	if($_FILES['book_bg_img']['name']!="")
	{
		$file_name2= str_replace(" ","-",$_FILES['book_bg_img']['name']);

		$book_bg_img=rand(0,99999)."_".$file_name2;

        //Main Image
		$tpath2='images/'.$book_bg_img;        
		$pic2=compress_image($_FILES["book_bg_img"]["tmp_name"], $tpath2, 80);
	}
	else
	{
		$book_bg_img='';
	}

	if ($_POST['book_file_type']=='server_url')
	{
		$book_file_url=$_POST['book_file_server_url'];
	} 

	if ($_POST['book_file_type']=='local')
	{
		$path = "uploads/"; 
		$book_file_local=rand(0,99999)."_".str_replace(" ", "-", $_FILES['book_file_local']['name']);

		$tmp = $_FILES['book_file_local']['tmp_name'];              
		move_uploaded_file($tmp, $path.$book_file_local);

		$book_file_url=$book_file_local;

	}

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

	$qry = Insert('tbl_books',$data);	

	$_SESSION['msg']="10";
	header( "Location:add_book.php");
	exit;	
}

$ck_file_path = getBaseUrl();

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$("#book_file_type").change(function(){

			var type=$("#book_file_type").val();

			if(type=="server_url")
			{
				$("#book_url_display").show();
				$("#book_local_display").hide();
			}
			else 
			{   
				$("#book_url_display").hide();               
				$("#book_local_display").show();
			}    
		});
	});

</script>

<div class="row">
	<div class="col-md-12">
		<?php
		if(isset($_GET['redirect'])){
			echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		}
		else{
			echo '<a href="manage_books.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
		}?>
		<div class="card">
			<div class="page_title_block">
				<div class="col-md-5 col-xs-12">
					<div class="page_title"><?=$page_title?></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="card-body mrg_bottom"> 
				<form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
					<div class="section">
						<div class="section-body">                 
							<div class="form-group">
								<label class="col-md-3 control-label">Book Title :-</label>
								<div class="col-md-6">
									<input type="text" name="book_title" id="book_title" value="" class="form-control" required>
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
												<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                           
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Select Sub Category :-</label>
									<div class="col-md-6">
										<select name="sub_cat_id" id="sub_cat_id" class="select2">
											<option value="0">--Select Sub Category--</option>
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
													<option value="<?php echo $author_row['author_id'];?>"><?php echo $author_row['author_name'];?></option>                           
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Book Description :-</label>
										<div class="col-md-6">
											<textarea name="book_description" id="book_description" class="form-control"></textarea>
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
											<p class="control-label-help">(Recommended resolution: 300x500, 300x550 or 500x800)</p>
										</label>
										<div class="col-md-6">
											<div class="fileupload_block">
												<input type="file" name="book_cover_img" value="" id="fileupload" required>
												<div class="fileupload_img"><img type="image" src="assets/images/portrait.jpg" alt="Featured image" style="width: 110px;height: 150px"/></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Book Background Image :-
											<p class="control-label-help">(Recommended resolution: 590x300, 600x300)</p>
										</label>
										<div class="col-md-6">
											<div class="fileupload_block">
												<input type="file" name="book_bg_img" value="" id="fileupload" required onchange="readURL1(this);">
												<div class="fileupload_img"><img type="image" id="book_bg_img" src="assets/images/portrait.jpg" alt="Featured image" style="width: 140px;height: 90px"/></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Book Upload Type :-</label>
										<div class="col-md-6">                       
											<select name="book_file_type" id="book_file_type" style="width:280px; height:25px;" class="select2" required>
												<option value="">--Select Type--</option>
												<option value="server_url">Server URL</option>
												<option value="local">Browse From Syatem</option>
											</select>
										</div>
									</div>
									<div id="book_url_display" class="form-group">
										<label class="col-md-3 control-label">Live URL :- <p style="color:red" class="control-label-help">(Note : Live URL .pdf and .epub)</p></label>
										<div class="col-md-6">
											<input type="text" name="book_file_server_url" id="book_file_server_url" value="" class="form-control book_file_server_url">
										</div>
									</div>
									<div class="form-group" id="book_local_display" class="form-group" style="display:none">
										<label class="col-md-3 control-label">Browse Book :-<p style="color:red" class="control-label-help">(Note : Uploads .pdf and .epub)</p></label>
										<div class="col-md-6">
											<div class="fileupload_block">
												<input type="file" id="fileupload" value="fileupload" name="book_file_local"  onchange="ValidateSingleInput(this);" class="book_file_local">  
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

 $("#book_file_type").on("change",function(e){
    var _type=$(this).val();

    if(_type=='server_url'){
      $("#book_url_display").show();
      $("input[name='book_file_local']").attr("required",false);
      $("input[name='book_file_server_url']").attr("required",true);
      $("#book_local_display").hide();
    }
    else if(_type=='local'){
      $("input[name='book_file_server_url']").attr("required",false);
      $("input[name='book_file_local']").attr("required",true);
      $("#book_local_display").show();
      $("#book_url_display").hide();
    }
    else{
      $("#book_local_display").hide();
      $("#book_url_display").hide();
    }
  });

</script>