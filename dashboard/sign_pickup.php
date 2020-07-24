<html>
<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="assets/js/fabric.min.js"></script>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script>
var context;
var canvasWidth = 490;
var canvasHeight = 220;
// var padding = 25;
// var lineWidth = 8;
var colorPurple = "#cb3594";
var colorGreen = "#659b41";
var colorYellow = "#ffcf33";
var colorBrown = "#986928";
var colorBlack = "#000000";
var outlineImage = new Image();
var crayonImage = new Image();
var markerImage = new Image();
var eraserImage = new Image();
var crayonBackgroundImage = new Image();
var markerBackgroundImage = new Image();
var eraserBackgroundImage = new Image();
var crayonTextureImage = new Image();
var clickX = new Array();
var clickY = new Array();
var clickColor = new Array();
var clickTool = new Array();
var clickSize = new Array();
var clickDrag = new Array();
var paint = false;
var curColor = colorBlack;
var curTool = "marker";
var curSize = "normal";

function addClick3(x, y, dragging)
{
  /******************** ni bila ada button pen n eraser tu *********************/
  // clickX.push(x - 250);
  // clickY.push(y - 250);
  /*****************************************************************************/
  
//  alert("addClick3 x: "+x);
//  alert("addClick3 Y: "+y);
  clickX.push(x);
  clickY.push(y);
  clickTool.push(curTool);
  clickColor.push(curColor);
  clickSize.push(curSize);
  clickDrag.push(dragging);
  // alert('X='+x);
}

function prepareCanvas()
{

canvas = document.getElementById('canvassign');

// If the browser supports the canvas tag, get the 2d drawing context for this canvas
if (canvas.getContext)
    context = canvas.getContext('2d');

// Check that we have a valid context to draw on/with before adding event handlers
if (context) {

    // React to touch events on the canvas
    canvas.addEventListener('touchstart', sketchpad_touchStart, false);
    canvas.addEventListener('touchmove', sketchpad_touchMove, false);
    canvas.addEventListener('touchleave', sketchpad_touchLeave, false);
}


function sketchpad_touchStart() {
    // Update the touch co-ordinates
    getTouchPos();

    paint = true;
  // alert('mouseY='+mouseY);
    addClick3(mouseX, mouseY, false);

    redraw();
    // Prevents an additional mousedown event being triggered
    event.preventDefault();
}

// Draw something and prevent the default scrolling when touch movement is detected
function sketchpad_touchMove(e) { 
    // Update the touch co-ordinates
    getTouchPos(e);

    if(paint==true){
      addClick3(mouseX, mouseY, true);
      redraw();
    }
    // During a touchmove event, unlike a mousemove event, we don't need to check if the touch is engaged, since there will always be contact with the screen by definition.

    // Prevent a scrolling action as a result of this touchmove triggering.
    event.preventDefault();
}

function sketchpad_touchLeave(e) { 
    // Update the touch co-ordinates
    // getTouchPos(e);

    paint = false;
    
    // During a touchmove event, unlike a mousemove event, we don't need to check if the touch is engaged, since there will always be contact with the screen by definition.

    // alert('masuk touch move lalu redraw');

    // Prevent a scrolling action as a result of this touchmove triggering.
    event.preventDefault();
}

// Get the touch position relative to the top-left of the canvas
// When we get the raw values of pageX and pageY below, they take into account the scrolling on the page
// but not the position relative to our target div. We'll adjust them using "target.offsetLeft" and
// "target.offsetTop" to get the correct values in relation to the top left of the canvas.
function getTouchPos(e) {
    if (!e)
        var e = event;

    if(e.touches) {
        if (e.touches.length == 1) { // Only deal with one finger
            var touch = e.touches[0]; // Get the information for finger #1
            mouseX=touch.pageX;
            mouseY=touch.pageY;
            
            // alert("mouseX: "+ mouseX);
            // alert("mouseY: "+ mouseY);
        }
    }
}

// Add mouse events
// ----------------
$('#canvassign').mousedown(function(e)
{
  // Mouse down location
  var mouseX = e.pageX - this.offsetLeft;
  var mouseY = e.pageY - this.offsetTop;

  paint = true;
  // alert('mouseY='+mouseY);
  addClick3(mouseX, mouseY, false);
  
//   alert("masuk redraw mousedown");
  redraw();
});

$('#canvassign').mousemove(function(e){
  if(paint==true){
    addClick3(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
    // alert("masuk redraw mousemove");
    redraw();
  }
});

$('#canvassign').mouseup(function(e){
  paint = false;
    // alert("masuk redraw mouseup");
    redraw();
});

$('#canvassign').mouseleave(function(e){
  paint = false;
});
}

/**
* Clears the canvas.
*/
function clearCanvas()
{
  context.clearRect(0, 0, canvasWidth, canvasHeight);
}

/**
* Redraws the canvas.
*/
function redraw()
{
  // Make sure required resources are loaded before redrawing
  // if(curLoadResNum < totalLoadResources){ return; }
  
  clearCanvas();
  
//  alert("clickX: "+clickX);
  
  var radius;
  var i;
  for(i = 0; i < clickX.length; i++)
  {
    radius = 3;
    
    context.beginPath();
    // alert('i = '+i);
    if(clickDrag[i] && i){
      // alert('ClickDrag = '+clickDrag[i]);
      context.moveTo(clickX[i-1], clickY[i-1]);
    }else{
      context.moveTo(clickX[i], clickY[i]);
    }
    context.lineTo(clickX[i], clickY[i]);
    context.closePath();
    
    if(clickTool[i] == "eraser"){
      //context.globalCompositeOperation = "destination-out"; // To erase instead of draw over with white
      context.strokeStyle = 'white';
    }else{
      //context.globalCompositeOperation = "source-over"; // To erase instead of draw over with white
      context.strokeStyle = clickColor[i];
    }
    context.lineJoin = "round";
    context.lineWidth = radius;
    context.stroke();
    
  }
}

</script>

<script>
  function upload() {
    var canvassign = document.getElementById("canvassign");
    var dataURL3 = canvassign.toDataURL("image/png");
    document.getElementById('hidden_data').value = dataURL3;
    var fd = new FormData(document.forms["modalsign"]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'sign_pickup.php', true);
    xhr.send(fd);
  };

  function tempAlert(msg,duration)
  {
   var el = document.createElement("div");
   el.setAttribute("style","position:absolute;top:40%;left:20%;background-color:white;");
   el.innerHTML = msg;
   setTimeout(function(){
    el.parentNode.removeChild(el);
   },duration);
   document.body.appendChild(el);
  };
</script>

<!--<div style='margin: 200px;'>-->
<form name="modalsign" enctype="multipart/form-data" id="modalsign"  method="post">
  <canvas id="canvassign" style="border: 1px solid;"></canvas>
  <script>
    prepareCanvas();
  </script>
  <?php 

    function db_update($sql){
      global $con;
      $con = mysqli_connect('localhost','root','','myezgo') or die ("Can't connect to Server = ".mysqli_error());
      mysqli_query($con,$sql);
    }

    $booking_id = $_GET['booking_id'];

    if(isset($_POST['submit_sign'])) {

      $upload_dir = "assets/img/sign_pickup/"; 

      $img = $_POST['hidden_data']; 
      $img = str_replace('data:image/png;base64,', '', $img); 
      $img = str_replace(' ', '+', $img); 
      $data = base64_decode($img); 
      $file2name = "sign-pickup-" . $booking_id . ".png";
      $file2 = $upload_dir . "sign-pickup-" . $booking_id . ".png";

      $success = file_put_contents($file2, $data); 

      $sql = "UPDATE checklist SET car_out_sign_image = '$file2name' WHERE booking_trans_id = $booking_id";

      db_update($sql);

      echo "<script>
              alert('Successfully uploaded.');
              window.location.href='mail.php?status=pickup&booking_id=".$booking_id."';
              </script>
            ";
    }
  ?>
  <br><br>
  <button class="btn btn-primary" name="submit_sign" onClick="upload()" value="upload" type="submit">Submit</button>

  <input name="hidden_data" id='hidden_data' type="hidden"/>
  <!--</div>-->
</form>