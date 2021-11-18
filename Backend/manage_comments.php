<?php $page_title="Manage Comments";

include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	function book_info($book_id)
	{
		global $mysqli;

		$query="SELECT * FROM tbl_books WHERE tbl_books.`id`='$book_id'";
		$sql = mysqli_query($mysqli,$query)or die(mysqli_error());
		$row=mysqli_fetch_assoc($sql);

		return stripslashes($row['book_title']);
	}
    
	function total_comments($book_id)
	{
		global $mysqli;

		$query="SELECT COUNT(*) AS total_comments FROM tbl_comments WHERE `book_id`='$book_id'";
		$sql = mysqli_query($mysqli,$query) or die(mysqli_error());
		$row=mysqli_fetch_assoc($sql);
		
		return stripslashes($row['total_comments']);
	}
	 
	$tableName="tbl_comments";		
	$targetpage = "manage_comments.php"; 	
	$limit = 15; 
	
	$query = "SELECT COUNT(*) as num FROM $tableName GROUP BY `book_id`";
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
	
	
 	$users_qry="SELECT comment.`id`, comment.`book_id`, max(comment.`comment_on`) as comment_on FROM
				tbl_comments comment
				LEFT JOIN tbl_users user 
				ON comment.`user_id`=user.`id`
				GROUP BY comment.`book_id`
				ORDER BY comment.`id` DESC LIMIT $start, $limit";
	  
	$users_result=mysqli_query($mysqli,$users_qry);
	
?>
<link rel="stylesheet" type="text/css" href="assets/css/stylish-tooltip.css">

<style>
#applied_user .dataTables_wrapper .top{
	position: relative;
	width: 100%;
}	
.dataTables_wrapper .top{
	margin-top: -25px;
	padding-right: 15px;
}
</style>

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
            <table class="datatable table table-striped table-bordered table-hover">
              <thead>
              <tr>
              	<th style="width:40px">
		          <div class="checkbox" style="margin: 0px">
				    <input type="checkbox" name="checkall" id="checkall_input" value="">
				    <label for="checkall_input"></label>
				  </div>
			  	</th>		
  				  <th>Book Title</th>
 				  <th>Total Comment</th>	
				  <th>Last Comment</th>	 
                  <th class="cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
              		
              		$i=0;
					while($users_row=mysqli_fetch_array($users_result))
					{?>
				  <tr class="<?=$users_row['book_id']?>">
				  	<td> 
					<div class="checkbox">
						<input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $users_row['book_id']; ?>" class="post_ids">
						<label for="checkbox<?php echo $i;?>"></label>
					</div>
					</td>
		           	<td>
		           		<?php echo book_info($users_row['book_id']);?>		
		           	</td>
					<td>
		           		<a href="view_comments.php?book_id=<?=$users_row['book_id']?>"><?php echo total_comments($users_row['book_id']);?> Comments</a>
		           	</td>
		           	<td>
		           		<?=date('d-m-Y',$users_row['comment_on']);?>
		           	</td>
				    <td> 
						<a href="javascript:void(0)" data-id="<?php echo $users_row['book_id'];?>" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a> 
				    </td>
                </tr>
               <?php $i++; }  ?>
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


<?php include('includes/footer.php');?>

<script type="text/javascript">
// for multiple actions on comments
$(".btn_delete_all").click(function(e){
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
            var _table='tbl_restaurants';

            $.ajax({
              type:'post',
              url:'processdata.php',
              dataType:'json',
              data:{ids:_ids,'action':'removeAllComment'},
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

  $(".btn_delete").click(function(e){
      e.preventDefault();

      var _id=$(this).data("id");

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
              data:{book_id:_id,'action':'removeComment'},
              success:function(res){
                location.reload();
              }
            });
          } 
        }
      });
      confirmDlg.show();
    });

var totalItems=0;

	{$("#checkall_input").click(function () {
	
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
	}

</script>                  