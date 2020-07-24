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
                  <h3>Discount Coupon</h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Discount Coupon</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" id="single_cal1" placeholder="Pickup Date" aria-describedby="inputSuccess2Status" name="search_start_date">
                                  
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">End Date
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="search_end_date" id="single_cal2" placeholder="Return Date" aria-describedby="inputSuccess2Status2">
                                 
                                  <span id="inputSuccess2Status2" class="sr-only">(success)</span>
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
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Value</th>
                            <th>Rate</th>
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

                   	if($search_start_date != "" AND $search_end_date != ""){ 


   					$where=" AND start_date = '$search_start_date' AND end_date = '$search_end_date'"; 

   							}
  						
  						}

  					$sql = "SELECT id, 
  							code, 
  							DATE_FORMAT(start_date, '%d/%m/%Y') as start_date, 
  							DATE_FORMAT(end_date, '%d/%m/%Y') as end_date, 
  							value_in, 
  							rate, 
  							CASE value_in WHEN 'A' Then 'Amount' WHEN 'P' Then 'Percentage' WHEN 'H' Then 'Hour' WHEN 'D' Then 'Day' END AS value_in 
  							FROM discount 
  							WHERE id IS NOT NULL" .$where; 

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
                          <td>" . db_get($i, 1) . "</td>
                          <td>" . db_get($i, 2) . "</td>
                          <td>" . db_get($i, 3) . "</td>
                          <td>" . db_get($i, 6) . "</td>
                          <td>" . db_get($i, 5) . "</td>
                          <td>
                          <a href='discount_edit.php?id=".db_get($i,0)."&search_start_date=".$search_start_date."&search_end_date=".$search_end_date."'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp; 

  <a href='delete_discount.php?id=".db_get($i,0)."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a>

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
  							<?php  func_getPaging('discount_coupon.php?x&search_start_date='.$search_start_date.'&search_end_date='.$search_end_date); ?>
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