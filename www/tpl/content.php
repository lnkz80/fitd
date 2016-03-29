

<!-- <div class="row">
  <div class="strow" class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-8 col-xs-offset-2">
    <p>Status string</p>
  </div>
</div> -->

<div class="row">
  <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 mnucol">
  <?php 
if (isset($_GET["cat"])){
  $lmenu = new ContentPage();
  $text = $lmenu->lside($page->getdata('lib_typeof_equipment', 'names', $_GET["cat"]), array("new"=>"Новый", "nolink"=>"Журнал", "journ_sub"=>array("rec"=>"запись", "view"=>"просмотр")), $_GET["cat"]);
  //$sqltxt = $page->getdata();

  echo $text;

} 
  

 ?>
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 middlecol"></div>
  <div class="col-lg-9 col-md-7 col-sm-7 col-xs-7 contentcol">
  <?php
    $lmenu->content();
    ?>
  </div>
</div>
<!-- <div class="row">
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
  <div class="col-md-4">.col-md-4</div>
</div>
<div class="row">
  <div class="col-md-6">.col-md-6</div>
  <div class="col-md-6">.col-md-6</div>
</div> -->