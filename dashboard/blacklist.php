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

  <?php include('_header.php'); ?>

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
                  <h3>Blacklist</h3>
                </div>

                
              </div>

              <div class="clearfix"></div>
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Blacklist</h2>
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="search_classes">NRIC No
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="search_nricno" value="<?php echo $search_nricno;?>">
                          </div>
                        </div>
                        <div class="ln_solid"></div>

                        <div style="text-align: center;">
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button name="btn_search" type="submit" class="btn btn-success">Search</button>
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
                            <th>Title</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone No</th>
                <th>Email</th>
                <th>NIRC</th>
                <th>Reason Blacklisted</th>
                <th>Date Blacklisted</th>
                <th>Action</th>
                            </tr>
                         </thead>
                         <tbody>
                      
                      <?php
                          func_setPage(); 
                          func_setOffset(); 
                          func_setLimit(10); 

                          if(isset($btn_search)){ 

                if($search_nricno!=""){ 

                 $where=" AND (firstname like '%".$search_nricno."%' OR email like '%".$search_nricno."%' OR lastname like '%".$search_nricno."%' OR nric_no like '%".$search_nricno."%')"; 

                  } 

                 } 

                       $sql = "SELECT id, title, firstname, lastname, phone_no, email, nric_no, reason_blacklist, date_blacklist from customer where id is not NULL AND status ='B'" .$where . " ORDER BY id DESC";

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
                          <td>".db_get($i,1)."</td>
              <td>".db_get($i,2)."</td>
              <td>".db_get($i,3)."</td>
              <td>".db_get($i,4)."</td>
              <td>".db_get($i,5)."</td>
              <td>".db_get($i,6)."</td>
              <td>".db_get($i,7)."</td>
              <td>".date('d/m/Y',strtotime(db_get($i,8)))."</td>
                          <td><a href='manage_customer_edit.php?id=".db_get($i,0)."&search_vehicle=".$search_vehicle."'><i class='fa fa-pencil'></i></a>
                          &nbsp;&nbsp; 

  <a href='delete_customer.php?id=".db_get($i,0)."' onClick='return confirm(\"Delete this?\")'><i class='fa fa-trash'></i></a></td>
                          <td style='display:none'>               
                              <div id='".db_get($i,7)."' style='display:none;width:800px' class='card__body'>
                                  <img src='img/".db_get($i,8)."'>
                              </div>
                          </td>
                          </tr>";
             


                                  }

                              } else{ echo "<tr><td colspan='10'>No records found</td></tr>"; }
                         

                          ?>

                          <!--<tr>-->
                          <!--    <td colspan="10" align="center">-->
                          <!--        <div class="form-group">-->
                          <!--            <button type="button" class="btn btn-info" name="btn_save" onclick="location.href='manage_customer_new.php?btn_search=&search_vehicle=<?php echo $search_vehicle;?>&page=<?php echo $page;?>'">Add New</button>-->
                          <!--        </div>-->
                          <!--    </td>-->
                          <!--</tr>-->

                          <tr>
                              <td colspan="10" style="text-align:center">
                                  <?php  func_getPaging('blacklist.php?'); ?>
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