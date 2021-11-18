<?php $page_title="Manage Sub-Category";
	  $current_page="sub-category";
  	  $active_page="books";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");

	
  if(isset($_POST['data_search']))
   {

   	$keyword = filter_var($_POST['search_value'], FILTER_SANITIZE_STRING);

     $qry="SELECT tbl_sub_category.*,tbl_category.`category_name` FROM tbl_sub_category
           LEFT JOIN tbl_category ON tbl_sub_category.`cat_id`= tbl_category.`cid`
           WHERE tbl_sub_category.`sub_cat_name` LIKE '%$keyword%'
          ORDER BY tbl_sub_category.`sub_cat_name`";
 
     $result=mysqli_query($mysqli,$qry); 

   }
   else
   {
      $tableName="tbl_sub_category";   
      $targetpage = "manage_sub_category.php"; 
      $limit = 10; 
      
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
       $quotes_qry="SELECT tbl_sub_category.*,tbl_category.`category_name` FROM tbl_sub_category
              LEFT JOIN tbl_category ON tbl_sub_category.`cat_id`= tbl_category.`cid`
              ORDER BY tbl_sub_category.`sid` DESC LIMIT $start, $limit";
     
 
     $result=mysqli_query($mysqli,$quotes_qry); 
	
}	

function get_total_item($sub_cat_id)
	{	
		global $mysqli;

		$qry_books="SELECT COUNT(*) as num FROM tbl_books WHERE `sub_cat_id` ='".$sub_cat_id."' AND `status` ='1'";
		$total_books = mysqli_fetch_array(mysqli_query($mysqli,$qry_books));
		$total_books = $total_books['num'];

		return $total_books;
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
              <div class="page_title">Manage Sub Categories</div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
              	 <div class="search_block">
                 <form  method="post" action="">
                  <input class="form-control input-sm" placeholder="Search sub-category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                   <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>
              	</div>
                <div class="add_btn_primary"> <a href="add_sub_category.php?add=yes">Add Sub Category</a> </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
         
          <div class="col-md-12 mrg-top">
            <div class="row">
              <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              { ?>
              <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="block_wallpaper add_wall_category">           
                  <div class="wall_category_block">
                    <h2><?php echo $row['category_name'];?></h2>              
                  </div>
                  <div class="wall_image_title">
                    <h2><a href="javascript:void(0)"><?php echo $row['sub_cat_name'];?> <span>(<?php echo get_total_item($row['sid']);?>)</span></a></h2>
                    <ul>                
                      <li><a href="add_sub_category.php?sub_cat_id=<?php echo $row['sid'];?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                      <li>
                      <a href="" class="btn_delete_a" data-id="<?php echo $row['sid'];?>"  data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
                      </li>          

                     <?php if($row['status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['sid']?>" class="toggle_btn_a" title="Change Status" data-action="deactive" data-toggle="tooltip" data-tooltip="ENABLE" data-column="status"><img src="assets/images/btn_enabled.png"  alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>
                      
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['sid']?>" class="toggle_btn_a" title="Change Status" data-action="active" data-toggle="tooltip"  data-tooltip="DISABLE" data-column="status"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                  
                      <?php }?>
                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['sub_cat_image'];?>" /></span>
                </div>
              </div>
          <?php
            
            $i++;
              }
        ?>     
               
      </div>
          </div>
           <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php include("pagination.php");?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>    

<script type="text/javascript">

  $(".toggle_btn_a").on("click",function(e){
      e.preventDefault();
      
      var _for=$(this).data("action");
      var _id=$(this).data("id");
      var _column=$(this).data("column");
      var _table='tbl_sub_category';

      $.ajax({
        type:'post',
        url:'processdata.php',
        dataType:'json',
        data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'sid'},
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
               data:{id:_ids,'action':'multi_delete','tbl_nm':'tbl_sub_category'},
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



