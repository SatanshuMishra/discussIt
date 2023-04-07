<?php 
  require_once "config.php";
  require_once "functions-scripts.php";

  $replyId = $_GET['replyId'];

  $reply = getReplyByID($conn, $replyId);
  $author = getUserByID($conn, $reply['authorId']);

  echo '
    <a href="#reply-reference-id-'.$replyId.'" class="remove-decoration">
      <div class="reply-to">
        <div class="reply-icon">
          <i class="fa-solid fa-reply regular"></i>
        </div>
        <div class="vertical-line-break white-vertical-line-break"></div>
        <div class="reply-footer-text reply-to-user">
          <span>'.$author['username'].'</span>
        </div>
        <div class="vertical-line-break white-vertical-line-break"></div>
        <div class="reply-footer-text reply-to-text">
          <span>'.substr($reply['content'], 0, 20)."...".'</span>
        </div>
      </div>
    </a>
  ';

?>