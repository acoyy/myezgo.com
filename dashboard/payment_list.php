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

  <?php include('_header.php');
  func_setReqVar(); ?>

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
                  <h3>Payment List</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Payment List</h2>
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
                      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Payment Deposit Status
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_deposit_payment" <?php echo $disabled;?>>
                              <option value="">Please Select</option>
                              <option value='Collect'>Collect</option>
                              <option value='Cash'>Cash</option>
                              <option value='Online'>Online</option>
                              <option value='Card'>Card</option>
                              <option value='Nil'>Nil</option>
                              <option value='Return'>Return</option>
                              <option value='Closing'>Closing</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Booking Status
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="search_book_payment" <?php echo $disabled;?>>
                                <option value="">Please Select</option>
                                <option value='Collect'>Collect</option>
                                <option value='Cash'>Cash</option>
                                <option value='Online'>Online</option>
                                <option value='Card'>Card</option>
                                <option value='Nil'>Nil</option>
                                <option value='Return'>Return</option>
                                <option value='Closing'>Closing</option>
                            </select>
                          </div>
                        </div>
               
    
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                            <button name="btn_search" type="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                     </div>

                      </form>
                    </div>
                  </div>

               <div class="x_panel">

                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Owner Name</th>
                            <th>Date</th>
                            <th>Availability</th>
                            <th>Payment Booking Status</th>
                            <th>Payment Deposit Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                      
                      <?php
                          func_setPage(); 
                          func_setOffset(); 
                          func_setLimit(10); 

                          if (isset($btn_search)) { 

                          // Filter unavailable car by array id 1

                    if($search_deposit_payment!=""){ 

        $where=" refund_dep_payment = '".$search_deposit_payment."'  AND"; 

        } 

         if($search_book_payment!=""){ 

        $where2=" payment_details = '".$search_book_payment."'  AND"; 

        }
              
              }

            $sql = "SELECT 
          vehicle.id,
          reg_no,
          model,
          make,
          vehicle.availability,
          DATE_FORMAT(pickup_date, '%d/%m/%Y') as pickup_dates,
          DATE_FORMAT(pickup_time, '%H:%i') as pickup_times,
          DATE_FORMAT(return_date, '%d/%m/%Y') as return_dates,
          DATE_FORMAT(return_time, '%H:%i') as return_times,
          booking_trans.id,
          booking_trans.available,
          concat(firstname,' ' ,lastname) as name,
          sub_total,
          payment_details,
          refund_dep,
          available,
          refund_dep_payment,
          agreement_no,
          refund_dep_payment
          FROM vehicle
          LEFT JOIN booking_trans ON vehicle.id = vehicle_id
          LEFT JOIN class ON class.id = class_id
          LEFT JOIN customer ON customer_id = customer.id
          WHERE ".$where." ".$where2." NOT agreement_no='0'  
          ORDER BY return_date desc";

                db_select($sql); 

                func_setTotalPage(db_rowcount()); 

                db_select($sql." LIMIT ".func_getLimit()." OFFSET ". func_getOffset());

                if(db_rowcount()>0){

                  for($i=0;$i<db_rowcount();$i++){

                    if(func_getOffset()>=10){ 

                    $no=func_getOffset()+1+$i; 

                    } 

                   else{ 

                    $no=$i+1; 

                    } 


                    echo "<tr>
                          <th scope='row'>" . $no . "</th>
                          <td>".db_get($i,1)." : ".db_get($i,2)." (".db_get($i,3).")</td>
                          <td>".db_get($i,11)."</td>
                          <td>".db_get($i,5).' | '.db_get($i,7)."</td>
                          <td>".db_get($i,15)."</td>
                          <td>".db_get($i,13)."</td>
                          <td>".db_get($i,16)."</td>
                          <td>
                          <a href='payment_status_edit.php?id=".db_get($i,9)."&search_deposit_payment=".$search_deposit_payment."&search_book_payment=".$search_book_payment."'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp; 

                          </td>

                          </tr>";


        


                  }

                } else{ echo "<tr><td colspan='7'>No records found</td></tr>"; }
                         

                          ?>

                          <tr>
                <td colspan="7" align="center">
                  <div class="form-group">
                      <button type="button" class="btn btn-primary" name="btn_save" onclick="location.href='discount_new.php?btn_search=&search_start_date=<?php echo $search_start_date;?>&search_end_date=<?php echo $search_end_date;?>&page=<?php echo $page;?>'">Add New</button>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="7" style="text-align:center">
                <?php  func_getPaging('payment_list.php?x&search_deposit_payment='.$search_deposit_payment.'&search_book_payment='.$search_book_payment); ?>
                </td>
              </tr>

                      </tbody>
                      </table>


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