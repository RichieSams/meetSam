/*
 Define variables for the values computed by the grabber event
 handler but needed by mover event handler
 */
var diffX, diffY, theElement, origX, origY;
var tileArray = [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1];

//Function initiates the random images right of the grid.
function initImage(puzzleNum){
    //Hides puzzle selection.
    var dom = document.getElementById("puzzles").style;
    dom.visibility = "hidden";
    dom = document.getElementById("output").style;
    document.getElementById("timeTaken").value = "0:00:00";
    dom.visibility = "visible";
    Timer()
    
    //Randomizes images.
    var count = new Array();
    for (var i = 0; i < 12; i++){
        count[i] = i;
    }
    
    var picNum;
    var row = 0;
    var col = 0;
    while(count.length > 0){
        picNum = Math.floor(Math.random() * count.length);

        var newImg = document.createElement("img");
        newImg.src = "images/img" + puzzleNum + "-" + (count[picNum] + 1) + ".jpg";
        newImg.setAttribute("class", "img");
        newImg.setAttribute("id", count[picNum]);
        newImg.setAttribute("onmousedown", "grabber(event);");

        newImg.style.top = ((100 * row) + (row * 5)) + "px";
        newImg.style.left = ((100 * col) + (col * 5) + 420) + "px";

        col++;
        if (col > 3) {
            row++;
            col = 0;
        }
        document.getElementById("main").appendChild(newImg);
        count.splice(picNum, 1);
    }
}

//Set start time
time = 0;

//Clock function that call the number creator
function Timer() { 
    timer = setInterval(function(){numbers()},1000);
}

//Create clock count for timmer
function numbers()
{
    time++;
    var numSec = time % 60;
    var numMin = (time - numSec)/60 % 60;
    var numHour = (time - numSec - numMin * 60)/3600;
    var str= numHour+':' + ("0"+numMin).slice(-2) + ':' + ("0"+numSec).slice(-2);
    document.getElementById("timeTaken").value = str;
}



// The event handler function for grabbing the word
function grabber(event) {
    // Set the global variable for the element to be moved
    theElement = event.currentTarget;

    // Determine the position of the word to be grabbed,
    //  first removing the units from left and top
    origX = parseInt(theElement.style.left);
    origY = parseInt(theElement.style.top);

    // Compute the difference between where it is and
    // where the mouse click occurred
    diffX = event.clientX - origX;
    diffY = event.clientY - origY;

    // Now register the event handlers for moving and
    // dropping the word
    document.addEventListener("mousemove", mover, true);
    document.addEventListener("mouseup", dropper, true);

    // Stop propagation of the event and stop any default
    // browser action
    event.stopPropagation();
    event.preventDefault();
}


// The event handler function for moving the word
function mover(event) {
    // Compute the new position, add the units, and move the word
    theElement.style.left = (event.clientX - diffX) + "px";
    theElement.style.top = (event.clientY - diffY) + "px";

    // Prevent propagation of the event
    event.stopPropagation();
}

// The event handler function for dropping the word
function dropper(event) {
    // Unregister the event handlers for mouseup and mousemove
    document.removeEventListener("mouseup", dropper, true);
    document.removeEventListener("mousemove", mover, true);

    // Prevent propagation of the event
    event.stopPropagation();

    // Calculate which tile we are in
    // Use the center of the image as the deciding point
    var centerHoriz = parseInt(theElement.style.left) + 50;
    var centerVert = parseInt(theElement.style.top) + 50;

    for (var y = 0; y < 3; ++y) {
        var breakOut = false;
        for (var x = 0; x < 4; ++x) {
            if (centerHoriz >= (x * 100) && centerHoriz <= (x * 100) + 100 && centerVert >= (y * 100) && centerVert <= (y * 100) + 100) {
                if (tileArray[4 * y + x] == -1) {
                    tileArray[4 * y + x] = parseInt(theElement.id);
                    theElement.style.left = x * 100;
                    theElement.style.top = y * 100;

                    breakOut = true;
                    break;
                }
            }
        }
        if (breakOut) {
            break;
        }
    }

}


//Function will check tileArray for values of total result. If any tile placement is incorrect will fail.
function checkResult(tileArray)
{    
    if(checkMatch(tileArray))
    {
        //Stops Clock
        clearInterval(timer);
        alert("Congratulations! You got it!");
    }
    else
    {
        alert("Better luck next time...");
    }
}
