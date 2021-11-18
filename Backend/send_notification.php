<?php $page_title="Send Notification";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

$qry="SELECT * FROM tbl_settings WHERE `id`='1'";
$result=mysqli_query($mysqli,$qry);
$settings_row=mysqli_fetch_assoc($result);

//All Category
$cat_qry="SELECT * FROM tbl_category ORDER BY `category_name`";
$cat_result=mysqli_query($mysqli,$cat_qry);

$data_qry="SELECT * FROM tbl_books ORDER BY `id` DESC";
$data_result=mysqli_query($mysqli,$data_qry); 

$data_qry_category="SELECT * FROM tbl_category ORDER BY `cid` DESC";
$data_result_category=mysqli_query($mysqli,$data_qry_category);

$data_qry_author="SELECT * FROM tbl_author ORDER BY `author_id` DESC";
$data_result_author=mysqli_query($mysqli,$data_qry_author);

function get_single_info($post_id,$param,$type='author')
{
	global $mysqli;

	switch ($type) {
		case 'author':
		$query="SELECT * FROM tbl_author WHERE `author_id`='$post_id'";
		break;

		case 'category':
		$query="SELECT * FROM tbl_category WHERE `cid`='$post_id'";
		break;

		case 'subCategory':
		$query="SELECT * FROM tbl_sub_category WHERE `sid`='$post_id'";
		break;  
		
		case 'book':
		$query="SELECT * FROM tbl_books WHERE `id`='$post_id'";
		break;

	}
	$sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));
	$row=mysqli_fetch_assoc($sql);

	return stripslashes($row[$param]);
}

if(isset($_POST['submit']))
{

	if($_POST['external_link']!="")
      {
        $external_link = $_POST['external_link'];
      }
      else
      {
        $external_link = false;
      }

    $message=addslashes(trim($_POST['notification_msg']));
    $content = array("en" => $message);

    $id = $sub_id = 0;
    $type=$_POST['type'];
    $title='';	

	if($_POST['cat_id']!=0){
		$id=$_POST['cat_id'];
		$title=get_single_info($id, 'category_name','category');
	}
	else if($_POST['author_id']!=0){
		$id=$_POST['author_id'];
		$title=get_single_info($id, 'author_name','author');
	}
	else if($_POST['book_id']!=0){
		$id=$_POST['book_id'];
		$title=get_single_info($id, 'book_title','book');
	}
	else if($_POST['cat_id2']!=0){
		$id=$_POST['cat_id2'];
		$sub_id = $_POST['sub_id'];
		$title=get_single_info($sub_id, 'sub_cat_name','subCategory');
	}

 $id = strval($id);
 $sub_id = strval($sub_id);

  if($_FILES['big_picture']['name']!="")
	{   

		$big_picture=rand(0,99999)."_".$_FILES['big_picture']['name'];
		$tpath2='images/'.$big_picture;
		move_uploaded_file($_FILES["big_picture"]["tmp_name"], $tpath2);

		$file_path = getBaseUrl().'images/'.$big_picture;

		$content = array(
			"en" => $_POST['notification_msg']                                                 
		);

		$fields = array(
			'app_id' => ONESIGNAL_APP_ID,
			'included_segments' => array('All'),                                            
			'data' => array("foo" => "bar","id"=>$id,"external_link"=>$external_link,"sub_id" => $sub_id,"type"=>$type,"title"=>$title),
			'headings'=> array("en" => $_POST['notification_title']),
			'contents' => $content,
			'big_picture' =>$file_path                    
		);

		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '.ONESIGNAL_REST_KEY));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
		$response = curl_exec($ch);

		curl_close($ch);

	}
	else
	{

		$content = array(
			"en" => $_POST['notification_msg']
		);

		$fields = array(
			'app_id' => ONESIGNAL_APP_ID,
			'included_segments' => array('All'),                                      
			'data' => array("foo" => "bar","id"=>$id,"external_link"=>$external_link,"sub_id" => $sub_id,"type"=>$type,"title"=>$title),
			'headings'=> array("en" => $_POST['notification_title']),
			'contents' => $content
		);

		$fields = json_encode($fields);
		print("\nJSON sent:\n");
		print($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic '.ONESIGNAL_REST_KEY));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		
		curl_close($ch);

	}

	$_SESSION['msg']="17";
	header( "Location:send_notification.php");
	exit; 


}

if(isset($_POST['notification_submit']))
{
	$data = array(
		'onesignal_app_id' => $_POST['onesignal_app_id'],
		'onesignal_rest_key' => $_POST['onesignal_rest_key'],
	);

	$settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

	$_SESSION['msg']="11";
	header( "Location:send_notification.php");
	exit;

} 


?>
<div class="row">
      <div class="col-md-12">
      	<?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom" style="padding: 0px"> 
          	  <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#notification_settings" name="Notification Settings" aria-controls="notification_settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> Notification Settings</a></li>
                <li role="presentation"><a href="#send_notification" aria-controls="send_notification" name="Send notification" role="tab" data-toggle="tab"><i class="fa fa-send"></i> Send Notification</a></li>
                
            </ul>

            <div class="tab-content">
              <div role="tabpanel" class="tab-pane" id="send_notification">
                <div class="container-fluid">
                  <div class="row">
                  <div class="col-md-12">
                    <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Title :-</label>
                          <div class="col-md-6">
                            <input type="text" name="notification_title" id="notification_title" class="form-control" value="" placeholder="" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Message :-</label>
                          <div class="col-md-6">
                              <textarea name="notification_msg" id="notification_msg" class="form-control" required></textarea>
                          </div>
                        </div>
                        <div class="form-group">
	                      <label class="col-md-3 control-label">Image :- (Optional)<p class="control-label-help" style="color: red">(Recommended resolution: 600x293 or 650x317 or 700x342 or 750x366)</p></label>
	                      <div class="col-md-6">
	                        <div class="fileupload_block">
	                           <input type="file" name="big_picture" id="fileupload" onchange="readURL(this)">
	                           <div class="fileupload_img"><img type="image" id="big_picture" src="assets/images/landscape.jpg" alt="image" style="width: 150px;height: 90px"/></div>    
	                        </div>
	                      </div>
	                    </div>
                        <div class="col-md-9 mrg_bottom link_block">
                        <div class="form-group">
                          <label class="col-md-4 control-label"><p>Notification for :- (Optional)</p></label>
                          <div class="col-md-8">
                            <select name="type" id="type" class="select2">
                              <option value="0" selected="">--Select Type--</option>
                              <option value="category">Category</option>
                              <option value="subCategory">Sub-Category</option>
                              <option value="book">Book</option>
                              <option value="author">Author</option>
                            </select> 
                          </div>
                        </div>
                       <div class="form-group typeForBooks" style="display: none;">
                    	<label class="col-md-4 control-label">Books :-
                         <p class="control-label-help">To directly open single book when click on notification</p></label>
                          <div class="col-md-8">
							  <select name="book_id" id="book_id" class="select2">
								<option value="0">--Select Book--</option>
								<?php
									while($data_row=mysqli_fetch_array($data_result))
									{?>                       
								<option value="<?php echo $data_row['id'];?>"><?php echo $data_row['book_title'];?></option>                           
								<?php } ?>
							  </select>
                           </div>
                       </div> 
		               <div class="form-group typeForCategory" style="display: none;">
                    	<label class="col-md-4 control-label">Category :- 
                         <p class="control-label-help">To directly open single Category when click on notification</p></label>
                          <div class="col-md-8">
						  <select name="cat_id" id="cat_id" class="select2">
							<option value="0">--Select Category--</option>
							
							<?php
								while($data_category_row=mysqli_fetch_array($data_result_category))
								{?> 
								
								<option value="<?php echo $data_category_row['cid'];?>"><?php echo $data_category_row['category_name'];?></option>
							<?php } ?>
						  </select>
						 </div>	
                       </div> 
                   	   <div class="form-group typeForSubCategory" style="display: none;">
	                    <label class="col-md-4 control-label">Category :-</label>
	                    <div class="col-md-8">
 						  <select name="cat_id2" id="cat_id2" class="select2">
							<option value="">--Select Category--</option>
							<?php
								while($cat_row=mysqli_fetch_array($cat_result))
								{?>                  
							<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                           
							<?php }  ?>
						  </select>
	                    </div>
	                    <hr/>
	                      <label class="col-md-4 control-label">Sub-Category :-</label>
	                      <div class="col-md-8">
	                        <select name="sub_id" id="sub_id" class="select2">
	                          <option value="">--Select Sub-Category--</option>
	                        </select>
	                      </div>
	                  	</div>
		              <div class="form-group typeForAuthor" style="display: none;">
                    	<label class="col-md-4 control-label">Author :- 
                         <p class="control-label-help">To directly open single Author when click on notification</p></label>
                       <div class="col-md-8">
                      <select name="author_id" id="author_id" class="select2">
                        <option value="0">--Select Author--</option>
                        <?php
                            while($data_author_row=mysqli_fetch_array($data_result_author))
                            {?>                       
                        <option value="<?php echo $data_author_row['author_id'];?>"><?php echo $data_author_row['author_name'];?></option>                           
                        <?php } ?>
                       </select>
                    	</div>
                        </div> 
						<div class="or_link_item">
		                  <h2>OR</h2>
		                  </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">External Link :- (Optional)</label>
                          <div class="col-md-8">
                            <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://www.viaviweb.com">
                          </div>
                        </div>   
                      </div>   
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-primary">Send</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
                </div>
              </div>

              <!-- for notification settings tab -->
              <div role="tabpanel" class="tab-pane active" id="notification_settings">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <form action="" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                        <div class="section">
                          <div class="section-body">
                            <div class="form-group">
                              <label class="col-md-3 control-label">OneSignal App ID :-</label>
                              <div class="col-md-6">
                                <input type="text" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_row['onesignal_app_id'];?>" class="form-control">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label">OneSignal Rest Key :-</label>
                              <div class="col-md-6">
                                <input type="text" name="onesignal_rest_key" id="onesignal_rest_key" value="<?php echo $settings_row['onesignal_rest_key'];?>" class="form-control">
                              </div>
                            </div>              
                            <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                              <button type="submit" name="notification_submit" class="btn btn-primary">Save</button>
                            </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
</div>        
<?php include("includes/footer.php");?>       

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
        $('#big_picture').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

	$("#type").on("change",function(e){
		var _type=$(this).val();

		$("*[class*='typeFor']").each(function(){
			$(this).find("select").attr("required",false);

			/*if($(this).find("#notification_product").html() == undefined){
				$(this).find("select").select2('destroy').val('').select2();
			}*/
		});

		if(_type=='category'){
			$("*[class*='typeFor']").hide();
			$(".typeForCategory").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='subCategory'){
			$("*[class*='typeFor']").hide();
			$(".typeForSubCategory").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='book'){
			$("*[class*='typeFor']").hide();
			$(".typeForBooks").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='author'){
			$("*[class*='typeFor']").hide();
			$(".typeForAuthor").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else{
			$("*[class*='typeFor']").hide();
		}

	});

// getting sub categories
$("select[name='cat_id2']").on("change",function(e){

  var _cat_id=$(this).val();

  $.ajax({
    type:'post',
    url:'processdata.php',
    data:{cat_id:_cat_id,'action':'sub_category'},
    success:function(data){
      $("select[name='sub_id']").html(data);
    }
  });
});
</script>