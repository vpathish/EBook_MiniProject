<?php   
  
    $page_title="Verify Purchase";

    include("includes/header.php");
    require("includes/function.php");
    require("language/language.php");
   
    $qry="SELECT * FROM tbl_settings WHERE id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);

    if(isset($_POST['verify_purchase_submit']))
    {

        $data = array
                (
                  'envato_buyer_name' => $_POST['envato_buyer_name'],
                  'envato_purchase_code' => $_POST['envato_purchase_code'],
                  'package_name' => trim($_POST['package_name'])
                );
  
        $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");

        $_SESSION['msg']="11";
        header( "Location:verification.php");
        exit;
    }


?>
 
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
          <div class="card-body">
          
              <form action="" name="verify_purchase" method="post" class="form form-horizontal" enctype="multipart/form-data" id="api_form">
                <input type="hidden" class="current_tab" name="current_tab">
                <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-4 control-label">Envato Username :-
                      <p class="control-label-help" style="margin-bottom: 5px">https://codecanyon.net/user/<u style="color: #e91e63">viaviwebtech</u></p>
                      <p class="control-label-help">(<u style="color: #e91e63">viaviwebtech</u> is username)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="envato_buyer_name" readonly id="envato_buyer_name" value="<?php echo $settings_row['envato_buyer_name'];?>" class="form-control" placeholder="viaviwebtech">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Envato Purchase Code :-

                      <p class="control-label-help">(<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">Where Is My Purchase Code?</a>)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="envato_purchase_code" id="envato_purchase_code" value="<?php echo $settings_row['envato_purchase_code'];?>" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Android Package Name :-
                      <p class="control-label-help">(More info in Android Doc)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="package_name" id="package_name" value="<?php echo $settings_row['package_name'];?>" class="form-control" placeholder="com.example.myapp">
                    </div>
                  </div>
                   
                  <div class="form-group">
                  <div class="col-md-9 col-md-offset-4">
                    <button type="submit" name="verify_purchase_submit" class="btn btn-primary">Save</button>
                  </div>
                  </div>
                </div>
                </div>

              </form>
              <br/>
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
              <h4 id="oh-snap!-you-got-an-error!">Note:<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
                  <p style="margin-bottom: 10px"><i class="fa fa-hand-o-right"></i> Buyer name and purchase code should match and package name same in android project otherwise application not work</p> 
              </div>
          </div>
        </div>
      </div>
    </div>

        
<?php include("includes/footer.php");?> 
