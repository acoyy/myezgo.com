        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="dashboard.php" class="site_title"><span><?php echo $website_name; ?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $firstname; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

                        <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="dashboard.php">Dashboard</a></li>
                      <?php 

                      if($occupation == 'Admin' || $occupation == 'Manager'){ ?>
                      
          <li><a href="cms_front_page.php">Home Page Customization</a></li>
          <li><a href="cms_about_us.php">About Us Customization</a></li>
                      
                      <?php }?>

                      <li><a href="settings.php">Settings</a></li>
                      <li><a href="logout.php">Log Out</a></li>

                      </ul>
                  </li>

                  <li><a href="upcoming_schedule.php"><i class="fa fa-calendar"></i> Upcoming Schedule </a></li>

                  <li><a href="counter_reservation.php"><i class="fa fa-calendar-check-o"></i> Counter Reservation </a></li>

                  <?php if ($occupation == "Admin" || $occupation == "Manager") { ?>


                  <li><a href="discount_coupon.php"><i class="fa fa-tags"></i> Discount Coupon </a></li>

         
                  <?php } 


                  if($occupation == 'Admin' || $occupation == 'Manager'){ ?>


                    <li><a><i class="fa fa-shopping-cart"></i> Fleet Management <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                                              
                        <li><a href="fleet_management_accident.php">Accident</a></li>
                        <li><a href="fleet_management_cost.php">Cost</a></li>
                        <li><a href="fleet_management_gps.php">GPS</a></li>
                        <li><a href="fleet_management_insurance.php">Insurance</a></li>
                        <li><a href="fleet_management_maintenance.php">Maintenance</a></li>
                        <li><a href="fleet_management_summon.php">Summon</a></li>
                                            

                      </ul>
                    </li>

                    <li><a><i class="fa fa-edit"></i> Manage <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="manage_agent.php">Agent</a></li>
                        <li><a href="manage_classes.php">Class</a></li>
                        <li><a href="manage_customer.php">Customer</a></li>    
                        <li><a href="manage_job.php">Job</a></li> 
                        <li><a href="manage_location.php">Location</a></li>  
                        <li><a href="manage_promotion.php">Promotion</a></li> 
                        <li><a href="manage_user.php">User</a></li>   
                        <li><a href="manage_vehicle.php">Vehicle</a></li>                         
                        <li><a href="canvas.php">Canvas</a></li>                         
                      </ul>
                    </li>

                    <li><a><i class="fa fa-bars"></i> Rental <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="rental_options.php">Options</a></li>
                        <li><a href="rental_seasons.php">Seasons</a></li>
                      </ul>
                    </li>

                  <?php 

                    }

                ?>

                  <li><a href="reservation_list.php"><i class="fa fa-clipboard"></i> Booking Record </a></li>

                </ul>
              </div>
    

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="settings.php">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>