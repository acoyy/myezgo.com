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
  include("_header.php"); 
  func_setReqVar(); 

  if (isset($btn_save)) { 

    func_setValid("Y"); 
    func_isEmpty($season_name, "season name"); 
    func_isEmpty($start_date, "start date"); 
    func_isEmpty($end_date, "end date"); 
    func_isNum($display_order, "display order"); 

  if (func_isValid()) { 

    $sql = "INSERT INTO 
        season_rental
        (
        season_name, 
        start_date, 
        end_date, 
        status,
        display_order,
        cid, 
        cdate
        )
        VALUES
        (
        '" . conv_text_to_dbtext3($season_name) . "',
        '" . conv_datetodbdate($start_date) . "',
        '" . conv_datetodbdate($end_date) . "',
        '" . conv_text_to_dbtext3($status) . "',
        '" . $display_order . "',
        " . $_SESSION['cid'] . ",
        CURRENT_TIMESTAMP       
        )"; 

    db_update($sql); vali_redirect("rental_seasons.php?btn_search=Search&page=" . $page . "&search_rental_seasons_name=" . $search_rental_seasons_name); 

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
                  <h3>Add Rental Seasons</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Rental Seasons</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Season Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="season_name" value="<?php echo $season_name;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Start Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
   
                            <input type="text" class="form-control" id="single_cal1" placeholder="start_date" aria-describedby="inputSuccess2Status" name="start_date" value="<?php echo $start_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span> 
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">End Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal2" placeholder="end_date" aria-describedby="inputSuccess2Status" name="end_date" value="<?php echo $end_date;?>" autocomplete="off">
                                  
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Display Order
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="display_order" value="<?php echo $display_order;?>">
                          </div>
                        </div> 

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Status
                          </label>
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
                          <button type="submit" class="btn btn-success" name="btn_save">Save & Next</button>
                          <button type="button" class="btn btn-primary" onclick="location.href='rental_seasons.php?btn_search=&search_rental_description=<?php echo $search_rental_description; ?>'">Cancel</button>
                            
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