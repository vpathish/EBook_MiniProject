<footer class="app-footer">
      <div class="row">
        <div class="col-xs-12">
          <div class="footer-copyright">Copyright © <?php echo date('Y');?> <a href="http://www.viaviweb.com" target="_blank">Viaviweb.com</a>. All Rights Reserved.</div>
        </div>
      </div>
    </footer>
  </div>
</div>
<script type="text/javascript" src="assets/js/vendor.js"></script> 
<script type="text/javascript" src="assets/js/app.js"></script>

<script src="assets/js/notify.min.js"></script>

<script type="text/javascript" src="assets/duDialog-master/duDialog.min.js?v=<?=date('dmYhis')?>"></script>

<script>
$("#checkall").click(function () {
$('input:checkbox').not(this).prop('checked', this.checked);
});
</script> 

<?php if(isset($_SESSION['msg'])){?>

<script type="text/javascript">
  $('.notifyjs-corner').empty();
  $.notify(
    '<?php echo $client_lang[$_SESSION["msg"]];?>',
    { position:"top center",className: '<?=isset($_SESSION["class"]) ? $_SESSION["class"] : "success" ?>'}
  );
</script>
<?php
  unset($_SESSION['msg']);
  unset($_SESSION['class']);	 
  } 
?>
<script type="text/javascript">

if($(".dropdown-li").hasClass("active")){
    var _test='<?php echo $active_page; ?>';
    $("."+_test).next(".cust-dropdown-container").show();
    $("."+_test).find(".title").next("i").removeClass("fa-angle-right");
    $("."+_test).find(".title").next("i").addClass("fa-angle-down");
  }

  $(document).ready(function(e){
    var _flag=false;

    $(".dropdown-a").click(function(e){

      $(this).parents("ul").find(".cust-dropdown-container").slideUp();

      $(this).parents("ul").find(".title").next("i").addClass("fa-angle-right");
      $(this).parents("ul").find(".title").next("i").removeClass("fa-angle-down");

      if($(this).parent("li").next(".cust-dropdown-container").css('display') !='none'){
          $(this).parent("li").next(".cust-dropdown-container").slideUp();
          $(this).find(".title").next("i").addClass("fa-angle-right");
          $(this).find(".title").next("i").removeClass("fa-angle-down");
      }else{
        $(this).parent("li").next(".cust-dropdown-container").slideDown();
        $(this).find(".title").next("i").removeClass("fa-angle-right");
        $(this).find(".title").next("i").addClass("fa-angle-down");
      }

    });
  });
</script>
</body>
</html>
