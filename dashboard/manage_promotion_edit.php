<?php
session_start();
if(isset($_SESSION['cid']))
{ 
  
  $idletime=$_SESSION['sess_time'];//after 60 seconds the user gets logged out

  if (time()-$_SESSION['timestamp']>$idletime){
    session_unset();
    session_destroy();
    echo "<script> alert('You have been logged out due to inactivity'); </script>";
        echo "<script>
                window.location.href='index.php';
            </script>";
  }else{
    $_SESSION['timestamp']=time();
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <?php 
  include('_header.php'); 


  func_setReqVar(); 

  if (isset($btn_save)) { 

      func_setValid("Y"); 

  if (func_isValid()) { 

      $sql = "UPDATE promotion SET
              start_date = '" . conv_datetodbdate($start_date) . "',
              end_date = '" . conv_datetodbdate($end_date) . "',
              how_many_day_min = '$how_many_day_min',
              how_many_day_max = '$how_many_day_max',
              free_day = '$free_day',
              status = '$status'
              WHERE id = " . $_GET['id']; 

      db_update($sql); 

      vali_redirect("manage_promotion.php?btn_search=Search&page=" . $page . "&search_rental_seasons_name=" . $search_rental_seasons_name); 
      
          } 
      } 

  else if (isset($btn_delete)) { 

      $sql = "DELETE FROM promotion WHERE id = " . $_GET['id']; 
      db_update($sql); 
      vali_redirect("manage_promotion.php?btn_search=Search&page=" . $page . "&search_rental_seasons_name=" . $search_rental_seasons_name); 

      } 

  else { 

      $sql = "SELECT id, DATE_FORMAT(start_date, '%d/%m/%Y') as start_date, DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, how_many_day_min, how_many_day_max, free_day, status FROM promotion WHERE id=" . $_GET['id'];

       db_select($sql); 

  if (db_rowcount() > 0) { 

      func_setSelectVar(); 
          
          } 

      } 

  ?>

    <body class="nav-md">
      <div class="container body">
        <div class="main_container">

          <?php include('_leftpanel.php'); ?>

          <?php include('_toppanel.php'); ?>

          <!-- page content -->
          <div class="right_col" role="main">
            <div class="">

            <div class="page-title">
                <div class="title_left">
                  <h3>Promotion</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Promotion</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                          </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST">

                    <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date">Start Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                           
                            <input type="text" class="form-control" id="single_cal1" placeholder="start_date" aria-describedby="inputSuccess2Status" name="start_date" value="<?php echo $start_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span> 
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">End Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">

                            <input type="text" class="form-control" id="single_cal2" placeholder="end_date" aria-describedby="inputSuccess2Status" name="end_date" value="<?php echo $end_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span> 
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="how_many_day_min" class="control-label col-md-3 col-sm-3 col-xs-12">For (Min) Days</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="text" class="form-control" name="how_many_day_min" value="<?php echo $how_many_day_min; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="how_many_day_max" class="control-label col-md-3 col-sm-3 col-xs-12">For (Max) Days</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="text" class="form-control" name="how_many_day_max" value="<?php echo $how_many_day_max; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="free_day" class="control-label col-md-3 col-sm-3 col-xs-12">Free (X) Days</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <input type="text" class="form-control" name="free_day" value="<?php echo $free_day; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                             <select name="status" class="form-control">
                                      <option <?php echo vali_iif('1'==$status,'Selected','');?> value='1'>Active</option>
                                      <option <?php echo vali_iif('0'==$status,'Selected','');?> value='0'>Not Active</option>
                              </select>
                          </div>
                        </div>
    


                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='manage_promotion.php?search_description=<?php echo $search_description; ?>&page=<?php echo $page; ?>'" name="btn_cancel">Cancel</button>
                          </div>
                        </div>


                      </form>
                    </div>
                  </div>
                </div>
              </div>



            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>


    </body>
  </html>
<?php  
}

else{

  echo "<script>
          window.alert('You need to login to continue');
            window.location.href='index.php';
          </script>";
}
?>