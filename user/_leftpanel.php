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

                      <!--<li><a href="settings.php">Settings</a></li>-->
                      <li><a href="logout.php">Log Out</a></li>

                      </ul>
                  </li>

                  <li><a href="my_booking.php"><i class="fa fa-clipboard"></i> Booking Record </a></li>

                  <!-- <li><a href="counter_reservation.php"><i class="fa fa-calendar-check-o"></i> Counter Reservation </a></li> -->
                  
                  <!--<li><a href="booking_details.php"><i class="fa fa-clipboard"></i> My Booking </a></li>-->

                  <!--<li><a href="rules_confirmation.php"><i class="fa fa-clipboard"></i> Rules Confirmation </a></li>-->

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