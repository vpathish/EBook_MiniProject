<?php $page_title="Dashboard";

include("includes/header.php");
include("includes/function.php");


error_reporting(0); 

$qry_cat="SELECT COUNT(*) as num FROM tbl_category";
$total_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
$total_category = $total_category['num'];

$qry_sub_cat="SELECT COUNT(*) as num FROM tbl_sub_category";
$total_sub_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_sub_cat));
$total_sub_category = $total_sub_category['num'];

$qry_books="SELECT COUNT(*) as num FROM tbl_books";
$total_books = mysqli_fetch_array(mysqli_query($mysqli,$qry_books));
$total_books = $total_books['num'];

$qry_author="SELECT COUNT(*) as num FROM tbl_author";
$total_author = mysqli_fetch_array(mysqli_query($mysqli,$qry_author));
$total_author = $total_author['num'];

$qry_user="SELECT COUNT(*) as num FROM tbl_users WHERE id <> 0";
$total_user = mysqli_fetch_array(mysqli_query($mysqli,$qry_user));
$total_user = $total_user['num'];

$qry_comment="SELECT COUNT(*) as num FROM tbl_comments";
$total_comment = mysqli_fetch_array(mysqli_query($mysqli,$qry_comment));
$total_comment = $total_comment['num'];

$qry_report="SELECT COUNT(*) as num FROM tbl_reports";
$total_report = mysqli_fetch_array(mysqli_query($mysqli,$qry_report));
$total_report = $total_report['num'];

$countStr='';

$no_data_status=false;
$count=$monthCount=0;

for ($mon=1; $mon<=12; $mon++) {

$monthCount++;

if(isset($_GET['filterByYear'])){
$year=$_GET['filterByYear'];
}
else{
$year=date('Y');
}

$month = date('M', mktime(0,0,0,$mon, 1, $year));

$sql_user="SELECT `id` FROM tbl_users WHERE `registration_on` <> 0 AND DATE_FORMAT(FROM_UNIXTIME(`registration_on`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`registration_on`), '%Y') = '$year'";

$totalcount=mysqli_num_rows(mysqli_query($mysqli, $sql_user));

$countStr.="['".$month."', ".$totalcount."], ";

if($totalcount==0){
$count++;
}

}

if($monthCount > $count){
$no_data_status=false;
}
else{
$no_data_status=true;
}

$countStr=rtrim($countStr, ", ");

    function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }


?>  
<style type="text/css">
  .table > tbody, .table > tbody > tr, .table > tbody > tr > td{
    display: block !important;
  }
</style>       
<?php 
  $sql_smtp="SELECT * FROM tbl_smtp_settings WHERE `id`='1'";
  $res_smtp=mysqli_query($mysqli,$sql_smtp);
  $row_smtp=mysqli_fetch_assoc($res_smtp);

  $smtp_warning=true;

  if(!empty($row_smtp))
  {
  	
    if($row_smtp['smtp_type']=='server'){
      if($row_smtp['smtp_host']!='' AND $row_smtp['smtp_email']!=''){
        $smtp_warning=false;
      }
      else{
        $smtp_warning=true;
      }  
    }
    else if($row_smtp['smtp_type']=='gmail'){
      if($row_smtp['smtp_ghost']!='' AND $row_smtp['smtp_gemail']!=''){
        $smtp_warning=false;
      }
      else{
        $smtp_warning=true;
      }  
    }
  }

  if($smtp_warning)
  {
?>
	<div class="row">
	  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <div class="alert alert-danger alert-dismissible fade in" role="alert">
	    <h4 id="oh-snap!-you-got-an-error!"><i class="fa fa-exclamation-triangle"></i> SMTP Setting is not config<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
	        <p style="margin-bottom: 10px">Config the smtp setting otherwise <strong>forgot password</strong> OR <strong>email</strong> feature will not be work.</p> 
	    </div>
	  </div>
	</div>
	<?php } ?>

    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_category.php" class="card card-banner card-green-light">
        <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
          <div class="content">
            <div class="title">Categories</div>
            <div class="value"><span class="sign"></span><?php echo $total_category;?></div>
          </div>
        </div>
        </a> </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_sub_category.php" class="card card-banner card-aliceblue-light">
        <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
          <div class="content">
            <div class="title">Sub-Categories</div>
            <div class="value"><span class="sign"></span><?php echo $total_sub_category;?></div>
          </div>
        </div>
        </a> </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_author.php" class="card card-banner card-yellow-light">
        <div class="card-body"> <i class="icon fa fa-users fa-4x"></i>
          <div class="content">
            <div class="title">Author</div>
            <div class="value"><span class="sign"></span><?php echo $total_author;?></div>
          </div>
        </div>
        </a> </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_books.php" class="card card-banner card-blue-light">
        <div class="card-body"> <i class="icon fa fa-book fa-4x"></i>
          <div class="content">
            <div class="title">Books</div>
            <div class="value"><span class="sign"></span><?php echo $total_books;?></div>
          </div>
        </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_users.php" class="card card-banner card-orange-light">
        <div class="card-body"> <i class="icon fa fa-users fa-4x"></i>
          <div class="content">
            <div class="title">Users</div>
            <div class="value"><span class="sign"></span><?php echo $total_user;?></div>
          </div>
        </div>
        </a> 
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_comments.php" class="card card-banner card-pink-light">
        <div class="card-body"> <i class="icon fa fa-comments fa-4x"></i>
          <div class="content">
            <div class="title">Comments</div>
            <div class="value"><span class="sign"></span><?php echo $total_comment;?></div>
          </div>
        </div>
        </a> 
      </div>

       <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_reports.php" class="card card-banner card-alicerose-light">
        <div class="card-body"> <i class="icon fa fa-comments fa-4x"></i>
          <div class="content">
            <div class="title">Reports</div>
            <div class="value"><span class="sign"></span><?php echo $total_report;?></div>
          </div>
        </div>
        </a> 
      </div>
     
    </div>

 <div class="row">
  <div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px;">
      <div class="col-lg-10">
        <h3>Users Analysis</h3>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter">
          <select class="form-control" name="filterByYear" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
            <?php 
              $currentYear=date('Y');
              $minYear=2018;

              for ($i=$currentYear; $i >= $minYear ; $i--) { 
                ?>
                <option value="<?=$i?>" <?=(isset($_GET['filterByYear']) && $_GET['filterByYear']==$i) ? 'selected' : ''?>><?=$i?></option>
                <?php
              }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
          if($no_data_status){
            ?>
            <h3 class="text-muted text-center" style="padding-bottom: 2em">No data found !</h3>
            <?php
          }
          else{
            ?>
            <div id="registerChart">
              <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
            </div>
            <?php    
          }
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
      <h3>Most viewed Books</h3>
      <p>Books with more views.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_video="SELECT id,book_title, book_cover_img, book_views FROM tbl_books
                      WHERE `book_views` > 5 ORDER By tbl_books.`book_views` DESC LIMIT 8";
                     

          $res=mysqli_query($mysqli, $sql_video);

          while($row_data=mysqli_fetch_assoc($res)){

              $data['id']=$row_data['id'];
              $data['book_title']=$row_data['book_title'];
              $data['book_cover_img']=$row_data['book_cover_img'];
              $data['book_views']=$row_data['book_views'];
             
              array_push($statuses, $data);
          }
           mysqli_free_result($res);

           $statuses = array_msort($statuses, array('book_views'=>SORT_DESC));


          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <?php if($row['book_cover_img']!=''){ ?>
                <img src="<?='images/'.$row['book_cover_img']?>" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"/>  
              <?php }else{ ?>
                <img src="<?='images/'.APP_LOGO?>" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"/>  
              <?php } ?>
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['book_title']?>" style="color: inherit;">
                <?php 
                  if(strlen($row['book_title']) > 30){
                    echo substr(stripslashes($row['book_title']), 0, 30).'...';  
                  }else{
                    echo $row['book_title'];
                  }
                ?>
                <p style="font-weight: 500;margin-bottom: 0;"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"></span> Views: <?=thousandsNumberFormat($row['book_views'])?></p> 
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>
   <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
      <h3>Most Read Book</h3>
      <p>Books with more Read.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_book="SELECT *, count(book_id) AS num FROM tbl_user_continue
          			LEFT JOIN tbl_books ON tbl_user_continue.`book_id`= tbl_books.`id`
				    Group BY tbl_user_continue.`book_id` ORDER BY num DESC LIMIT 8";
                     
          $res=mysqli_query($mysqli, $sql_book);

          while($row_data=mysqli_fetch_assoc($res)){

              $data['id']=$row_data['id'];
              $data['book_title']=$row_data['book_title'];
              $data['book_cover_img']=$row_data['book_cover_img'];
              $data['num']=$row_data['num'];
               	
              array_push($statuses, $data);
          }
           mysqli_free_result($res);

          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <?php if($row['book_cover_img']!=''){ ?>
                <img src="<?='images/'.$row['book_cover_img']?>" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"/>  
              <?php }else{ ?>
                <img src="<?='images/'.APP_LOGO?>" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"/>  
              <?php } ?>
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['book_title']?>" style="color: inherit;">
                <?php 
                  if(strlen($row['book_title']) > 25){
                    echo substr(stripslashes($row['book_title']), 0, 25).'...';  
                  }else{
                    echo $row['book_title'];
                  }
                ?>
                <p style="font-weight: 500;margin-bottom: 0;"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"></span> Read: <?php echo $row['num'];?></p> 
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>
  
  <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px">
      <h3>Most Favourite books</h3>
      <p>Books with more Favourite.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_fav="SELECT *, count(book_id) AS num FROM tbl_favourite
          			 LEFT JOIN tbl_books ON tbl_favourite.`book_id`= tbl_books.`id`
				     WHERE tbl_favourite.`fa_id` Group BY tbl_favourite.`book_id` ORDER BY num DESC LIMIT 8";
				     
          $res=mysqli_query($mysqli, $sql_fav);

          while($row_data=mysqli_fetch_assoc($res)){

              $data['id']=$row_data['id'];
              $data['book_title']=$row_data['book_title'];
              $data['book_cover_img']=$row_data['book_cover_img'];
              $data['num']=$row_data['num'];

              array_push($statuses, $data);
          }

          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <img src="<?='images/'.$row['book_cover_img']?>" style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"/> 
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['book_title']?>" style="color: inherit;">
                <?php 
                  if(strlen($row['book_title']) > 25){
                    echo substr(stripslashes($row['book_title']), 0, 25).'...';  
                  }else{
                    echo $row['book_title'];
                  }
                ?>
                 <p style="font-weight: 500;margin-bottom: 0;"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"></span> Favourite: <?=thousandsNumberFormat($row['num'])?></p> 
              </a>
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>

</div>

<?php include("includes/footer.php");?>       
<?php 
  if(!$no_data_status){
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Total Users');

        data.addRows([<?=$countStr?>]);

        var options = {
          curveType: 'function',
          fontSize: 15,
          hAxis: {
            title: "Months of <?=(isset($_GET['filterByYear'])) ? $_GET['filterByYear'] : date('Y')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false
            },
          },
          vAxis: {
            title: "Nos. of Users",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false,
            },
            gridlines: { count: -1},
            format: '#',
            viewWindowMode: "explicit", viewWindow: {min: 0, max: 'auto'},
          },
          height: 400,
          chartArea:{
            left:50,top:20,width:'100%',height:'auto'
          },
          legend: {
              position: 'bottom'
          },
          colors: ['#3366CC', 'green','red'],
          lineWidth:4,
          animation: {
            startup: true,
            duration: 1200,
            easing: 'out',
          },
          pointSize: 5,
          pointShape: "circle",

        };
        var chart = new google.visualization.LineChart(document.getElementById('registerChart'));

        chart.draw(data, options);
      }


      $(document).ready(function () {
          $(window).resize(function(){
              drawChart();
          });
      });
    </script>
    <?php
  }
?>
<script type="text/javascript">
    
    // filter of graph
    $("select[name='filterByYear']").on("change",function(e){
      $("#graphFilter").submit();
    });

</script>       
