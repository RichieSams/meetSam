
//Function initiates the random images right of the grid.
function initImage(puzzleNum){
    //Hides puzzle selection.
    dom = document.getElementById("puzzles").style;
    dom.visibility = "hidden";
    dom = document.getElementById("output").style;
    document.getElementById("timeTaken").value = "0:00:00";
    dom.visibility = "visible";
    Timer()
    
    //Randomizes images.
    var count = new Array();
    for(i=0; i<12; i++){
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
        if(temp2 > 3)
            {
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