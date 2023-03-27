window.addEventListener("DOMContentLoaded", (event) => {
  var postReplyTextArea = $(".post-reply > form > textarea");
  postReplyTextArea.focus(function (e) {
    if (postReplyTextArea.val() == "") {
      postReplyTextArea.toggleClass("expanded");
      document.querySelector("#post-reply-btn").style.display = "block";
    }
  });
  postReplyTextArea.blur(function (e) {
    if (postReplyTextArea.val() == "") {
      postReplyTextArea.toggleClass("expanded");
      document.querySelector("#post-reply-btn").style.display = "none";
    }
  });
});
