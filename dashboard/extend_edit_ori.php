<?php
include ("_header.php"); 
?>
<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>

  <div class="row">
                <?php
                $extend_id = $_GET['extend_id'];
                $booking_id = $_GET['booking_id'];

                $sql = "SELECT 
                  agreement_no,
                  concat(firstname,' ' ,lastname) AS fullname,
                  nric_no,
                  phone_no,
                  age,
                  address,
                  postcode,
                  city,
                  country,
                  total_sale,
                  sale.id AS sale_id,
                  extend_from_date,
                  extend_to_date,
                  total,
                  booking_trans.vehicle_id,
                  concat(make, ' ', model) AS car,
                  reg_no,
                  class_id,
                  booking_trans.id AS booking_id,
                  payment_status,
                  extend.payment AS payment
                  FROM extend
                  LEFT JOIN booking_trans ON booking_trans.id = extend.booking_trans_id
                  LEFT JOIN customer ON customer.id = booking_trans.customer_id
                  LEFT JOIN sale ON sale.booking_trans_id = booking_trans.id
                  LEFT JOIN vehicle ON vehicle.id = booking_trans.vehicle_id
                  WHERE extend.id = '$extend_id' AND sale.type = 'Extend' AND extend_from_date = sale.pickup_date AND extend_to_date = sale.return_date
                ";

        db_select($sql);
        
        if(db_rowcount() > 0)
        {
          func_setSelectVar();
        }

                ?>
                  <div class="col-md-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Extend Sale</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <form id="demo-form2" action="" method="POST" data-parsley-validate class="form-horizontal form-label-left">

                          <input type='hidden' name='extend_id' value='<?php echo $extend_id; ?>'>
                          <input type='hidden' name='total' value='<?php echo $total; ?>'>
                          <input type='hidden' name='sale_id' value='<?php echo $sale_id; ?>'>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Date?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='date_edit' id='date_edit' value='true' disabled>
                              <label class='switch'>
                                <input id='date_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='extend_from_date' id='extend_from_date' value="<?php echo date('Y-m-d', strtotime($extend_from_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pickup Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="extend_from_time" id='extend_from_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($extend_from_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Date</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" class="form-control" name='extend_to_date' id='extend_to_date' value="<?php echo date('Y-m-d', strtotime($extend_to_date)); ?>" disabled>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Return Time</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="extend_to_time" id='extend_to_time' class="form-control" disabled>
                                <option <?php echo vali_iif('08:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="08:00">08.00</option>
                                <option <?php echo vali_iif('08:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="08:30">08.30</option>
                                <option <?php echo vali_iif('09:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="09:00">09.00</option>
                                <option <?php echo vali_iif('09:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="09:30">09.30</option>
                                <option <?php echo vali_iif('10:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="10:00">10.00</option>
                                <option <?php echo vali_iif('10:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="10:30">10.30</option>
                                <option <?php echo vali_iif('11:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="11:00">11.00</option>
                                <option <?php echo vali_iif('11:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="11:30">11.30</option>
                                <option <?php echo vali_iif('12:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="12:00">12.00</option>
                                <option <?php echo vali_iif('12:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="12:30">12.30</option>
                                <option <?php echo vali_iif('13:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="13:00">13.00</option>
                                <option <?php echo vali_iif('13:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="13:30">13.30</option>
                                <option <?php echo vali_iif('14:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="14:00">14.00</option>
                                <option <?php echo vali_iif('14:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="14:30">14.30</option>
                                <option <?php echo vali_iif('15:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="15:00">15.00</option>
                                <option <?php echo vali_iif('15:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="15:30">15.30</option>
                                <option <?php echo vali_iif('16:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="16:00">16.00</option>
                                <option <?php echo vali_iif('16:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="16:30">16.30</option>
                                <option <?php echo vali_iif('17:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="17:00">17.00</option>
                                <option <?php echo vali_iif('17:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="17:30">17.30</option>
                                <option <?php echo vali_iif('18:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="18:00">18.00</option>
                                <option <?php echo vali_iif('18:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="18:30">18.30</option>
                                <option <?php echo vali_iif('19:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="19:00">19.00</option>
                                <option <?php echo vali_iif('19:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="19:30">19.30</option>
                                <option <?php echo vali_iif('20:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="20:00">20.00</option>
                                <option <?php echo vali_iif('20:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="20:30">20.30</option>
                                <option <?php echo vali_iif('21:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="21:00">21.00</option>
                                <option <?php echo vali_iif('21:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="21:30">21.30</option>
                                <option <?php echo vali_iif('22:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="22:00">22.00</option>
                                <option <?php echo vali_iif('22:30' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="22:30">22.30</option>
                                <option <?php echo vali_iif('23:00' == date('H:i', strtotime($extend_to_date)), 'Selected', ''); ?> value="23:00">23.00</option>
                              </select>
                            </div>
                          </div>

                          <br><br>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Edit Sale?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type='hidden' name='sale_edit' id='sale_edit' value='true' disabled>
                              <input type='hidden' name='sale_id' id='sale_id' value='<?php echo $sale_id; ?>' disabled>
                              <label class='switch'>
                                <input id='sale_toggle' type="checkbox">
                                <span class='slider round'></span>
                              </label>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sale</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="sale" value="<?php echo $total_sale; ?>" id="sale" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="number" min='0.01' step='0.01' class="form-control" name="payment_extend" value="<?php echo number_format($payment,2); ?>" id="payment_extend" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Payment Status</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select name="payment_status" id="payment_status" class="form-control" disabled>
                                <option value="">Please Select</option>
                                <option <?php echo vali_iif('Paid' == $payment_status, 'Selected', ''); ?> value='Paid'>Paid</option>
                                <option <?php echo vali_iif('Collect' == $payment_status, 'Selected', ''); ?> value='Collect'>Need To Collect</option>
                              </select>
                            </div>
                          </div>
                          <br>
                          <center>
                            <input class="btn btn-success" style="width: 200px;" type='submit' name='edit_extend' value="Submit">
                          </center>

                          <script>
                            document.getElementById('date_toggle').onchange = function() {
                                document.getElementById('extend_from_date').disabled = !this.checked;
                                document.getElementById('extend_from_time').disabled = !this.checked;
                                document.getElementById('extend_to_date').disabled = !this.checked;
                                document.getElementById('extend_to_time').disabled = !this.checked;
                                document.getElementById('date_edit').disabled = !this.checked;
                            };
                            document.getElementById('sale_toggle').onchange = function() {
                                document.getElementById('sale').disabled = !this.checked;
                                document.getElementById('payment_extend').disabled = !this.checked;
                                document.getElementById('payment_status').disabled = !this.checked;
                                document.getElementById('sale_edit').disabled = !this.checked;
                                document.getElementById('sale_id').disabled = !this.checked;
                            };
                          </script>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="ln_solid"></div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>