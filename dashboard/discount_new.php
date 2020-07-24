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

   if(isset($btn_save)){ 

    func_setValid("Y"); 

    if(func_isValid()){ 

      $sql="INSERT INTO 
         discount
         (
         code, 
         start_date, 
         end_date,  
         value_in,
         rate,
         cid, 
         cdate
         )
         VALUES
         (
         '".strtoupper($code)."',
         '".conv_datetodbdate($start_date)."',
         '".conv_datetodbdate($end_date)."',
         '".$value_in."',
         ".$rate.", 
         ".$_SESSION['cid'].",
         CURRENT_TIMESTAMP
         )
         "; 

      db_update($sql); 

      vali_redirect("discount_coupon.php?btn_search=&search_start_date=".$search_start_date."&search_end_date=".$search_end_date."&page=".$page); 
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
                  <h3>Add Discount Coupon</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Add Discount Coupon</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" >

                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-5 col-xs-12" for="code">Coupon Code 
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="text" placeholder="Coupon Code" class="form-control" id="code" name="code" value="<?php echo $code;?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-5 col-xs-12" for="first-name">Start Date 
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="start_date" aria-describedby="inputSuccess2Status" name="start_date">
                                  
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-5 col-xs-12" for="end_date">End Date 
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal2" placeholder="Pickup Date" aria-describedby="inputSuccess2Status" name="end_date" >
                                  
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>

                        

                        <div class="form-group">
                          <label class="control-label col-md-5 col-sm-5 col-xs-12" for="last-name">Value In 
                          </label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <select name="value_in" class="form-control">
                            <option value='P' <?php echo vali_iif('P'==$value_in,'Selected','');?>>Percentage</option>
                            <option value='A' <?php echo vali_iif('A'==$value_in,'Selected','');?>>Amount</option>
                            <option value='H' <?php echo vali_iif('H'==$value_in,'Selected','');?>>Hour</option>
                            <option value='D' <?php echo vali_iif('D'==$value_in,'Selected','');?>>Day</option>
                           </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="middle-name" class="control-label col-md-5 col-sm-5 col-xs-12">Rate</label>
                          <div class="col-md-2 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" placeholder="Rate" name="rate" value="<?php echo $rate;?>">
                          </div>
                        </div>
     
         
                        <div class="ln_solid"></div>
                        <div class="form-group" style="text-align: center;"> 
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" name="btn_save">Save</button>
                            <button type="button" class="btn btn-primary" onclick="location.href='discount_coupon.php?btn_search=&search_start_date=<?php echo $search_start_date; ?>&search_end_date=<?php echo $search_end_date; ?>&page=<?php echo $page;?>'" name="btn_cancel">Cancel</button>

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