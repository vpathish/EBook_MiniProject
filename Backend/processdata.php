<?php 
	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");
	require("language/app_language.php");

	include("smtp_email.php");

	$file_path = getBaseUrl();

 	error_reporting(0);
 	
	$response=array();

	// get total comments
	function total_comments($book_id)
	{
		global $mysqli;

		$query="SELECT COUNT(*) AS total_comments FROM tbl_comments WHERE `book_id`='$book_id'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		$row=mysqli_fetch_assoc($sql);
		return stripslashes($row['total_comments']);
	}


	switch ($_POST['action']) {
		case 'toggle_status':
			$id=$_POST['id'];
			$for_action=$_POST['for_action'];
			$column=$_POST['column'];
			$tbl_id=$_POST['tbl_id'];
			$table_nm=$_POST['table'];

			if($for_action=='active'){
				$data = array($column  =>  '1');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");

			    if($column=='featured'){

			    	//slider enable and disable
			        $sql="SELECT * FROM tbl_slider WHERE `book_id`=$id";
    				$res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){
    					$row=mysqli_fetch_assoc($res);
    					$data = array('status'  =>  '1');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);
    					
    				}
			    		if($res->num_rows == 0){

							$data_slider = array(
								'book_id' => $id,
								'slider_title' =>  '',
								'slider_type'=> 'Book',
								'external_url' =>  '',
								'external_image' =>  ''
							);  

							$qry = Insert('tbl_slider',$data_slider);
						}

			    	}
			    
			    $data = array($column  =>  '1');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");
 					
				if($table_nm=='tbl_slider'){

					//status enable and disable
			        $sql="SELECT * FROM tbl_slider WHERE `id`=$id";
    				$res=mysqli_query($mysqli, $sql);
    				$row=mysqli_fetch_assoc($res);

			    	$data = array('status'  =>  '1');
			        $edit_status=Update('tbl_books', $data, "WHERE id = ".$row['book_id']);

			        $_SESSION['msg']="13";
			      } 
			      $sql="SELECT * FROM tbl_slider WHERE `book_id`=$id";
    			  $res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){

    					$row=mysqli_fetch_assoc($res);

    					$data = array('status'  =>  '1');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);

    					$_SESSION['msg']="13";

    				}
			    
    			else if($column=='featured'){
					$_SESSION['msg']="14";
				}
				else{
					$_SESSION['msg']="13";
				}
			
			}else{
				
				$data = array($column  =>  '0');
			    $edit_status=Update($table_nm, $data, "WHERE $tbl_id = '$id'");

			    $sql="SELECT * FROM tbl_slider WHERE `book_id`=$id";
    			$res=mysqli_query($mysqli, $sql);

    				if($res->num_rows > 0){

    					$row=mysqli_fetch_assoc($res);

    					$data = array('status'  =>  '0');
    					$edit_status=Update('tbl_slider', $data, "WHERE id = ".$row['id']);

    					
    				}
				$_SESSION['msg']="14";
			   
			   if($column=='featured'){

				$sqlDelete="DELETE FROM tbl_slider WHERE `book_id`=$id";
				mysqli_query($mysqli, $sqlDelete);

			    }
			}

			
	      	$response['status']=1;
	      	$response['action']=$for_action;
	      	echo json_encode($response);
			break;
		
		case 'removeSlider':
				
			$id=$_POST['id'];
			$tbl_nm=$_POST['tbl_nm'];
			$tbl_id=$_POST['tbl_id'];

			$sql=mysqli_query($mysqli,"SELECT * FROM tbl_slider WHERE `id` IN ($id)");
			$row=mysqli_fetch_assoc($sql);

			if($row['slider_type']=="external")
			{
			unlink('images/'.$row['external_image']);
			}

			Delete('tbl_slider','id ='.$id);
			
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;		

		case 'sub_category':
			
		    $cat_id=$_POST['cat_id'];
		    
			//Get sub-category
		    $cat_qry="SELECT * FROM tbl_sub_category WHERE `cat_id`='".$cat_id."'";
			 
			$res=mysqli_query($mysqli,$cat_qry);
					
			echo "<option value=''>--Select Sub Category--</option>";
					
			while($row=mysqli_fetch_array($res)){
				  
			echo  "<option value='".$row['sid']."'>".$row['sub_cat_name']."</option>";
				
			}

			break;
			
		case 'removesubContact':

			$ids=is_array($_POST['ids']) ? implode(',', $_POST['ids']) : $_POST['ids'];

			$sqlDelete="DELETE FROM tbl_contact_sub WHERE `id` IN ($ids)";
			
			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
			
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;
				

		case 'removeData':
			$id=$_POST['id'];
			$tbl_nm=$_POST['tbl_nm'];
			$tbl_id=$_POST['tbl_id'];

			if($tbl_nm=='tbl_users'){
				$sql="SELECT * FROM $tbl_nm WHERE $tbl_id=$id";
				$res=mysqli_query($mysqli, $sql);
				$row=mysqli_fetch_assoc($res);

				unlink('images/'.$row['user_profile']);
				
				Delete('tbl_comments','user_id='.$row['id']);
				
		        Delete('tbl_reports','user_id='.$row['id']);

		        Delete('tbl_rating','user_id='.$row['id']);

				Delete('tbl_favourite','user_id='.$row['id']);

				Delete('tbl_books','user_id='.$row['id']);

				Delete('tbl_user_continue','user_id='.$row['id']);

				Delete('tbl_active_log','user_id='.$row['id']);

			}
			else if($tbl_nm=='tbl_books'){

				$sql="SELECT * FROM $tbl_nm WHERE $tbl_id=$id";
				$res=mysqli_query($mysqli, $sql);
				$row=mysqli_fetch_assoc($res);

				if($row['book_cover_img']!="")
				{
					unlink('images/'.$row['book_cover_img']);
					unlink('images/thumbs/'.$row['book_cover_img']);	 
				}

				if($row['book_bg_img']!="")
				{
					unlink('images/'.$row['book_bg_img']);
					unlink('images/thumbs/'.$row['book_bg_img']);	 
				}

				if($row['book_file_type']=="local")
				{
					$file_name=basename($row['book_file_url']);
					unlink('uploads/'.$file_name);
				}
				
				Delete('tbl_books','id='.$row['id']);
				
		        Delete('tbl_comments','book_id='.$row['id']);
		        
		        Delete('tbl_reports','book_id='.$row['id']);
		        
		        Delete('tbl_rating','book_id='.$row['id']);
		        
		        Delete('tbl_favourite','book_id='.$row['id']);
		        
		        Delete('tbl_slider','book_id='.$row['id']);

		        Delete('tbl_active_log','user_id='.$row['id']);
		        	
		        Delete('tbl_user_continue','book_id='.$row['id']);
		        
			}
			else if($tbl_nm=='tbl_category'){

				$sql="SELECT * FROM tbl_books WHERE cat_id=$id";
				$res=mysqli_query($mysqli, $sql);
				while($row=mysqli_fetch_assoc($res)){
					
					if($row['book_cover_img']!="")
					{
						unlink('images/'.$row['book_cover_img']);
						unlink('images/thumbs/'.$row['book_cover_img']);	 
					}

					if($row['book_bg_img']!="")
					{
						unlink('images/'.$row['book_bg_img']);
						unlink('images/thumbs/'.$row['book_bg_img']);	 
					}

					if($row['book_file_type']=="local")
					{
						$file_name=basename($row['book_file_url']);
						unlink('uploads/'.$file_name);
					}

					Delete('tbl_comments','book_id='.$row['id']);

			        Delete('tbl_reports','book_id='.$row['id']);

			        Delete('tbl_rating','book_id='.$row['id']);

				}

				Delete('tbl_books','cat_id='.$id);

				mysqli_free_result($res);

				$sql="SELECT * FROM $tbl_nm WHERE $tbl_id=$id";
				$res=mysqli_query($mysqli, $sql);
				$row=mysqli_fetch_assoc($res);

				if($row['category_image']!="")
			    {
			    	unlink('images/'.$row['category_image']);
					unlink('images/thumbs/'.$row['category_image']);
				}

			}

			else if($tbl_nm=='tbl_author'){

				$sql="SELECT * FROM tbl_books WHERE aid=$id";
				$res=mysqli_query($mysqli, $sql);
				while($row=mysqli_fetch_assoc($res)){
					if($row['book_cover_img']!="")
					{
						unlink('images/'.$row['book_cover_img']);
						unlink('images/thumbs/'.$row['book_cover_img']);	 
					}

					if($row['book_bg_img']!="")
					{
						unlink('images/'.$row['book_bg_img']);
						unlink('images/thumbs/'.$row['book_bg_img']);	 
					}

					if($row['book_file_type']=="local")
					{
						$file_name=basename($row['book_file_url']);
						unlink('uploads/'.$file_name);
					}

					Delete('tbl_comments','book_id='.$row['id']);

			        Delete('tbl_reports','book_id='.$row['id']);

			        Delete('tbl_rating','book_id='.$row['id']);

				}

				Delete('tbl_books','aid='.$id);

				mysqli_free_result($res);

				$sql="SELECT * FROM $tbl_nm WHERE $tbl_id=$id";
				$res=mysqli_query($mysqli, $sql);
				$row=mysqli_fetch_assoc($res);

				if($row['author_image']!="")
			    {
			    	unlink('images/'.$row['author_image']);
					unlink('images/thumbs/'.$row['author_image']);
				}

			}
			
			else if($tbl_nm=='tbl_reports'){

				$sql="DELETE FROM `tbl_reports` WHERE `user_id`='$id' AND `book_id`='".$_POST['book_id']."'";
				mysqli_query($mysqli, $sql);

				$_SESSION['msg']="12";
		      	$response['status']=1;
		      	echo json_encode($response);
				break;

			}

			Delete($tbl_nm,$tbl_id.'='.$id);

			$_SESSION['msg']="12";
	      	$response['status']=1;
	      	echo json_encode($response);
			break;

		case 'removeComment':

			$id=$_POST['id'];

			if(!isset($_POST['book_id'])){
				$sqlDelete="DELETE FROM tbl_comments WHERE `id`=$id";
				mysqli_query($mysqli, $sqlDelete);
			}
			else{
				$book_id=$_POST['book_id'];
				$sqlDelete="DELETE FROM tbl_comments WHERE `book_id` IN ($book_id)";
				mysqli_query($mysqli, $sqlDelete);

			}

			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;

		  case 'removeAllReports':
			
			$ids=implode(",", $_POST['ids']);

			$type=$_POST['type'];
			
			$sqlDelete="DELETE FROM tbl_reports WHERE `id` IN ($ids)";

			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
			
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);

			break;

		case 'removeReports':

			$ids=is_array($_POST['ids']) ? implode(',', $_POST['ids']) : $_POST['ids'];

			$deleteSql="DELETE FROM tbl_reports WHERE `id` = '$ids'";
			mysqli_query($mysqli, $deleteSql);

			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;	

		  case 'removeAllContinue':
				
			$book_id=implode(',', $_POST['book_id']);

			$type=$_POST['type'];
			
			$sqlDelete="DELETE FROM tbl_user_continue WHERE `book_id` IN ($book_id)";

			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
				
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);

			break;

		case 'removeContinue':
			
			$id=$_POST['id'];

			if(!isset($_POST['book_id'])){
				$sqlDelete="DELETE FROM tbl_user_continue WHERE `id`=$id";
				mysqli_query($mysqli, $sqlDelete);
			}
			else{
				$book_id=$_POST['book_id'];
				$sqlDelete="DELETE FROM tbl_user_continue WHERE `book_id` IN ($book_id)";
				mysqli_query($mysqli, $sqlDelete);

			}

	      	$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;

		 case 'removeAllComment':
			
			$book_id=implode(',', $_POST['ids']);
			
			$sqlDelete="DELETE FROM tbl_comments WHERE `book_id` IN ($book_id)";

			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
			
			$response['status']=1;
			$_SESSION['msg']="12";	
	      	echo json_encode($response);
			break;

		case 'removeContact':

			$ids=is_array($_POST['ids']) ? implode(',', $_POST['ids']) : $_POST['ids'];

			$sqlDelete="DELETE FROM tbl_contact_list WHERE `id` IN ($ids)";
				
			if(mysqli_query($mysqli, $sqlDelete)){
				$response['status']=1;	
			}
			else{
				$response['status']=0;
			}
			
			$response['status']=1;	
			$_SESSION['msg']="12";
	      	echo json_encode($response);
			break;
		
		case 'multi_delete':

			$ids=implode(",", $_POST['id']);

			if($ids==''){
				$ids=$_POST['id'];
			}

			$tbl_nm=$_POST['tbl_nm'];

			if($tbl_nm=='tbl_category'){

				$sql="SELECT * FROM tbl_books WHERE `cat_id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);

				while ($row=mysqli_fetch_assoc($res)) {
					if($row['category_image']!="")
					{
						unlink('images/'.$row['category_image']);
						unlink('images/thumbs/'.$row['category_image']);
					}

				}

				$deleteSql="DELETE FROM tbl_books WHERE `cat_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_sub_category WHERE `cat_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$sql="SELECT * FROM $tbl_nm WHERE `cid` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['category_image']!="")
					{
						unlink('images/'.$row['category_image']);
						unlink('images/thumbs/'.$row['category_image']);
					}

				}

				$deleteSql="DELETE FROM $tbl_nm WHERE `cid` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
				
			else if($tbl_nm=='tbl_books'){
				
				$sql="SELECT * FROM tbl_books WHERE `id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);

				while ($row=mysqli_fetch_assoc($res)) {
					if($row['book_cover_img']!="")
					{
						unlink('images/'.$row['book_cover_img']);
						unlink('images/thumbs/'.$row['book_cover_img']);
					}
					if($row['book_bg_img']!="")
					{
						unlink('images/'.$row['book_bg_img']);
						unlink('images/thumbs/'.$row['book_bg_img']);
					}

					if($row['book_file_type']=="local")
					{
						$file_name=basename($row['book_file_url']);
						unlink('uploads/'.$file_name);
					}
				}

				$deleteSql="DELETE FROM tbl_books WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_rating WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_comments WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_user_continue WHERE `book_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			else if($tbl_nm=='tbl_user_continue'){

				$deleteSql="DELETE FROM $tbl_nm WHERE `con_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}

			else if($tbl_nm=='tbl_sub_category'){

				$sql="SELECT * FROM tbl_books WHERE `sub_cat_id` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['sub_cat_image']!="")
					{
						unlink('images/'.$row['sub_cat_image']);
						unlink('images/thumbs/'.$row['sub_cat_image']);
					}

				}

				$deleteSql="DELETE FROM tbl_books WHERE `sub_cat_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$sql="SELECT * FROM $tbl_nm WHERE `sid` IN ($ids)";
				$res=mysqli_query($mysqli, $sql);
				while ($row=mysqli_fetch_assoc($res)){
					if($row['sub_cat_image']!="")
					{
						unlink('images/'.$row['sub_cat_image']);
						unlink('images/thumbs/'.$row['sub_cat_image']);
					}

				}

				$deleteSql="DELETE FROM $tbl_nm WHERE `sid` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);
			}
			else if($tbl_nm=='tbl_users'){
                 
                 $sql="SELECT * FROM tbl_users WHERE `id` IN ($ids)";
				 $res=mysqli_query($mysqli, $sql);

				while ($row=mysqli_fetch_assoc($res)) {
					if($row['user_image']!="")
					{
						unlink('images/'.$row['user_image']);
					}

				}
				$deleteSql="DELETE FROM tbl_users WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_comments WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_rating WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_user_continue WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

			}
			

			$_SESSION['msg']="12";
	      	$response['status']=1;
	      	echo json_encode($response);
			break;

		case 'multi_action':

			$action=$_POST['for_action'];
			$ids=implode(",", $_POST['id']);
			$table=$_POST['table'];

			if($ids==''){
				$ids=$_POST['id'];
			}

			if($action=='enable'){

				$sql="UPDATE $table SET `status`='1' WHERE `id` IN ($ids)";
				mysqli_query($mysqli, $sql);
				$_SESSION['msg']="13";				
			}
			else if($action=='disable'){
				$sql="UPDATE $table SET `status`='0' WHERE `id` IN ($ids)";
				if(mysqli_query($mysqli, $sql)){
					$_SESSION['msg']="14";
				}
			}
			
			else if($action=='delete'){

				if($table=='tbl_users'){

					$sql="SELECT * FROM $table WHERE `id` IN ($ids)";
				 	$res=mysqli_query($mysqli, $sql);

					while ($row=mysqli_fetch_assoc($res)) {
					if($row['user_image']!="")
					{
						unlink('images/'.$row['user_image']);
					}

				}
				$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";

				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_comments WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_favourite WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_reports WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_rating WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_slider WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_active_log WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				$deleteSql="DELETE FROM tbl_user_continue WHERE `user_id` IN ($ids)";
				mysqli_query($mysqli, $deleteSql);

				}
				else if($table=='tbl_category'){

					$sql="SELECT * FROM tbl_books WHERE `cat_id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);
					while ($row=mysqli_fetch_assoc($res)){
						if($row['book_cover_img']!="")
						{
						unlink('images/'.$row['book_cover_img']);
						unlink('images/thumbs/'.$row['book_cover_img']);
						}

						if($row['book_bg_img']!="")
						{
						unlink('images/'.$row['book_bg_img']);
						unlink('images/thumbs/'.$row['book_bg_img']);
						}

					  	if($row['book_file_type']=="local")
						{
							$file_name=basename($row['book_file_url']);
							unlink('uploads/'.$file_name);
						}

					}
					$deleteSql="DELETE FROM tbl_books WHERE `cat_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_sub_category WHERE `cat_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					mysqli_free_result($res);

					$sqlCategory="SELECT * FROM $table WHERE `cid` IN ($ids)";
					$res=mysqli_query($mysqli, $sqlCategory);
					while ($row=mysqli_fetch_assoc($res)){
						if($row['category_image']!="")
						{
							unlink('images/'.$row['category_image']);
							unlink('images/thumbs/'.$row['category_image']);
						}

					}
					
					$deleteSql="DELETE FROM $table WHERE `cid` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
				}
				else if($table=='tbl_books'){
					
					$sql="SELECT * FROM tbl_books WHERE `id` IN ($ids)";
					$res=mysqli_query($mysqli, $sql);

					while ($row=mysqli_fetch_assoc($res)) {
						if($row['book_cover_img']!="")
						{
						unlink('images/'.$row['book_cover_img']);
						unlink('images/thumbs/'.$row['book_cover_img']);
						}

						if($row['book_bg_img']!="")
						{
						unlink('images/'.$row['book_bg_img']);
						unlink('images/thumbs/'.$row['book_bg_img']);
						}

					}

					$deleteSql="DELETE FROM $table WHERE `id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_slider WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_favourite WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_reports WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_rating WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_comments WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);

					$deleteSql="DELETE FROM tbl_user_continue WHERE `book_id` IN ($ids)";
					mysqli_query($mysqli, $deleteSql);
					
					}
					
				$_SESSION['msg']="12";
			}

			$response['status']=1;	
	      	echo json_encode($response);
			break;

		case 'check_smtp':
			{
				$to = trim($_POST['email']);
				$recipient_name='Check User';

				$subject = '[IMPORTANT] '.APP_NAME.' Check SMTP Configuration';

				$message='<div style="background-color: #f9f9f9;" align="center"><br />
				<table style="font-family: OpenSans,sans-serif; color: #666666;" border="0" width="600" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
				<tbody>
				<tr>
				<td colspan="2" bgcolor="#FFFFFF" align="center"><img src="'.$file_path.'images/'.APP_LOGO.'" alt="header" /></td>
				</tr>
				<tr>
				<td width="600" valign="top" bgcolor="#FFFFFF"><br>
				<table style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; padding: 15px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
				<tbody>
				<tr>
				<td valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:OpenSans,sans-serif; color: #666666; font-size: 10px; width:100%;">
				<tbody>
				<tr>
				<td>
					<p style="color: #262626; font-size: 24px; margin-top:0px;">Hi, '.$_SESSION['admin_name'].'</p>
					<p style="color: #262626; font-size: 18px; margin-top:0px;">This is the demo mail to check SMTP Configuration. </p>
					<p style="color:#262626; font-size:17px; line-height:32px;font-weight:500;margin-bottom:30px;">'.$app_lang['thank_you_lbl'].' '.APP_NAME.'</p>

				</td>
				</tr>
				</tbody>
				</table></td>
				</tr>

				</tbody>
				</table></td>
				</tr>
				<tr>
				<td style="color: #262626; padding: 20px 0; font-size: 18px; border-top:5px solid #52bfd3;" colspan="2" align="center" bgcolor="#ffffff">'.$app_lang['email_copyright'].' '.APP_NAME.'.</td>
				</tr>
				</tbody>
				</table>
				</div>';

				send_email($to,$recipient_name,$subject,$message, true);
			}
			break;	
				
		default:
		# code...
		break;
	}

?>