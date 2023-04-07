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
        replydiv.id = "reply-reference-id-" + reply.id;
        //Adding Reply Content

        replyToHeader = "";
        if (reply.replyTo) {
          let xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function () {
            if (xhr.status != 200) {
              // analyze HTTP status of the response
              console.log(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
            } else {
              // show the result
              console.log("DEBUG: " + xhr.response);
              replyToHeader = xhr.response; // response is the server response
            }
          };

          xhr.open(
            "GET",
            "./scripts/get-reply-to-script.php?replyId=" +
              encodeURIComponent(reply.replyTo),
            false
          );
          xhr.send();
        }

        replydiv.innerHTML = `
          ${replyToHeader}
            <div class="header">
              <img id="profile-picture-reply" src="uploads/profile-${reply.authorId}.png"/>
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
        dynamicTimingReplies(
          reply.createdAt,
          replyFooter,
          reply.id,
          discussionId
        );

        replydiv.appendChild(replyFooter);
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

function dynamicTimingReplies(createdAt, replyFooter, replyId, discussionId) {
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
            <div class="reply-footer-text reply-reply">
              <a href="./scripts/loadDiscussionModal.php?replyid=${replyId}&discussionid=${discussionId}" class="remove-decoration">
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
