<?php $page_title="Manage User Continue";

include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");
  
  function get_user_info($user_id)
   {
    global $mysqli;

     
    $user_qry="SELECT * FROM tbl_users WHERE `id`='".$user_id."'";
    $user_result=mysqli_query($mysqli,$user_qry);
    $user_row=mysqli_fetch_assoc($user_result);

    return $user_row;
   }
    
	  // Get page data
	  $tableName="tbl_user_continue";    
	  $targetpage = "manage_user_continue.php";  
	  $limit = 15; 
	  
	  $query = "SELECT COUNT(*) as num FROM $tableName";
	  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
	  $total_pages = $total_pages['num'];
	  
	  $stages = 3;
	  $page=0;
	  if(isset($_GET['page'])){
	  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
	  }
	  if($page){
	    $start = ($page - 1) * $limit; 
	  }else{
	    $start = 0; 
	    }

	 $qry="SELECT tbl_user_continue.*,tbl_books.`book_title` FROM tbl_user_continue
	        LEFT JOIN tbl_books ON tbl_user_continue.`book_id` = tbl_books.`id`
	        LEFT JOIN tbl_users ON tbl_user_continue.`user_id`= tbl_books.`id`
	        GROUP BY tbl_user_continue.`book_id`
	        ORDER BY tbl_user_continue.`con_id` DESC LIMIT $start, $limit";   
	  $result=mysqli_query($mysqli,$qry);
	 
   
?>
    <div class="row">
      <div class="col-xs-12">
      	<?php
      	if(isset($_SERVER['HTTP_REFERER']))
      	{
      		echo '<a href="'.$_SERVER['HTTP_REFERER'].'"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      	}
      	?>
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
             
          </div>
          <div class="clearfix"></div>
         
          <div class="col-md-12 mrg-top">
          	<button class="btn btn-danger btn_cust btn_delete_all" style="margin-bottom:20px;"><i class="fa fa-trash"></i> Delete All</button>
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
            	<th style="width:40px">
                <div class="checkbox" style="margin: 0px">
                  <input type="checkbox" name="checkall" id="checkall" value="">
                  <label for="checkall"></label>
                </div>
                  </th> 
                  <th>Name</th>
                  <th>Email</th>
                  <th>Book Name</th>
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
				      $i=0;
				      while($row=mysqli_fetch_array($result))
				      {?>

                	<tr>
                	<td> 
                    <div class="checkbox">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['book_id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>"></label>
                    </div>
                  </td>
                  <td><?php echo get_user_info($row['user_id'])['name'];?></td>
                  <td><?php echo get_user_info($row['user_id'])['email'];?></td>
                  <td><?php echo $row['book_title'];?></td>
                  <td>	
                   <a href="" data-id="<?=$row['book_id']?>" class="btn btn-danger btn_delete"><i class="fa fa-trash"></i> Delete All
                          </a>
                  </td>
                </tr>
               <?php
						
						$i++;
						}
			   ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
              	<?php if(!isset($_POST["search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>            
               
        
<?php include("includes/footer.php");?>       

<script type="text/javascript">

  // for multiple deletes
  $(".btn_delete_all").click(function(e){
    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
    if(_ids!='')
    {
      swal({
            title: "Are you sure to delete?",
            text: "User Continue of that records will be deleted !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger btn_edit",
            cancelButtonClass: "btn-warning btn_edit",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
          },

          function(isConfirm) {
            if (isConfirm) {
              $.ajax({
                type:'post',
                url:'processdata.php',
                dataType:'json',
                data:{book_id:_ids,'action':'removeAllContinue'},
                success:function(res){
                    console.log(res);
                    if(res.status=='1'){
                      location.reload();
                    }
                    else{
                      swal("Something went to wrong !");
                    }
                  }
              });
            }
            else{
              swal.close();
            }

          });
    }
    else{
      swal("Sorry no records selected !!")
    }
  });


   // for single comment row delete
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id = $(this).data('id');
      if(_id!='')
      {
        swal({
              title: "Are you sure to delete?",
              text: "User Continue of this records will be deleted !",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger btn_edit",
              cancelButtonClass: "btn-warning btn_edit",
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              closeOnConfirm: false,
              closeOnCancel: false,
              showLoaderOnConfirm: true
            },
            function(isConfirm) {
              if (isConfirm) {
                $.ajax({
                  type:'post',
                  url:'processdata.php',
                  dataType:'json',
                  data:{book_id:_id,'action':'removeContinue'},
                  success:function(res){
                      console.log(res);
                      if(res.status=='1'){
                        location.reload();
                      }
                      else{
                        swal("Something went to wrong !");
                      }
                    }
                });
              }
              else{
                swal.close();
              }

            });
      }
      else{
        swal("Sorry no records selected !!")
      }
  });
</script>
