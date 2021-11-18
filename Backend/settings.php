<?php $page_title="Settings";
	
include("includes/header.php");
require("includes/function.php");
require("language/language.php");
	

  $qry="SELECT * FROM tbl_settings WHERE `id`='1'";
  $result=mysqli_query($mysqli,$qry);
  $settings_row=mysqli_fetch_assoc($result);
 
  if(isset($_POST['submit']))
  {

    $img_res=mysqli_query($mysqli,"SELECT * FROM tbl_settings WHERE `id`='1'");
    $img_row=mysqli_fetch_assoc($img_res);

    if($_FILES['app_logo']['name']!="")
    {        

            unlink('images/'.$img_row['app_logo']);   

            $app_logo=$_FILES['app_logo']['name'];
            $pic1=$_FILES['app_logo']['tmp_name'];

            $tpath1='images/'.$app_logo;      
            copy($pic1,$tpath1);


              $data = array(      
              'app_name'  =>  $_POST['app_name'],
              'app_logo'  =>  $app_logo,  
              'app_description'  => addslashes($_POST['app_description']),
              'app_version'  =>  $_POST['app_version'],
              'app_author'  =>  $_POST['app_author'],
              'app_contact'  =>  $_POST['app_contact'],
              'app_email'  =>  $_POST['app_email'],   
              'app_website'  =>  $_POST['app_website']                     

              );
    }
    else
    {
  
        $data = array(
            'app_name'  =>  $_POST['app_name'],
            'app_description'  => addslashes($_POST['app_description']),
            'app_version'  =>  $_POST['app_version'],
            'app_author'  =>  $_POST['app_author'],
            'app_contact'  =>  $_POST['app_contact'],
            'app_email'  =>  $_POST['app_email'],   
            'app_website'  =>  $_POST['app_website']
        );

    } 

      $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;

        
  }

 else if(isset($_POST['admob_submit'])){

        $data = array(
            'publisher_id'  =>  cleanInput($_POST['publisher_id']),
            'interstital_ad'  =>  ($_POST['interstital_ad']) ? 'true' : 'false',
            'interstital_ad_type'  =>  cleanInput($_POST['interstital_ad_type']),
            'interstital_ad_id'  =>  cleanInput($_POST['interstital_ad_id']),
            'interstital_ad_click'  =>  cleanInput($_POST['interstital_ad_click']),
            'facebook_interstital_ad_id'  =>  cleanInput($_POST['facebook_interstital_ad_id']),
            'banner_ad'  =>  ($_POST['banner_ad']) ? 'true' : 'false',
            'banner_ad_type'  =>  cleanInput($_POST['banner_ad_type']),
            'banner_ad_id'  =>  cleanInput($_POST['banner_ad_id']),
            'facebook_banner_ad_id'  =>  cleanInput($_POST['facebook_banner_ad_id']),
            'native_ad'  =>  ($_POST['native_ad']) ? 'true' : 'false',
	        'native_ad_type'  =>  cleanInput($_POST['native_ad_type']),
	        'native_ad_id'  =>  cleanInput($_POST['native_ad_id']),
	        'native_facebook_id'  =>  cleanInput($_POST['native_facebook_id']),
	        'native_position'  =>  cleanInput($_POST['native_position']),
	        'native_cat_position'  =>  cleanInput($_POST['native_cat_position']),
	        'native_position_grid'  =>  cleanInput($_POST['native_position_grid'])
            );

        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");


        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;

 }

else if(isset($_POST['api_submit']))
  {

$data = array(
		'api_page_limit'  =>  trim($_POST['api_page_limit']),
		'api_cat_order_by'  =>  $_POST['api_cat_order_by'],
		'api_cat_post_order_by'  =>  $_POST['api_cat_post_order_by'],
		'api_author_order_by'  =>  $_POST['api_author_order_by'],
		'api_author_post_order_by'  =>  $_POST['api_author_post_order_by'],
		'cat_show_home_limit'  =>  trim($_POST['cat_show_home_limit']),
		'api_sub_cat_order_by'  =>  $_POST['api_sub_cat_order_by'],
		'api_sub_cat_post_order_by'  =>  $_POST['api_sub_cat_post_order_by']
		  );

    
      $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");
 
        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;

      }   


else if(isset($_POST['app_pri_poly']))
  {

        $data = array(
                'app_privacy_policy'  =>  addslashes($_POST['app_privacy_policy'])
                  );

        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

        $_SESSION['msg']="11";
        header( "Location:settings.php");
        exit;
  
 
  }
 else if (isset($_POST['app_faq_submit'])){

	$data = array('app_faq'  =>  trim($_POST['app_faq']));

	$settings_edit = Update('tbl_settings', $data, "WHERE id = '1'");

	$_SESSION['msg'] = "11";
	header("Location:settings.php");
	exit;
}
else if (isset($_POST['app_update_popup'])) {

	$data = array(
		'app_update_status'  => ($_POST['app_update_status']) ? 'true' : 'false',
		'app_new_version'  =>  trim($_POST['app_new_version']),
		'app_update_desc'  =>  trim($_POST['app_update_desc']),
		'app_redirect_url'  =>  trim($_POST['app_redirect_url']),
		'cancel_update_status'  => ($_POST['cancel_update_status']) ? 'true' : 'false',
	);

	$settings_edit = Update('tbl_settings', $data, "WHERE id = '1'");

	$_SESSION['msg'] = "11";
	header("Location:settings.php");
	exit;

}
else if(isset($_POST['account_delete'])){

  $data = array(
    'account_delete_intruction'  =>  trim($_POST['account_delete_intruction'])
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

  $_SESSION['msg'] = "11";
  header( "Location:settings.php");
  exit;
} 

?>
<style>
.field_lable {
    margin-bottom: 10px;
    margin-top: 10px;
    color: #666;
    padding-left: 15px;
    font-size: 14px;
    line-height: 24px;
}
.banner_ads_block .toggle_btn, .interstital_ad_item .toggle_btn{
	margin-top: 6px;
}
.lbl{
	left: 13px;
}
.banner_ads_block{
	min-height:auto;
}
.banner_ad_item {
    margin-bottom: 10px;
}
.video_setting_item{
	background: #f7f7f7;
	border:1px solid rgba(0, 0, 0, 0.1);
	margin-top:0px;
	padding:10px 20px;
	margin-bottom: 10px;
	border-radius:6px;	
}
</style>
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
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#app_settings" aria-controls="app_settings" role="tab" data-toggle="tab">App Settings</a></li>
                <li role="presentation"><a href="#admob_settings" aria-controls="admob_settings" role="tab" data-toggle="tab">Ads Settings</a></li>
                <li role="presentation"><a href="#api_settings" aria-controls="api_settings" role="tab" data-toggle="tab">API Settings</a></li>
                <li role="presentation"><a href="#api_faq" name="App FAQ" aria-controls="api_faq" role="tab" data-toggle="tab">App FAQ</a></li>
                <li role="presentation"><a href="#account_delete" aria-controls="account_delete" role="tab" data-toggle="tab">Delete Account Instructions</a></li>
                <li role="presentation"><a href="#api_privacy_policy" aria-controls="api_privacy_policy" role="tab" data-toggle="tab">App Privacy Policy</a></li>
                <li role="presentation"><a href="#app_update_popup" aria-controls="app_update_popup" role="tab" data-toggle="tab">App Update</a></li>
            </ul>

           <div class="rows">
            <div class="col-md-12">
          	  <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="app_settings">   
                <form action="" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" class="current_tab" name="current_tab">
				  <div class="section">
					<div class="section-body">
					  <div class="form-group" style="">
                        <label class="col-md-3 control-label">Email <span style="color: red">*</span>:-
						  <p class="control-label-help" style="color: red">(<strong>Note:</strong> This email is required when user want to contact you.)</p>
						</label>
						<div class="col-md-6">
						  <input type="text" name="app_email" id="app_email" value="<?php echo $settings_row['app_email']; ?>" class="form-control">
						</div>
					  </div>   
					  <div class="form-group">
						<label class="col-md-3 control-label">App Name :-</label>
						<div class="col-md-6">
						  <input type="text" name="app_name" id="app_name" value="<?php echo $settings_row['app_name'];?>" class="form-control">
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label">App Logo :-</label>
						<div class="col-md-6">
						  <div class="fileupload_block">
							<input type="file" name="app_logo" id="fileupload">							 
							  <?php if($settings_row['app_logo']!="") {?>
								<div class="fileupload_img"><img type="image" src="images/<?php echo $settings_row['app_logo'];?>" alt="image" style="width: 100px;height: 100px;" /></div>
							  <?php } else {?>
								<div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="image" /></div>
							  <?php }?>							
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label">App Description :-</label>
						<div class="col-md-6">					 
						  <textarea name="app_description" id="app_description" class="form-control"><?php echo $settings_row['app_description'];?></textarea>
						  <script>CKEDITOR.replace( 'app_description' );</script>
						</div>
					  </div>
					  <div class="form-group">&nbsp;</div>                 
					  <div class="form-group">
						<label class="col-md-3 control-label">App Version :-</label>
						<div class="col-md-6">
						  <input type="text" name="app_version" id="app_version" value="<?php echo $settings_row['app_version'];?>" class="form-control">
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label">Author :-</label>
						<div class="col-md-6">
						  <input type="text" name="app_author" id="app_author" value="<?php echo $settings_row['app_author'];?>" class="form-control">
						</div>
					  </div>
					  <div class="form-group">
						<label class="col-md-3 control-label">Contact :-</label>
						<div class="col-md-6">
						  <input type="text" name="app_contact" id="app_contact" value="<?php echo $settings_row['app_contact'];?>" class="form-control">
						</div>
					  </div>     
					  <div class="form-group">
						<label class="col-md-3 control-label">Website :-</label>
						<div class="col-md-6">
						  <input type="text" name="app_website" id="app_website" value="<?php echo $settings_row['app_website'];?>" class="form-control">
						</div>
					  </div> 
					  <div class="form-group">
						<div class="col-md-8 col-md-offset-3">
						  <button type="submit" name="submit" class="btn btn-primary" style="margin-bottom:20px;">Save</button>
						</div>
					  </div>
					</div>
				  </div>
               </form>
              </div>
           	 <!-- admob settings -->
	           <div role="tabpanel" class="tab-pane" id="admob_settings">   
		          <form action="" name="admob_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
		          <div class="section">
					 <div class="section-body">            
						<div class="row">
						  <div class="col-md-12">
							 <div class="form-group">
								  <label class="col-md-3 control-label">Publisher ID :- <p class="control-label-help" style="color: red">(<strong>Note:</strong>Publisher ID is not required for Facebook Ads)</p></label>
								  <div class="col-md-5">
									<input type="text" name="publisher_id" id="publisher_id" value="<?php echo $settings_row['publisher_id'];?>" class="form-control">
								  </div>
								  <div style="height:60px;display:inline-block;position:relative"></div>
							  </div>
						  </div>
						  <div class="col-md-12">
							<div class="banner_ads_block">
							  <div class="banner_ad_item">
								<label class="control-label">Banner Ads :-</label>
								<div class="row toggle_btn" style="position: relative;margin-top: -8px;">
								  <input type="checkbox" id="chk_banner" name="banner_ad" value="true" class="cbx hidden" <?=($settings_row['banner_ad']=='true') ? 'checked=""' : '' ?>>
								  <label for="chk_banner" class="lbl"></label>
								</div>                                    
							  </div>
							  <div class="col-md-6">
								<div class="form-group">
								  <p class="field_lable">Banner Ad Type :-</p>
								  <div class="col-md-12">
								   <select name="banner_ad_type" id="banner_ad_type" class="select2">
									  <option value="admob" <?php if($settings_row['banner_ad_type']=='admob'){ echo 'selected="selected"'; }?>>Admob</option>
									  <option value="facebook" <?php if($settings_row['banner_ad_type']=='facebook'){ echo 'selected="selected"'; }?>>Facebook</option>
									</select>
								  </div>
								</div>               
							  </div>
							  <div class="col-md-6">
								 <div class="form-group">
								  <p class="field_lable">Banner ID :-</p>
								  <div class="col-md-12 banner_ad_id" style="display: none">
									<input type="text" name="banner_ad_id" id="banner_ad_id" value="<?php echo $settings_row['banner_ad_id'];?>" class="form-control">
								  </div>
								  <div class="col-md-12 facebook_banner_ad_id" style="display: none">
									<input type="text" name="facebook_banner_ad_id" id="facebook_banner_ad_id" value="<?php echo $settings_row['facebook_banner_ad_id'];?>" class="form-control">
								  </div>
								</div>                 
							  </div>
							</div>  
						  </div>
						  <div class="col-md-6">
						    <div class="interstital_ads_block">
							  <div class="interstital_ad_item">
								<label class="control-label">Interstitial Ads :-</label>
								<div class="row toggle_btn" style="position: relative;margin-top: -8px;">
								  <input type="checkbox" id="chk_interstitial" name="interstital_ad" value="true" class="cbx hidden" <?php if($settings_row['interstital_ad']=='true'){?>checked <?php }?>/>
								  <label for="chk_interstitial" class="lbl"></label>
								</div>                  
							  </div>  
							  <div class="col-md-12">
								<div class="form-group">
								  <p class="field_lable">Interstitial Ad Type :-</p>
								  <div class="col-md-12"> 
									<select name="interstital_ad_type" id="interstital_ad_type" class="select2">
									  <option value="admob" <?php if($settings_row['interstital_ad_type']=='admob'){ echo 'selected="selected"'; }?>>Admob</option>
									  <option value="facebook" <?php if($settings_row['interstital_ad_type']=='facebook'){ echo 'selected="selected"'; }?>>Facebook</option>
									</select>                                 
								  </div>
								</div>
								<div class="form-group">
								  <p class="field_lable">Interstitial Ad ID :-</p>
								  <div class="col-md-12 interstital_ad_id" style="display: none">
									<input type="text" name="interstital_ad_id" id="interstital_ad_id" value="<?php echo $settings_row['interstital_ad_id'];?>" class="form-control">
								  </div>
								  <div class="col-md-12 facebook_interstital_ad_id" style="display: none">
									<input type="text" name="facebook_interstital_ad_id" id="facebook_interstital_ad_id" value="<?php echo $settings_row['facebook_interstital_ad_id'];?>" class="form-control">
								  </div>
								</div>
								<div class="form-group">
								  <p class="field_lable">Interstitial Clicks :-</p>
								  <div class="col-md-12">
									<input type="text" name="interstital_ad_click" id="interstital_ad_click" value="<?php echo $settings_row['interstital_ad_click'];?>" class="form-control">
								  </div>
								</div>                   
							  </div>                  
							</div>
					      </div>
					  	<div class="col-md-6">
						  <div class="banner_ads_block">
							  <div class="banner_ad_item">
								<label class="control-label">Native Ads:-</label>
								<div class="row toggle_btn" style="position: relative;margin-top: -8px;">
								  <input type="checkbox" id="checked4" name="native_ad" value="true" class="cbx hidden" <?php if($settings_row['native_ad']=='true'){?>checked <?php }?> />
								  <label for="checked4" class="lbl"></label>
								</div>
							  </div>              
							  <div class="col-md-12">
								<div class="form-group" id="#admob_banner_id">                              
                                    <p class="field_lable">Native Ad Type :-</p>
                                    <div class="col-md-12"> 
                                      <select name="native_ad_type" id="native_ad_type" class="select2">
                                        <option value="admob" <?php if($settings_row['native_ad_type']=='admob'){?>selected<?php }?>>Admob</option>
                                        <option value="facebook" <?php if($settings_row['native_ad_type']=='facebook'){?>selected<?php }?>>Facebook</option>
                        
                                      </select>                                 
                                    </div>
								  <p class="field_lable">Native Ad ID :-</p>
                                  <div class="col-md-12 native_ad_id" style="display: none">
                                    <input type="text" name="native_ad_id" id="native_ad_id" value="<?php echo $settings_row['native_ad_id'];?>" class="form-control">
                                  </div>
                                  <div class="col-md-12 native_facebook_id" style="display: none">
                                    <input type="text" name="native_facebook_id" id="native_facebook_id" value="<?php echo $settings_row['native_facebook_id'];?>" class="form-control">
                                  </div>
                                  <p class="field_lable">Position of Ad in :-<br><span style="color: red">(<strong>Note:</strong>  Category, Sub-Category, Author List)(4,7,10,14,.... + 3)</span></p>
                                  <div class="col-md-12"> 
                                      <input type="number" name="native_position" id="native_position" min="4" value="<?php echo $settings_row['native_position'];?>" class="form-control ads_click">
                                  </div>
                                  <p class="field_lable" style="display: inline-block;width: 100%;">Position of Ad in Book List :-</p>
                                  <div class="col-md-6"> 
									  <p style="color: red">(<strong>Note:</strong> Grid View Book)</p>
                                      <input type="number" name="native_position_grid" id="native_position_grid" min="4" value="<?php echo $settings_row['native_position_grid'];?>" class="form-control ads_click">
                                       <p style="color: red">(4,7,10,14,.... + 3)</p>
                                  </div>                                   
                                  <div class="col-md-6"> 
									  <p style="color: red">(<strong>Note:</strong> List View Book)</p>
                                      <input type="number" name="native_cat_position" id="native_cat_position" min="2" value="<?php echo $settings_row['native_cat_position'];?>" class="form-control ads_click">
                                  </div>
								</div>  
								<br>                    
							  </div>
							</div> 
						</div> 
				   </div>
               </div>                        
			   <div class="form-group">
				  <div class="col-md-9 col-md-offset-5">
				  <button type="submit" name="admob_submit" class="btn btn-primary">Save</button>
				  </div>
				</div>
              <br>
            </div>
           </form>
          </div>

		  <div role="tabpanel" class="tab-pane" id="api_settings">   
			<form action="" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data">                
			   <div class="section">
                <div class="section-body">
				  <div class="row">
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Pagination Limit:-</label>
						<div class="col-md-6">
						  <input type="number" name="api_page_limit" id="api_page_limit" value="<?php echo $settings_row['api_page_limit'];?>" class="form-control"> 
						</div>
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Category List Order By:-</label>
						<div class="col-md-6">                                               
							<select name="api_cat_order_by" id="api_cat_order_by" class="select2">
							  <option value="cid" <?php if($settings_row['api_cat_order_by']=='cid'){?>selected<?php }?>>ID</option>
							  <option value="category_name" <?php if($settings_row['api_cat_order_by']=='category_name'){?>selected<?php }?>>Name</option>              
							</select>                        
						</div>                   
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Category Post Order:-</label>
						<div class="col-md-6">                                               
							<select name="api_cat_post_order_by" id="api_cat_post_order_by" class="select2">
							  <option value="ASC" <?php if($settings_row['api_cat_post_order_by']=='ASC'){?>selected<?php }?>>ASC</option>
							  <option value="DESC" <?php if($settings_row['api_cat_post_order_by']=='DESC'){?>selected<?php }?>>DESC</option>              
							</select>                        
						</div>                   
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Author List Order By:-</label>
						<div class="col-md-6">
							<select name="api_author_order_by" id="api_author_order_by" class="select2">
							  <option value="author_id" <?php if($settings_row['api_author_order_by']=='author_id'){?>selected<?php }?>>ID</option>
							  <option value="author_name" <?php if($settings_row['api_author_order_by']=='author_name'){?>selected<?php }?>>Name</option>              
							</select>                        
						</div>                   
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Author Post Order:-</label>
						<div class="col-md-6">
						   <select name="api_author_post_order_by" id="api_author_post_order_by" class="select2">
							  <option value="ASC" <?php if($settings_row['api_author_post_order_by']=='ASC'){?>selected<?php }?>>ASC</option>
							  <option value="DESC" <?php if($settings_row['api_author_post_order_by']=='DESC'){?>selected<?php }?>>DESC</option>
							</select>
						</div>
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Category Show in Home Limit:-</label>
						<div class="col-md-6">
						  <input type="number" onkeypress="isNumberKey(this)" min="0" name="cat_show_home_limit" id="cat_show_home_limit" value="<?php echo $settings_row['cat_show_home_limit'];?>" class="form-control"> 
						</div>
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Sub Category List Order By:-</label>
						<div class="col-md-6">
						   <select name="api_sub_cat_order_by" id="api_sub_cat_order_by" class="select2">
							  <option value="sid" <?php if($settings_row['api_sub_cat_order_by']=='sid'){?>selected<?php }?>>ID</option>
							  <option value="sub_cat_name" <?php if($settings_row['api_sub_cat_order_by']=='sub_cat_name'){?>selected<?php }?>>Name</option>
							</select>
						</div>
					  </div>
					  <div class="col-md-6">
						<label class="col-md-6 control-label">Sub Category Post Order:-</label>
						<div class="col-md-6">
							<select name="api_sub_cat_post_order_by" id="api_sub_cat_post_order_by" class="select2">
							  <option value="ASC" <?php if($settings_row['api_sub_cat_post_order_by']=='ASC'){?>selected<?php }?>>ASC</option>
							  <option value="DESC" <?php if($settings_row['api_sub_cat_post_order_by']=='DESC'){?>selected<?php }?>>DESC</option>
							</select>
						</div>
					  </div>
					  <div class="col-md-3 col-md-offset-3">
						  <button type="submit" name="api_submit" class="btn btn-primary">Save</button>
					  </div>					  
                  </div>
                  <br>
                </div>
              </div>
               </form>
              </div> 
               <div role="tabpanel" class="tab-pane" id="api_faq">
					<form action="" name="api_faq" method="post" class="form form-horizontal" enctype="multipart/form-data">
						<div class="section">
							<div class="section-body">
								<div class="form-group">
									<label class="col-md-3 control-label">App FAQ :-</label>
									<div class="col-md-6">
										<textarea name="app_faq" id="app_faq" class="form-control"><?php echo stripslashes($settings_row['app_faq']); ?></textarea>
										<script>
											CKEDITOR.replace('app_faq');
										</script>
									</div>
								</div>
								<br>
								<div class="form-group">
									<div class="col-md-9 col-md-offset-3">
										<button type="submit" name="app_faq_submit" class="btn btn-primary">Save</button>
									</div>
								</div>
								 <br>
							</div>
						</div>
					</form>
				</div>
				  <div role="tabpanel" class="tab-pane" id="account_delete"> 
		            <div class="rows">
		                <form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
		                  <div class="section">
		                    <div class="section-body">
		                    	<?php 
		                        if(file_exists('delete_instruction.php'))
									{
		                        ?>
		                        <div class="form-group">
		                          <label class="col-md-3 control-label">Account Delete Instructions URL :-</label>
		                          <div class="col-md-9">
		                            <input type="text" readonly class="form-control" value="<?=getBaseUrl().'delete_instruction.php'?>">
		                          </div>
		                        </div>
		                      <?php } ?>
		                      <div class="form-group">
		                        <label class="col-md-3 control-label">Account Delete Instructions :-</label>
		                        <div class="col-md-9">
		                          <textarea name="account_delete_intruction" id="account_delete_intruction" class="form-control"><?php echo stripslashes($settings_row['account_delete_intruction']);?></textarea>
		                          <script>CKEDITOR.replace('account_delete_intruction');</script>
		                        </div>
		                      </div>
		                      <br/>
		                      <div class="form-group">
		                        <div class="col-md-9 col-md-offset-3">
		                          <button type="submit" name="account_delete" class="btn btn-primary">Save</button>
		                        </div>
		                      </div>
		                      <br>
		                    </div>
		                  </div>
		                </form>
		              </div>
		        	</div>
              		<div role="tabpanel" class="tab-pane" id="app_update_popup">
					<form action="" name="app_update" method="post" class="form form-horizontal" enctype="multipart/form-data">

						<div class="section">
							<div class="section-body">
								<div class="form-group">
									<label class="col-md-3 control-label">App Update Popup Show/Hide:-
										<p class="control-label-help" style="color:#F00">You can show/hide update popup from this option</p>
									</label>
									<div class="col-md-6">
										<div class="row" style="margin-top: 15px">
											<input type="checkbox" id="chk_update" name="app_update_status" value="true" class="cbx hidden" <?php if ($settings_row['app_update_status'] == 'true') {echo 'checked';} ?> />
											<label for="chk_update" class="lbl" style="left:13px;"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">New App Version Code :-
										<a href="assets/images/android_version_code.png" target="_blank">
											<p class="control-label-help" style="color:#F00">How to get version code</p>
										</a>
									</label>
									<div class="col-md-6">
										<input type="number" min="1" name="app_new_version" id="app_new_version" required="" value="<?php echo $settings_row['app_new_version']; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Description :-</label>
									<div class="col-md-6">
										<textarea name="app_update_desc" class="form-control"><?php echo $settings_row['app_update_desc']; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">App Link :-
										<p class="control-label-help">You will be redirect on this link after click on update</p>
									</label>
									<div class="col-md-6">
										<input type="text" name="app_redirect_url" id="app_redirect_url" required="" value="<?php echo $settings_row['app_redirect_url']; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Cancel Option :-
										<p class="control-label-help" style="color:#F00">Cancel button option will show in app update popup</p>
									</label>
									<div class="col-md-6">
										<div class="row" style="margin-top: 15px">
											<input type="checkbox" id="chk_cancel_update" name="cancel_update_status" value="true" class="cbx hidden" <?php if ($settings_row['cancel_update_status'] == 'true') {echo 'checked';} ?> />
											<label for="chk_cancel_update" class="lbl" style="left:13px;"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-9 col-md-offset-3">
										<button type="submit" name="app_update_popup" class="btn btn-primary">Save</button>
									</div>
								</div>
								 <br>
							</div>
						</div>
					</form>
				</div>
              <div role="tabpanel" class="tab-pane" id="api_privacy_policy">   
                <form action="" name="api_privacy_policy" method="post" class="form form-horizontal" enctype="multipart/form-data">
				  <div class="section">
					<div class="section-body">
					  <?php 
						if(file_exists('privacy_policy.php'))
						{
					  ?>
						<div class="form-group">
						  <label class="col-md-3 control-label">App Privacy Policy URL :-</label>
						  <div class="col-md-8">
							<input type="text" readonly class="form-control" value="<?=getBaseUrl().'privacy_policy.php'?>">
						  </div>
						</div>
					  <?php } ?>
					  <div class="form-group">
						<label class="col-md-3 control-label">App Privacy Policy :-</label>
						<div class="col-md-8">					 
						  <textarea name="app_privacy_policy" id="privacy_policy" class="form-control"><?php echo stripslashes($settings_row['app_privacy_policy']);?></textarea>
						  <script>CKEDITOR.replace( 'privacy_policy' );</script>
						</div>
					  </div>
					  
					  <br/>               
					  <div class="form-group">
						<div class="col-md-9 col-md-offset-3">
						  <button type="submit" name="app_pri_poly" class="btn btn-primary" style="margin-bottom:20px;">Save</button>
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
        $("input[name='app_logo']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='app_logo']").change(function() { 
    readURL(this);
  });

  if($("select[name='banner_ad_type']").val()==='facebook'){
    $(".banner_ad_id").hide();
    $(".facebook_banner_ad_id").show();
  }
  else{
    $(".facebook_banner_ad_id").hide();
    $(".banner_ad_id").show(); 
  }

  $("select[name='banner_ad_type']").change(function(e){
    if($(this).val()==='facebook'){
      $(".banner_ad_id").hide();
      $(".facebook_banner_ad_id").show();
    }
    else{
      $(".facebook_banner_ad_id").hide();
      $(".banner_ad_id").show(); 
    }
  });

  if($("select[name='interstital_ad_type']").val()==='facebook'){
    $(".interstital_ad_id").hide();
    $(".facebook_interstital_ad_id").show();
  }
  else{
    $(".facebook_interstital_ad_id").hide();
    $(".interstital_ad_id").show(); 
  }

  $("select[name='interstital_ad_type']").change(function(e){

    if($(this).val()==='facebook'){
      $(".interstital_ad_id").hide();
      $(".facebook_interstital_ad_id").show();
    }
    else{
      $(".facebook_interstital_ad_id").hide();
      $(".interstital_ad_id").show(); 
    }
  });

  $("#interstital_ad_click").blur(function(e){
    if($(this).val() == '')
      $(this).val("0");
  });
  
  $("input[name='cat_show_home_limit']").blur(function(e){
    if($(this).val() == '')
    {
      $(this).val("0");
    }
  });
  
  if($("select[name='native_ad_type']").val()==='facebook'){
    $(".native_ad_id").hide();
    $(".native_facebook_id").show();
  }
  else{
    $(".native_facebook_id").hide();
    $(".native_ad_id").show(); 
  }

  $("select[name='native_ad_type']").change(function(e){

    if($(this).val()==='facebook'){
      $(".native_ad_id").hide();
      $(".native_facebook_id").show();
    }
    else{
      $(".native_facebook_id").hide();
      $(".native_ad_id").show(); 
    }
  });

  $("input[name='native_position']").blur(function(e){

    if($(this).val()=='' || parseInt($(this).val()) <= 0){
      $(this).val('1');
    }
  });

  $("input[name='native_position_grid']").blur(function(e){

    if($(this).val()=='' || parseInt($(this).val()) <= 0){
      $(this).val('1');
    }
  });

  $("input[name='native_cat_position']").blur(function(e){

    if($(this).val()=='' || parseInt($(this).val()) <= 0){
      $(this).val('1');
    }
  });

</script>