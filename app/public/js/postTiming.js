function dynamicTiming(discussionId, createdAt){
    console.log("dynamicTiming called");
    console.log("Discussion ID: ", discussionId);
    
    var xh = new XMLHttpRequest();
    xh.onreadystatechange = function(){
        if(xh.readyState === XMLHttpRequest.DONE && xh.status === 200){
            var timeSincePost = xh.responseText;
            console.log("TimeSince: ", timeSincePost);
            document.getElementById(discussionId).innerHTML = timeSincePost;

        }
    };
    console.log("Created at:",createdAt);
    xh.open("GET", "./scripts/timing-script.php?timestamp=" + encodeURIComponent(createdAt), true);
    xh.send();
}


