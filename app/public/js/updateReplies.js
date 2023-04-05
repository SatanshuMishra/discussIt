function updateReplies(discussionId) {
  console.log("updateReplies Called");
  console.log("DiscussionID: ", discussionId);
  var xh = new XMLHttpRequest();
  xh.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      //Parse return from getReplies()
      console.log(xh.responseText);
      var replies = JSON.parse(xh.responseText);
      //Update user-replies div
      var container = document.getElementById("user-replies");
      container.innerHTML = "";
      console.log("replies length", replies[0].length);
      var replyScript = document.getElementById("reply-reply-script");
      for (var i = 0; i < replies[0].length; i++) {
        var reply = replies[0][i];
        //Inner Div for each reply
        var replydiv = document.createElement("div");
        replydiv.classList.add("reply");
        //Adding Reply Content

        // var replyhead = document.createElement("div");
        // replyhead.classList.add("header");
        // replyhead.innerHTML = `<img id="profile-picture-reply" src="../uploads/profile-${reply.id}.png"/> <div class="user-info"> <span class="username">${reply.username}</span></div>`;

        // replydiv.appendChild(replyhead);

        // var replyBody = document.createElement("div");
        // replyBody.classList.add("body");
        // replyBody.textContent = reply.content;
        // replydiv.appendChild(replyBody);
        replydiv.innerHTML = `
            <div class="header">
              <img id="profile-picture-reply" src="uploads/profile-${reply.id}.png"/>
              <div class="user-info">
                <span class="username">${reply.username}</span>
              </div>
            </div>
            <div class="body">
              ${reply.content}
            </div>
                `;

        var replyFooter = document.createElement("div");
        replyFooter.classList.add("footer");
        dynamicTimingReplies(reply.createdAt, replyFooter, reply.id);

        replydiv.appendChild(replyFooter);

        //         var script = document.createElement("script");
        //         script.innerHTML = `
        //             $(document).ready(() => {
        //                console.log('---SCRIPT START----');
        //               console.log(document.getElementById('comment-${reply.id}'));
        //                 $('.footer').click(() => {
        //                   console.log("CLICK!!!");
        //                 });
        //               console.log('---SCRIPT END----');
        //             });
        // `;
        // replyScript.appendChild(script);

        // replydiv.appendChild(replyFooter);
        //Add inner reply contents to outside div
        container.appendChild(replydiv);
      }
    }
  };
  xh.open(
    "GET",
    "./scripts/getReplies-script.php?discussionId=" +
      encodeURIComponent(discussionId),
    true
  );
  xh.send();
}

function dynamicTimingReplies(createdAt, replyFooter, replyId) {
  console.log("dynamicTimingReplies called");
  console.log(createdAt);
  var xh = new XMLHttpRequest();
  xh.onreadystatechange = function () {
    if (xh.readyState === XMLHttpRequest.DONE && xh.status === 200) {
      var timeSincePost = xh.responseText;
      console.log("TimeSince: ", timeSincePost);
      replyFooter.innerHTML = `<div class="like">
              <a class="disabled remove-decoration">
                <i class="fa-regular fa-thumbs-up regular"></i>
                <i class="fa-solid fa-thumbs-up hover"></i>
              </a>
            </div>
            <div class="vertical-line-break"></div>
            <div class="reply-footer-text reply-reply" id="comment-${replyId}" data-id="${replyId}" onclick="testFunction()">
              <a class="disabled remove-decoration">
                <span>Reply</span>
              </a>
            </div>
            <div class="vertical-line-break"></div>
            <div class="reply-footer-text reply-time">
            <span class="time" id ="time">${timeSincePost}</span>
            </div>
            <div class="vertical-line-break"></div>
            <div class="reply-footer-text report-reply">
              <a class="disabled remove-decoration">
                <i class="fa-regular fa-flag regular"></i>
                <i class="fa-solid fa-flag hover"></i>
                <span>Report</span>
              </a>
            </div>`;
    }
  };
  console.log("Created at:", createdAt);
  xh.open(
    "GET",
    "./scripts/Repliestiming-script.php?timestamp=" +
      encodeURIComponent(createdAt),
    true
  );
  xh.send();
}

/* if($replies){
    foreach($replies as $reply){
        $replyUserId = $reply["id"];
        $username = $reply["username"];
        $replyContent = $reply["content"];
        $time = date('Y-m-d', strtotime($reply["createdAt"]));;
        echo "
        <div class=\"reply\">
          <div class=\"header\">
            <img id=\"profile-picture-reply\" src=\"uploads/profile-$replyUserId.png\"/>
            <div class=\"user-info\">
              <span class=\"username\">$username</span>
            </div>
          </div>
          <div class=\"body\">
            $replyContent
          </div>
          <div class=\"footer\">
            <span class=\"time\">$time</span>
          </div>
        </div>
        "; */
