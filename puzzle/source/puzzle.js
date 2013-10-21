/*
 Define variables for the values computed by the grabber event
 handler but needed by mover event handler
 */
var diffX, diffY, theElement, tileArray;

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
    for(var i=0; i<12; i++){
        count[i] = i+1;
    }
    
    var picNum;
    var temp1 = 0;
    var temp2 = 0;
    while(count.length>0){        
        picNum = Math.floor(Math.random()*count.length);
        var newImg = document.createElement("img");
        newImg.src = "./images/img"+puzzleNum+"-"+count[picNum]+".jpg";
        newImg.setAttribute("class", "img");
        newImg.setAttribute("id", "img"+count[picNum]);
        newImg.setAttribute("onmousedown", "grabber(event);");
        if(temp2 > 3) {
            temp1 = temp1 + 1;
            temp2 = 0;
        }
        newImg.style.top = ((100 * temp1)+(temp1*5)) + "px";
        newImg.style.left = ((100 * temp2)+(temp2*5)) + "px";
        temp2 = temp2 + 1;
        document.getElementById("images").appendChild(newImg);
        count.splice(picNum, 1);
    }
}

function Timer() { 
    var time = 0;
    setInterval(function(){
        time++;
        var numSec = time % 60;
        var numMin = (time-numSec)/60 % 60;
        var numHour = (time-numSec-numMin*60)/3600;
        var str= numHour+':'+("0"+numMin).slice(-2)+':'+("0"+numSec).slice(-2);
        document.getElementById("timeTaken").value = str;
    },1000);
}


// The event handler function for grabbing the word
function grabber(event) {
    // Set the global variable for the element to be moved
    theElement = event.currentTarget;

    // Determine the position of the word to be grabbed,
    //  first removing the units from left and top
    var posX = parseInt(theElement.style.left);
    var posY = parseInt(theElement.style.top);

    // Compute the difference between where it is and
    // where the mouse click occurred
    diffX = event.clientX - posX;
    diffY = event.clientY - posY;

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
}

/*
//Function will check individual tile placement.
function checkMatch(sqrNumber, tileNumber)
{
    //...
}

//Function will check tileArray for values of total result. If any tile placement is incorrect will fail.
function checkResult(tileArray[][])
{
    if(checkMatch(tileArray[])
    {
        alert("Congratulations! You got it!");
    }
    else
    {
        alert("Better luck next time...");
    }
}
*/