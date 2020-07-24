// var canvas;
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
// var totalLoadResources = 8;
// var curLoadResNum = 0;
/**
* Calls the redraw function after all neccessary resources are loaded.
*/
// function resourceLoaded()
// {
// 	if(++curLoadResNum >= totalLoadResources){
// 		redraw();
// 	}
// }

/**
* Creates a canvas element, loads images, adds events, and draws the canvas for the first time.
*/
function prepareCanvas()
{
	// Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
	// var canvasDiv = document.getElementById('canvasDiv');
	// canvas = document.createElement('canvas');
	// canvas.setAttribute('width', canvasWidth);
	// canvas.setAttribute('height', canvasHeight);
	// canvas.setAttribute('id', 'canvas');
	// canvasDiv.appendChild(canvas);
	// if(typeof G_vmlCanvasManager != 'undefined') {
	// 	canvas = G_vmlCanvasManager.initElement(canvas);
	// }
	// context = canvas.getContext("2d"); // Grab the 2d canvas context
	// Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
// 	alert('masuk prepare canvas');
	context = document.getElementById('canvas2').getContext("2d");

	
	// Load images
	// -----------
	// crayonImage.onload = function() { resourceLoaded(); 
	// };
	// crayonImage.src = "assets/images/crayon-outline.png";
	// //context.drawImage(crayonImage, 0, 0, 100, 100);
	
	// markerImage.onload = function() { resourceLoaded(); 
	// };
	// markerImage.src = "assets/images/marker-outline.png";
	
	// eraserImage.onload = function() { resourceLoaded(); 
	// };
	// eraserImage.src = "assets/images/eraser-outline.png";	
	
	// crayonBackgroundImage.onload = function() { resourceLoaded(); 
	// };
	// crayonBackgroundImage.src = "assets/images/crayon-background.png";
	
	// markerBackgroundImage.onload = function() { resourceLoaded(); 
	// };
	// markerBackgroundImage.src = "assets/images/marker-background.png";
	
	// eraserBackgroundImage.onload = function() { resourceLoaded(); 
	// };
	// eraserBackgroundImage.src = "assets/images/eraser-background.png";

	// crayonTextureImage.onload = function() { resourceLoaded(); 
	// };
	// crayonTextureImage.src = "assets/images/crayon-texture.png";
	
	// outlineImage.onload = function() { resourceLoaded(); 
	// };
	// outlineImage.src = "assets/images/watermelon-duck-outline.png";

	// Add mouse events
	// ----------------

	// $("#marker").click(function(){
		
	// 	alert('masuk marker');
	// 	return curTool = "marker";
	// });

	// $("#eraser").click(function(){
		
	// 	alert('masuk eraser');
	// 	return curTool = "eraser";
	// });

	$('#canvas2').mousedown(function(e)
	{
		// Mouse down location
		var mouseX = e.pageX - this.offsetLeft;
		var mouseY = e.pageY - this.offsetTop;

		paint = true;
		// alert('mouseY='+mouseY);
		addClick(mouseX, mouseY, false);

		redraw();
	});
	
	$('#canvas2').mousemove(function(e){
		if(paint==true){
			addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
			redraw();
		}
	});
	
	$('#canvas2').mouseup(function(e){
		paint = false;
	  	redraw();
	});
	
	$('#canvas2').mouseleave(function(e){
		paint = false;
	});
}

/**
* Adds a point to the drawing array.
* @param x
* @param y
* @param dragging
*/
function addClick(x, y, dragging)
{
	clickX.push(x);
	clickY.push(y);
	clickTool.push(curTool);
	clickColor.push(curColor);
	clickSize.push(curSize);
	clickDrag.push(dragging);
	// alert('X='+x);
}

function addClick3(x, y, dragging)
{
	/******************** ni bila ada button pen n eraser tu *********************/
	// clickX.push(x - 250);
	// clickY.push(y - 250);
	/*****************************************************************************/
	clickX.push(x - 231);
	clickY.push(y - 353);
	clickTool.push(curTool);
	clickColor.push(curColor);
	clickSize.push(curSize);
	clickDrag.push(dragging);
	// alert('X='+x);
}

function prepareCanvas3()
{
// Create the canvas (Neccessary for IE because it doesn't know what a canvas element is)
// var canvasDiv = document.getElementById('canvasDiv');
// canvas = document.createElement('canvas');
// canvas.setAttribute('width', canvasWidth);
// canvas.setAttribute('height', canvasHeight);
// canvas.setAttribute('id', 'canvas');
// canvasDiv.appendChild(canvas);
// if(typeof G_vmlCanvasManager != 'undefined') {
//  canvas = G_vmlCanvasManager.initElement(canvas);
// }
// context = canvas.getContext("2d"); // Grab the 2d canvas context
// Note: The above code is a workaround for IE 8 and lower. Otherwise we could have used:
// alert('masuk prepare canvas3');
// context = document.getElementById('canvas3').getContext("2d");


// Load images
// -----------
// crayonImage.onload = function() { resourceLoaded(); 
// };
// crayonImage.src = "assets/images/crayon-outline.png";
// //context.drawImage(crayonImage, 0, 0, 100, 100);

// markerImage.onload = function() { resourceLoaded(); 
// };
// markerImage.src = "assets/images/marker-outline.png";

// eraserImage.onload = function() { resourceLoaded(); 
// };
// eraserImage.src = "assets/images/eraser-outline.png";  

// crayonBackgroundImage.onload = function() { resourceLoaded(); 
// };
// crayonBackgroundImage.src = "assets/images/crayon-background.png";

// markerBackgroundImage.onload = function() { resourceLoaded(); 
// };
// markerBackgroundImage.src = "assets/images/marker-background.png";

// eraserBackgroundImage.onload = function() { resourceLoaded(); 
// };
// eraserBackgroundImage.src = "assets/images/eraser-background.png";

// crayonTextureImage.onload = function() { resourceLoaded(); 
// };
// crayonTextureImage.src = "assets/images/crayon-texture.png";

// outlineImage.onload = function() { resourceLoaded(); 
// };
// outlineImage.src = "assets/images/watermelon-duck-outline.png";

canvas = document.getElementById('canvas3');

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
            mouseX=touch.pageX + 190;
            mouseY=touch.pageY + 80;
        }
    }
}

// Add mouse events
// ----------------
$('#canvas3').mousedown(function(e)
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

$('#canvas3').mousemove(function(e){
  if(paint==true){
    addClick3(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
    // alert("masuk redraw mousemove");
    redraw();
  }
});

$('#canvas3').mouseup(function(e){
  paint = false;
    // alert("masuk redraw mouseup");
    redraw();
});

$('#canvas3').mouseleave(function(e){
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
	
// 	alert("clickX: "+clickX);
	
	var radius;
	var i = 0;
	for(; i < clickX.length; i++)
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
			//context.globalCompositeOperation = "source-over";	// To erase instead of draw over with white
			context.strokeStyle = clickColor[i];
		}
		context.lineJoin = "round";
		context.lineWidth = radius;
		context.stroke();
		
	}
}