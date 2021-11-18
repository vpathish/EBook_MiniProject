<?php $page_title="Manage Books";
	  $current_page="Books";
  	  $active_page="books";

include('includes/header.php'); 
require('includes/function.php');
require('language/language.php');  

   //Get all books
   if(isset($_GET['filter']))
   {
		if($_GET['filter']=='enable'){
		  $status="tbl_books.`status`='1'";
		}else if($_GET['filter']=='disable'){
		  $status="tbl_books.`status`='0'";
		}
  
      $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE  $status ORDER BY tbl_books.`id` DESC";                 
    
      if(isset($_GET['cat_id']) && !isset($_GET['author_id'])){

        $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE $status AND tbl_books.`cat_id`='".$_GET['cat_id']."' ORDER BY tbl_books.`id` DESC";  

      }
      else if(!isset($_GET['cat_id']) && isset($_GET['author_id'])){

        $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE $status AND tbl_books.`aid`='".$_GET['author_id']."' ORDER BY tbl_books.`id` DESC"; 
      }
      else if(isset($_GET['cat_id']) && isset($_GET['author_id'])){

        $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE $status AND tbl_books.`aid`='".$_GET['author_id']."'  AND tbl_books.`cat_id`='".$_GET['cat_id']."' ORDER BY tbl_books.`id` DESC";
      }

      $result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));

   }
   else if(isset($_GET['cat_id'])){

      $cat_id=$_GET['cat_id'];

      $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid`
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id`  
                  WHERE tbl_books.`cat_id`='$cat_id' ORDER BY tbl_books.`id` DESC";

      if(!isset($_GET['filter']) && isset($_GET['author_id'])){

        $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                  LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE tbl_books.`cat_id`='$cat_id' AND tbl_books.`aid`='".$_GET['author_id']."' ORDER BY tbl_books.`id` DESC"; 
      }                 
 
      $result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));
   }
else if(isset($_GET['author_id'])){

      $sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
                  LEFT JOIN tbl_category ON tbl_books.`cat_id`= tbl_category.`cid` 
                   LEFT JOIN tbl_author ON tbl_books.`aid`= tbl_author.`author_id` 
                  WHERE tbl_books.`aid`='".$_GET['author_id']."' ORDER BY tbl_books.`id` DESC";              
      $result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));
   }
else if(isset($_POST['data_search'])){
		
	$keyword = addslashes(trim($_POST['search_value']));

	$sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books,tbl_category,tbl_author WHERE tbl_books.`aid` = tbl_author.`author_id` AND   tbl_books.`cat_id` = tbl_category.`cid` AND (tbl_books.`book_title` LIKE '%$keyword%' OR tbl_author.`author_name` LIKE '%$keyword%') ORDER BY tbl_books.`book_title` DESC";  

	$result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));

}
else
{
	
	$tableName="tbl_books";   
	$targetpage = "manage_books.php";   
	$limit = 12; 

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

	$sql_query="SELECT tbl_author.`author_name`,tbl_category.`category_name`,tbl_books.* FROM tbl_books
	LEFT JOIN tbl_category ON tbl_books.`cat_id` = tbl_category.`cid` 
	LEFT JOIN tbl_author ON tbl_books.`aid` = tbl_author.`author_id` 
	ORDER BY tbl_books.`id` DESC LIMIT $start, $limit";

	$result = mysqli_query($mysqli, $sql_query) or die(mysqli_error($mysqli));

}

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
            <div class="col-md-7 col-xs-12">              
	          <div class="search_list">
	            <div class="search_block">
	              <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	               <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="search_value" value="<?php if (isset($_POST['search_value'])) { echo $_POST['search_value']; } ?>" required="required">
                	<button type="submit" name="data_search"  class="btn-search"><i class="fa fa-search"></i></button>
	              </form>  
	            </div>
	            <div class="add_btn_primary"> <a href="add_book.php">Add Book</a> </div>
	          </div>
            </div>
           <form id="filterForm" accept="" method="GET" style="clear:both">
			<div class="col-md-3"> 
				<select name="filter" class="form-control select2 filter" required style="padding: 5px 30px;height: 40px;">
					<option value="">All</option>
					<option value="enable" <?php if(isset($_GET['filter']) && $_GET['filter']=='enable'){ echo 'selected';} ?>>Enable</option>
					<option value="disable" <?php if(isset($_GET['filter']) && $_GET['filter']=='disable'){ echo 'selected';} ?>>Disable</option>
				</select>
			</div>
			<div class="col-md-3"> 
				<select name="cat_id" class="form-control select2 filter" required style="padding: 5px 40px;height: 40px;">
					<option value="">All Category</option>
					<?php
					$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
					$cat_result=mysqli_query($mysqli,$cat_qry);
					while($cat_row=mysqli_fetch_array($cat_result))
					{?>                       
					<option value="<?php echo $cat_row['cid'];?>" <?php if(isset($_GET['cat_id']) && $_GET['cat_id']==$cat_row['cid']){echo 'selected';} ?>><?php echo $cat_row['category_name'];?></option>                           
						<?php } ?>
				</select>
			</div>
			<div class="col-md-3"> 
				<select name="author_id" class="form-control select2 filter" required style="padding: 5px 40px;height: 40px;">
					<option value="">All Author</option>
					<?php
					$auth_qry="SELECT * FROM tbl_author ORDER BY `author_name`";
					$auth_result=mysqli_query($mysqli,$auth_qry);
					while($auth_row=mysqli_fetch_array($auth_result))
					{?>                       
					<option value="<?php echo $auth_row['author_id'];?>" <?php if(isset($_GET['author_id']) && $_GET['author_id']==$auth_row['author_id']){echo 'selected';} ?>><?php echo $auth_row['author_name'];?></option>
					<?php }	?>
				</select>
			</div>
			</form>
            <div class="col-md-3 col-xs-12" style="float: right;width: 18%">
              <div class="checkbox" style="width: 100px;margin-top: 8px;margin-left: 10px;float: left;right: 90px;position: absolute;">
                  <input type="checkbox" id="checkall_input">
                  <label for="checkall_input">
                      Select All
                  </label>
                </div>
                <div class="dropdown" style="float:right">
                  <button class="btn btn-primary dropdown-toggle btn_delete" type="button" data-toggle="dropdown">Action
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu" style="right:0;left:auto;">
                    <li><a href="" class="actions" data-action="enable">Enable</a></li>
                    <li><a href="" class="actions" data-action="disable">Disable</a></li>
                    <li><a href="" class="actions" data-action="delete">Delete !</a></li>
                  </ul>
                </div>
            </div>
        </div>
          <div class="clearfix"></div>
          
          <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
	            $i=0;
	            while($books_row=mysqli_fetch_array($result))
	            {?>
              <div class="col-lg-3 col-sm-4 col-xs-12">
                <div class="block_wallpaper">
                  <div class="wall_category_block">
                    <h2><?php echo $books_row['category_name'];?></h2>  
                    <div class="checkbox" style="float: right;margin-left: 10px">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $books_row['id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>">
                      </label>
                    </div> 
                    </div>
                  <div class="wall_image_title">
                     <p style="font-size: 16px;text-shadow: 0px 1px 1px #000">
                     	<?php
                        if(strlen($books_row['book_title']) > 25){
                          echo mb_substr(stripslashes($books_row['book_title']), 0, 20).'...';  
                        }else{
                          echo $books_row['book_title'];
                        }
                      	?>
                     </p>
                     <p style="margin-bottom: 0px">
                     	By 
                     	<?php
                        if(strlen($books_row['author_name']) > 25){
                          echo mb_substr(stripslashes($books_row['author_name']), 0, 25).'...';  
                        }else{
                          echo $books_row['author_name'];
                        }
                      	?>
                    </p>
                    <ul>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $books_row['book_views'];?> Views"><i class="fa fa-eye"></i></a></li>                      
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $books_row['rate_avg'];?> Rating"><i class="fa fa-star"></i></a></li>
 
                     <li><a href="edit_book.php?book_id=<?php echo $books_row['id'];?>&action=edit&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                      <li>
                      <a href="" data-id="<?php echo $books_row['id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn_delete_a"><i class="fa fa-trash"></i>
                        </a>
                      </li>

                      <?php if($books_row['status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="" data-id="<?php echo $books_row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>
                      
                      <li><div class="row toggle_btn"><a href="" data-id="<?php echo $books_row['id'];?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                  
                      <?php }?>
                    </ul>
                  </div>
                  <span><img src="images/<?php echo $books_row['book_cover_img'];?>" /></span>
                </div>
              </div>
            <?php $i++; } ?>     
      		</div>
      		</div>
    	   </form>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
              	<?php if(!isset($_POST["books_search"])){ include("pagination.php");}?>
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>     

<?php include('includes/footer.php');?>  

<script type="text/javascript">

  $(".toggle_btn a").on("click",function(e){
    e.preventDefault();
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_books';
    
    $.ajax({
      type:'post',
      url:'processdata.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
      success:function(res){
          console.log(res);
          if(res.status=='1'){
            location.reload();
          }
        }
    });

  });

$(".toggle_btn_a").on("click",function(e){
      e.preventDefault();
      var _for=$(this).data("action");
      var _id=$(this).data("id");
      var _column=$(this).data("column");
      var _table='tbl_books';
      
      $.ajax({
        type:'post',
        url:'processdata.php',
        dataType:'json',
  		data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
          success:function(res){
            console.log(res);
            if(res.status=='1'){
              location.reload();
            }
          }
      });
  });

$(".btn_delete_a").click(function(e){
      e.preventDefault();

      var _ids=$(this).data("id");
    
        confirmDlg = duDialog('Are you sure?', 'All data will be removed which belong to this!', {
        init: true,
        dark: false, 
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
            $.ajax({
              type:'post',
              url:'processdata.php',
              dataType:'json',
              data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_books'},
              success:function(res){
                location.reload();
              }
            });

          } 
        }
      });
      confirmDlg.show();
    });

// for multiple actions on Books
$(".actions").click(function(e){
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
    var _action=$(this).data("action");

    if(_ids!='')
    {
      confirmDlg = duDialog('Action: '+$(this).text(), 'Do you really want to perform?', {
        init: true,
        dark: false, 
        buttons: duDialog.OK_CANCEL,
        okText: 'Proceed',
        callbacks: {
          okClick: function(e) {
            $(".dlg-actions").find("button").attr("disabled",true);
            $(".ok-action").html('<i class="fa fa-spinner fa-pulse"></i> Please wait..');
            var _table='tbl_books';

            $.ajax({
              type:'post',
              url:'processdata.php',
              dataType:'json',
              data:{id:_ids,for_action:_action,table:_table,'action':'multi_action'},
              success:function(res){
                $('.notifyjs-corner').empty();
                if(res.status=='1'){
                  location.reload();
                }
              }
            });

          } 
        }
      });
      confirmDlg.show();
    }
    else{
      infoDlg = duDialog('Opps!', 'No data selected', { init: true });
      infoDlg.show();
    }
  });

var totalItems=0;

	$("#checkall_input").click(function () {

		totalItems=0;

		$("input[name='post_ids[]']").prop('checked', this.checked);

		$.each($("input[name='post_ids[]']:checked"), function(){
			totalItems=totalItems+1;
		});


		if($("input[name='post_ids[]']").prop("checked") == true){
			$('.notifyjs-corner').empty();
			$.notify(
				'Total '+totalItems+' item checked',
				{ position:"top center",className: 'success'}
				);
		}
		else if($("input[name='post_ids[]']").prop("checked") == false){
			totalItems=0;
			$('.notifyjs-corner').empty();
		}
	});

	var noteOption = {
		clickToHide : false,
		autoHide : false,
	}

	$.notify.defaults(noteOption);

	$(".post_ids").click(function(e){

		if($(this).prop("checked") == true){
			totalItems=totalItems+1;
		}
		else if($(this). prop("checked") == false){
			totalItems = totalItems-1;
		}

		if(totalItems==0){
			$('.notifyjs-corner').empty();
			exit;
		}

		$('.notifyjs-corner').empty();

		$.notify(
			'Total '+totalItems+' item checked',
			{ position:"top center",className: 'success'}
			);
	});

	$(".filter").on("change", function(e) {
		$("#filterForm *").filter(":input").each(function() {
			if ($(this).val() == '')
				$(this).prop("disabled", true);
		});
		$("#filterForm").submit();
	});

</script>                