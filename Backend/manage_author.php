<?php $page_title="Manage Author";
	  $current_page="author";
  	  $active_page="books";

include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

	
 if(isset($_POST['author_search']))
   {
     
     $keyword = filter_var($_POST['search_value'], FILTER_SANITIZE_STRING);

      $author_qry="SELECT * FROM tbl_author WHERE tbl_author.`author_name` LIKE '%$keyword%' ORDER BY tbl_author.`author_id` DESC";  
               
      $result=mysqli_query($mysqli,$author_qry);
    
   }
   else
   {
      $tableName="tbl_author";   
      $targetpage = "manage_author.php";   
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
      
      
     $author_qry="SELECT * FROM tbl_author
                ORDER BY tbl_author.`author_id` DESC LIMIT $start, $limit";  
                
     $result=mysqli_query($mysqli,$author_qry);
     
  }

  function get_total_item($aid)
  { 
    global $mysqli;   

    $sql="SELECT COUNT(*) as num FROM tbl_books WHERE `aid`='".$aid."'";
     
    $total_items = mysqli_fetch_array(mysqli_query($mysqli,$sql));
    $total_items = $total_items['num'];
     
    return $total_items;

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
				<input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
				<button type="submit" name="author_search" class="btn-search"><i class="fa fa-search"></i></button>
			  </form>  
			</div>
			<div class="add_btn_primary"> <a href="add_author.php?add=yes">Add Author</a> </div>
		  </div>
		</div>
	  </div>
	  <div class="clearfix"></div>
	  <div class="col-md-12 mrg-top">
		<div class="row">
		  <?php 
			$i=0;
			while($row=mysqli_fetch_array($result))
			{?>
		  <div class="col-lg-3 col-sm-6 col-xs-12">
			<div class="block_wallpaper">
			  <div class="wall_image_title">
				 <p><?php echo $row['author_name'];?>  <span>(<?php echo get_total_item($row['author_id']);?>)</span></p>
				<ul>
				  <li><a href="add_author.php?author_id=<?php echo $row['author_id'];?>&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
				  <li>
					<a href="javascript:void(0)" data-id="<?php echo $row['author_id'];?>" data-toggle="tooltip" data-tooltip="Delete" class="btn_delete_a"><i class="fa fa-trash"></i>
					</a>
				  </li>
				  <?php if($row['status']!="0"){?>
				  <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['author_id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

				  <?php }else{?>
				  
				  <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['author_id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
			  
				  <?php }?>

				</ul>
			  </div>
			  <span><img src="images/<?php echo $row['author_image'];?>" style="height:240px"/></span>
			</div>
		  </div>
	  <?php $i++; } ?>     
	  </div>
	  </div>
		<div class="col-md-12 col-xs-12">
		<div class="pagination_item_block">
		  <nav>
			<?php if(!isset($_POST["author_search"])){ include("pagination.php");}?>                 
		  </nav>
		</div>
	  </div>
	  <div class="clearfix"></div>
	</div>
  </div>
</div>
        
<?php include("includes/footer.php");?>  

<script type="text/javascript">

  $(".toggle_btn a").on("click",function(e){
      e.preventDefault();
      
      var _for=$(this).data("action");
      var _id=$(this).data("id");
      var _column=$(this).data("column");
      var _table='tbl_author';

      $.ajax({
        type:'post',
        url:'processdata.php',
        dataType:'json',
        data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'author_id'},
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
      var _tbl_nm='tbl_author';

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
              data:{id:_ids,'action':'removeData','tbl_nm':_tbl_nm,'tbl_id':'author_id'},
              success:function(res){
                location.reload();
              }
            });

          } 
        }
      });
      confirmDlg.show();
    });

</script>     