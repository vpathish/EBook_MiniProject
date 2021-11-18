<?php $page_title="Api Urls";
  	
  include("includes/header.php");
  include("includes/function.php");
  
$file_path = getBaseUrl().'api.php';

?>
<div class="row">
      <div class="col-sm-12 col-xs-12">
      	<?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
     	 	<div class="card">
		        <div class="card-header">
		          Example API urls
		        </div>
       			    <div class="card-body no-padding">
         	    <pre>
                <code class="html">
                <br><b>API URL</b>&nbsp; <?php echo $file_path;?>    
                
                <br><b>Home</b>(Method: get_home)  (Parameter: user_id)
	            <br><b>Latest Books</b>(Method: get_latest_books) (Parameter: ads_param, is_book [list_book,grid_book], page)
                <br><b>Popular Books</b>(Method: get_popular_books) (Parameter: ads_param, is_book [list_book,grid_book],page)
                <br><b>Search Books</b>(Method: get_search_books) (Parameter: ads_param, is_book [list_book,grid_book], search_text,page, category_id (Optional), sub_cat_id (Optional), author_id (Optional))
                <br><b>Category List</b>(Method: get_category) (Parameter: ads_param, page)
                <br><b>Category Name</b>(Method: get_category_name)
                <br><b>Sub Category List</b>(Method: get_sub_category)(Parameter: cat_id, page)
                <br><b>Sub Category Name</b>(Method: get_sub_cat_name) (Parameter: cat_id)
                <br><b>Author List</b>(Method: get_author) (Parameter: ads_param, page)
                <br><b>Author Name</b>(Method: get_author_name) 
                <br><b>Author Details</b>(Method: get_author_details) (Parameter: author_id)
                <br><b>Books list by Cat ID</b>(Method: get_cat_id) (Parameter: ads_param, is_book [list_book,grid_book], cat_id, sub_cat_id, page)
                <br><b>Books list by Author ID</b>(Method: get_author_id) (Parameter: ads_param, author_id,page)
                <br><b>Single Book</b>(Method: get_single_book) (Parameter: book_id,user_id)
                <br><b>Book Rating</b>(Method: book_rating) (Parameter: book_id,user_id,rate)
                <br><b>User's Rating</b>(Method: get_rating) (Parameter: user_id, book_id)
                <br><b>User's Comment</b>(Method: user_comment)(Parameter: book_id,user_id,comment_text)
                <br><b>Report Book</b>(Method: book_report)(Parameter: user_id,book_id,report)
                <br><b>User's Report</b>(Method: get_report)(Parameter: user_id, book_id)
			    <br><b>User Register</b>(Method: user_register)(Parameter: type (google,normal,facebook) name,email,password,phone,auth_id,device_id) (Parameter: user_profile)
                <br><b>User Login</b>(Method: user_login)(Parameter: email,password)
			    <br><b>User Profile</b>(Method: user_profile)(Parameter: user_id)
                <br><b>User Profile Update</b>(Method: user_profile_update)(Parameter: user_id, name, email, password, phone, is_remove[true, false]) (Parameter: user_profile)
                <br><b>Check User Status</b>(Method: user_status) (Parameter: user_id)
                <br><b>Change Password</b> (Method: change_password) (Parameters: user_id, old_password, new_password)
                <br><b>Forgot Password</b>(Method: forgot_pass)(Parameter: user_email)
                <br><b>User Contact Us</b> (Method: user_contact_us)(Parameter: contact_email, contact_name, contact_msg,contact_subject)
                <br><b>Get Contact Subject List</b> (Method: get_contact) (Parameter: user_id)
                <br><b>Related Books</b> (Method: related_books)(Parameter: ads_param, is_book [list_book,grid_book],book_id, cat_id, sub_cat_id , aid, page)
                <br><b>Book Favourite/Unfavourite</b> (Method: book_favourite) (Parameters: book_id, user_id)
                <br><b>Get Favourite List</b> (Method: get_favourite_book) (Parameters: ads_param, is_book [list_book,grid_book] , user_id, page)
                <br><b>Get Book Comments</b> (Method: get_all_comments) (Parameter: book_id, user_id, page) 
                <br><b>Book Comment Delete</b> (Method: delete_comment)(Parameter: comment_id, book_id)
                <br><b>User Continue Book</b>(Method: user_continue_book) (Parameter: user_id ,book_id)
                <br><b>User Continue List</b> (Method: get_continue_book) (Parameters: ads_param, is_book [list_book,grid_book] ,user_id, page)
                <br><b>App Privacy Policy</b> (Method: app_privacy_policy)
			    <br><b>App About Details</b>(Method: app_about)
			    <br><b>App Details</b>(Method: get_app_details)
       			</code> 
                </pre>
       		  </div>
          	</div>
        </div>
	</div>
  <br/>
  	
<div class="clearfix"></div>
        
<?php include("includes/footer.php");?>       
