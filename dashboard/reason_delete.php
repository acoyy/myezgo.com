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
  include ("_header.php"); 
  
  func_setReqVar();
  
  if(isset($_POST['btn_delete']))
  {
  	$agreement_no = $_GET['agreement_no'];
  	$booking_id = $_GET['booking_id'];
  	$reason = $_POST['reason'];
    $current_datetime = date('Y-m-d H:i:s', time());

  	$sql = "UPDATE booking_trans SET delete_status = 'pending', reason =  '".$reason."' WHERE id =".$booking_id;

    db_update($sql);

    $sql = "SELECT vehicle_id FROM booking_trans 
      WHERE 
      id='$booking_id'
      AND 
      pickup_date <= '".$current_datetime."'
      AND
      return_date >= '".$current_datetime."'
    ";

    db_select($sql);

    if (db_rowcount() > 0) 
    {

      $sql = "UPDATE vehicle SET availability = 'Available' WHERE id='".db_get(0,0)."'";
      db_update($sql);
    }

    echo "<script>
      window.location.href='reservation_list.php';
      </script>";
  }
  ?>



  <style>
  .small .btn, .navbar .navbar-nav > li > a.btn {
    padding: 10px 10px;
  }

  .color-background {
    background-color: #eeeeee;
    border-radius: 5px 5px;
    padding: 10px;
  }

  .modal-backdrop, .modal-backdrop.fade.in {
    opacity: 0;
  }

  #canvas
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #board
  {
  width: 100%;
  height: 100%;
  background: url('assets/img/car.png');
  background-repeat:no-repeat;
  background-size:contain;
  background-position:center;
  }

  #return_sign 
  {
  width: 100%;
  height: 100%;
  /*rder: 1px solid #000;*/*/*/
  }
  </style>

  <script src="assets/js/fabric.min.js"></script>
  <script src="assets/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="assets/js/html5-canvas-drawing-app.js"></script>

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
                  <h3>Delete Agreement: <b><i><?php echo $_GET['agreement_no'] ?></i></b></h3>
                </div>

                
              </div>

                          <div class="clearfix"></div>
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <form action="" method="POST">
                      <div class="x_title">
                        <div class="row">

                          <div class="btn-group" style="float: right;">
                            <a href="javascript:javascript:history.go(-1)">
                              <button class="btn btn-default" type="button"><i class="fa fa-close">&nbsp;</i>Cancel</button></a>&nbsp;

                            
                              <button class="btn btn-default" type="submit" name="btn_delete"><i class="fa fa-trash">&nbsp;</i>Confirm</button>
                        </div>

                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div class="row">
                          <div class="col-md-12" style="text-align: center;">
                              <br><br>
                              <label>Reason to delete agreement:</label> <textarea class="form form-control" name="reason" required></textarea>
                          </div>
                        </div>
                        <div class="ln_solid"></div>
                        <br />
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /page content -->

          <?php include('_footer.php') ?>

        </div>
      </div>

      <script>
        var time = new Date().getTime();
        $(document.body).bind("mousemove keypress", function(e) {
          time = new Date().getTime();
        });

        function refresh() {
          if(new Date().getTime() - time >= 1200000) 
            window.location.reload(true);
          else 
            setTimeout(refresh, 1200000);
        }

        setTimeout(refresh, 1200000);
      </script>
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