<?php $page_title="Edit Report";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");

require_once("thumbnail_images.class.php");


if(isset($_GET['report_id']))
{

	$qry="SELECT * FROM tbl_report WHERE id='".$_GET['report_id']."'";
	$result=mysqli_query($mysqli,$qry);
	$row=mysqli_fetch_assoc($result);

}
if(isset($_POST['submit']) and isset($_POST['report_id']))
{    

	$data = array( 
		'report_book'  =>  addslashes($_POST['report_book']),
		'report_desc'  =>  addslashes($_POST['report_desc'])           
	);    


	$report_edit=Update('tbl_report', $data, "WHERE id = '".$_POST['report_id']."'");

	$_SESSION['msg']="11"; 
	header( "Location:manage_report.php?id=".$_POST['report_id']);
	exit;

}


?>
<div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="report_id" value="<?php echo $_GET['report_id'];?>" />
              <div class="section">
                <div class="section-body">
                  <div class="form-group">

                    <label class="col-md-3 control-label">Report Book :-</label>
                    <div class="col-md-6">
                      <input type="text" name="report_book" id="report_book" value="<?php if(isset($_GET['report_id'])){echo $row['report_book'];}?>" class="form-control" required>
                    </div>
                  </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Report Description :-</label>
                    <div class="col-md-6">
                      <textarea name="report_desc" id="report_desc" class="form-control"><?php echo stripslashes($row['report_desc']);?></textarea>

                      <script>CKEDITOR.replace( 'report_desc' );</script>
                    </div>
                  </div>                             
                    </div><br>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php include("includes/footer.php");?>       
