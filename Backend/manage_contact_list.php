<?php  
	$page_title="Contact List";
	
	include("includes/header.php");
	require("language/language.php");
		
?>

<style type="text/css">
	.dataTables_wrapper .top{
		padding-top: 0px !important;
	}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
		  <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom" style="padding: 0px"> 

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px">
                <li role="presentation" class="active"><a href="#subject_list" aria-controls="comments" role="tab" data-toggle="tab">Subjects List</a></li>
                <li role="presentation"><a href="#contact_list" aria-controls="contact_list" role="tab" data-toggle="tab">Contact Forms</a></li>
            </ul>
            <div class="col-md-12 mrg-top">
            	<div class="tab-content">
	              <div role="tabpanel" class="tab-pane active" id="subject_list">
	              	<div class="add_btn_primary"> <a href="contact_subject.php?add" class="btn_cust">Add Subject</a></div>
	              	<div class="clearfix"></div>
	              	<br/>
	              	
	               	<table class="table table-striped table-bordered table-hover">
					    <thead>
					      <tr>
					      	<th width="100">Sr No.</th>
					        <th>Subject Title</th>
					        <th class="cat_action_list" style="width:60px">Action</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php 
					    	$sql="SELECT * FROM tbl_contact_sub ORDER BY `id` DESC";
					    	$res=mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
					    	$no=1;
					    	while ($row=mysqli_fetch_assoc($res)) {
					    	?>
					    	<tr>
					    		<td><?=$no++?></td>
					    		<td><?=$row['title']?></td>
					    		<td nowrap="">
			                      <a href="contact_subject.php?edit_id=<?php echo $row['id'];?>" class="btn btn-primary btn_edit"><i class="fa fa-edit"></i></a>

				          		 <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn_delete_a btn_cust" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
			                  	</td>
					    	</tr>
					    	<?php }?>
					    </tbody>
					</table>
	              </div>
	              	<div class="clearfix"></div>
		              <!-- for contact list tab -->
	              <div role="tabpanel" class="tab-pane" id="contact_list">
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
				        <th>Name</th>
				        <th>Email</th>	
				        <th>Subject</th>		
				        <th>Message</th>
				        <th>Date</th>
				        <th class="cat_action_list" style="width:60px">Action</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<?php
				    	
				        $users_qry="SELECT tbl_contact_list.*, sub.`title` FROM tbl_contact_list, tbl_contact_sub sub WHERE tbl_contact_list.`contact_subject`=sub.`id` ORDER BY tbl_contact_list.`id` DESC";  
						$users_result=mysqli_query($mysqli,$users_qry);
						$i=0;
						while($users_row=mysqli_fetch_array($users_result))
						{?>
				      <tr>
				       <td>  
						<div class="checkbox">
							<input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $users_row['id']; ?>" class="post_ids">
							<label for="checkbox<?php echo $i;?>"></label>
						</div>
					   	</td>	
				       	<td><?php echo ucwords($users_row['contact_name']);?></td>
				       	<td><?php  echo $users_row['contact_email'];?></td>
				       	<td><?php echo $users_row['title'];?></td>
				       	<td><?php
                        if (strlen($users_row['contact_msg']) > 20) {
                          echo substr(stripslashes($users_row['contact_msg']), 0, 20) . '...'; ?>

				       	<a href="#" data-id="<?= $users_row['id'] ?>" data-toggle="modal" class="vfx-preview-btn msg_preview" data-name="<?= $users_row['contact_msg'] ?>"  data-toggle="tooltip" data-tooltip="view more" data-target="#viewmyModal">View More</a>
				       	<?php
                        } else {
                          echo $users_row['contact_msg'];
                        }
                        ?>  
                        </td>

				       	<td nowrap=""><?php echo date('d-m-Y',$users_row['created_at']);?></td>
				        <td> 
				          <a href="javascript:void(0)" data-id="<?php echo $users_row['id'];?>" class="btn btn-danger btn_delete" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></td>
				      </tr>
				     <?php $i++; }?>
				    </tbody>
				   </table>
	              </div>
	            </div>
            </div>
          </div>
    	</div>
	</div>
</div>

<div id="viewmyModal" class="modal fade memes_item" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		 <div class="row">
			 <div class="col-md-12">
			  <h4>Message:</h4>
			  <ul class="large-ads-item">
				<li><span class="showmsg" data-title=""></span></li>
			  </ul>
			  <br>
			</div>
		 </div>	
	  <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

  $(document).ready(function() {
    $('.msg_preview').on('click', function() {
      var _id = $(this).data("id");
      var _name = $(this).data('name');

      $('#viewmyModal').on('show.bs.modal', function() {
        $(".showmsg").text(_name);
      });
    });
  });

// for multiple actions on contacts
$(".btn_delete_all").click(function(e){
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });

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
              data:{ids:_ids,'action':'removeContact'},
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
              data:{ids:_ids,'action':'removeContact'},
              success:function(res){
                location.reload();
              }
            });
          } 
        }
      });
      confirmDlg.show();
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
              data:{ids:_ids,'action':'removesubContact'},
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
	 
</script>

