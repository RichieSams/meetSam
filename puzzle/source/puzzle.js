function initImage(puzzleNum){
    
    dom = document.getElementById("puzzles").style;
    dom.visibility = "hidden";
    var count = new Array();
    for(i=0; i<12; i++){
        count[i] = i+1;
    }
    
    var picNum;
    while(count.length>0){
        picNum = Math.floor(Math.random()*count.length);
        var newImg = document.createElement("img");
        newImg.src = "./images/img"+puzzleNum+"-"+count[picNum]+".jpg";
        newImg.setAttribute("class", "img");
        document.getElementById("images").appendChild(newImg);
        count.splice(picNum, 1);
    }
}

//Function will check individual tile placement.
function checkMatch(sqrNumber, tileNumber)
{
    ...
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
        alert("Better luck next time...")
    }
}
