<?php $page_title="Manage Users";

include('includes/header.php'); 
include('language/language.php');  
include("includes/function.php");

	$tableName="tbl_users";   
	$targetpage = "manage_users.php"; 
	$limit = 15; 

	$keyword='';

	if(!isset($_GET['keyword'])){
		$query = "SELECT COUNT(*) as num FROM $tableName";
	}
	else{

		$keyword=addslashes(trim($_GET['keyword']));

		$query = "SELECT COUNT(*) as num FROM $tableName WHERE (`name` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `phone` LIKE '%$keyword%') AND id <> 0";

		$targetpage = "manage_users.php?keyword=".$_GET['keyword'];

	}

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

	if(!isset($_GET['keyword'])){
		$sql_query="SELECT * FROM tbl_users WHERE  id <> 0 ORDER BY tbl_users.`id` DESC LIMIT $start, $limit"; 
	}
	else{

		$sql_query="SELECT * FROM tbl_users WHERE (`name` LIKE '%$keyword%' OR `email` LIKE '%$keyword%' OR `phone` LIKE '%$keyword%') AND  id <> 0 ORDER BY tbl_users.`id` DESC LIMIT $start, $limit"; 
	}

	$result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));



function highlightWords($text, $word){
	    $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
	    return $text;
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
              <form method="get" action="">
                <input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php if(isset($_POST['keyword'])){ echo $_POST['keyword']; } ?>" required>
                <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
              </form>
            </div>
            <div class="add_btn_primary"> <a href="add_user.php?add">Add User</a> </div>
          </div>
        </div>
       <div class="col-md-4 col-xs-12 text-right" style="float: right;">
          <div class="checkbox" style="width: 95px;margin-top: 5px;margin-left: 10px;right: 100px;position: absolute;">
            <input type="checkbox" id="checkall_input">
            <label for="checkall_input">
                Select All
            </label>
          </div>
          <div class="dropdown" style="float:right">
            <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown">Action
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
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th nowrap="" style="width:40px">
                <div class="checkbox" style="margin-top: 0px;margin-bottom: 0px;">
                  <input type="checkbox" name="checkall" id="checkall" value="">
                  <label for="checkall"></label>
                </div>
              </th>
              <th>User Type</th>
              <th>Device ID</th>
              <th>Name</th>
              <th>Email/Google/Facebook ID</th>
              <th>Phone</th>
              <th>Status</th>
              <th class="cat_action_list" style="width:200px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php           
				$i=0;
				while($users_row=mysqli_fetch_array($result))
				{
					$device_id = !empty($keyword)?highlightWords($users_row['device_id'], $keyword):$users_row['device_id'];
					$name = !empty($keyword)?highlightWords($users_row['name'], $keyword):$users_row['name'];

					if($users_row['email']!='' AND $users_row['user_type']=='Normal')
					{
						$email = !empty($keyword)?highlightWords($users_row['email'], $keyword):$users_row['email'];	
					}
					else if($users_row['user_type']=='Google'){
						if($users_row['user_type']=='Google' AND $users_row['email']=='' AND $users_row['auth_id']!=''){
							$email = !empty($keyword)?highlightWords($users_row['auth_id'], $keyword):$users_row['auth_id'];
						}
						else{
							$email = !empty($keyword) ? highlightWords($users_row['email'], $keyword):$users_row['email'];
						}
						
					}
					else if($users_row['user_type']=='Facebook'){
						if($users_row['user_type']=='Facebook' AND $users_row['email']=='' AND $users_row['auth_id']!=''){
							$email = !empty($keyword)?highlightWords($users_row['auth_id'], $keyword):$users_row['auth_id'];
						}
						else{
							$email = !empty($keyword)?highlightWords($users_row['email'], $keyword):$users_row['email'];
						}
						
					} 
				?>
              <tr <?php if($users_row['is_duplicate']==1){ echo 'style="background-color: rgba(255,0,0,0.1);"'; } ?>>
                <td nowrap="">
                  <div class="checkbox" style="margin: 0px;float: left;">
                    <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i; ?>" value="<?php echo $users_row['id']; ?>" class="post_ids">
                    <label for="checkbox<?php echo $i; ?>">
                    </label>
                  </div>
                </td>
                <td><?php echo $users_row['user_type']; ?></td>
                <td><?php echo $device_id;?></td>
                <td><a href="user_profile.php?user_id=<?= $users_row['id'] ?>">
				 <?php echo $users_row['name'];?> </a></td>
                <td><?php echo $users_row['email']; ?></td>
                <td><?php echo $users_row['phone']; ?></td>
                <td>
                  <?php if ($users_row['status'] != "0") { ?>
                    <a title="Change Status" class="toggle_btn_a" href="javascript:void(0)" data-id="<?= $users_row['id'] ?>" data-action="deactive" data-column="status"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Enable</span></span></a>

                  <?php } else { ?>
                    <a title="Change Status" class="toggle_btn_a" href="javascript:void(0)" data-id="<?= $users_row['id'] ?>" data-action="active" data-column="status"><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Disable </span></span></a>
                  <?php } ?>
                </td>
                <td>
                 <a href="user_profile.php?user_id=<?=$users_row['id']?>" data-id="<?php echo $users_row['id'];?>" class="btn btn-success btn_edit" data-toggle="tooltip" data-tooltip="Profile"><i class=" fa fa-history"></i></a>

                 <a href="add_user.php?user_id=<?php echo $users_row['id']; ?>" class="btn btn-primary btn_cust" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a>
                 <a href="javascript:void(0)" data-id="<?php echo $users_row['id']; ?>" class="btn btn-danger btn_delete_a btn_cust" data-toggle="tooltip" data-tooltip="Delete !"><i class=" fa fa-trash"></i></a>
				</td>
              </tr>
            <?php $i++;
            } ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="pagination_item_block">
          <nav>
            <?php if (!isset($_POST["user_search"])) {
              include("pagination.php");
            } ?>
          </nav>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<?php include('includes/footer.php');?>                  


<script type="text/javascript">

$(".toggle_btn_a").on("click", function(e) {
    e.preventDefault();

    var _for = $(this).data("action");
    var _id = $(this).data("id");
    var _column = $(this).data("column");
    var _table = 'tbl_users';

    $.ajax({
      type: 'post',
      url: 'processdata.php',
      dataType: 'json',
      data: {id: _id,for_action: _for,column: _column,table: _table,'action': 'toggle_status','tbl_id': 'id'},
      success: function(res) {
        console.log(res);
        if (res.status == '1') {
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
              data: {id: _ids,'action': 'multi_delete','tbl_nm': 'tbl_users'},
              success:function(res){
                location.reload();
              }
            });
          } 
        }
      });
      confirmDlg.show();
    });
	
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
              var _table='tbl_users';
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

    $('input:checkbox').not(this).prop('checked', this.checked);
    $.each($("input[name='post_ids[]']:checked"), function(){
      totalItems=totalItems+1;
    });

    if($('input:checkbox').prop("checked") == true){
      $('.notifyjs-corner').empty();
      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success'}
      );
    }
    else if($('input:checkbox'). prop("checked") == false){
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
        exit();
      }

      $('.notifyjs-corner').empty();

      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success'}
      );
  });

</script>
