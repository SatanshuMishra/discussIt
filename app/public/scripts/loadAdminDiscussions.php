<?php session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      require_once 'config.php';
      require_once 'functions-scripts.php';
          $discussions = getDiscussions($conn);
          if($discussions){
            foreach($discussions as $discussion){
              $discussionAuthor = getUserByID($conn, $discussion["authorId"]);
              echo '
                <tr class="member-row">
                  <td class="discussion-title-cell">
                    <div class="cell">
                      <span>'.$discussion["postTitle"].'</span>
                    </div>
                  </td>
                  <td class="name">
                    <div class="cell name-cell">
                      <img src="./uploads/profile-'.$discussionAuthor["id"].'.png?version=1231231" />
                      <div class="text-info">
                        <span class="name">'.$discussionAuthor["firstName"]." ".$discussionAuthor["lastName"].'</span>
                        <span class="username">@'.$discussionAuthor["username"].'</span>
                      </div>
                    </div>
                  </td>
                  <td class="options">
                    <div class="cell">
                      <a class="delete-link-btn" href="./discussion.php?id='.$discussion["id"].'">
                        <span class="tooltip" data-text="View Discussion">
                          <div class="option edit">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                          </div>
                        </span>
                      </a>
                      <a class="delete-link-btn" href="./scripts/admin-toggle-discussion-visibility.php?iAFgo3q5J2hfCTv1SShA=true&did='.$discussion["id"].'">
                      ';
              if($discussion["isVisible"]){
                  echo ' 
                      <span class="tooltip" data-text="Hide Discussion">
                        <div class="option suspend">
                          <i class="fa-solid fa-eye"></i>
                        </div>
                      </span>
                        '; 
              } else {
                  echo ' 
                      <span class="tooltip" data-text="Show Discussion">
                        <div class="option suspend">
                          <i class="fa-solid fa-eye-slash"></i>
                        </div>
                      </span>
                        ';
              }

              echo '</a>
                      <a class="delete-link-btn" href="./scripts/admin-delete-discussion.php?iAFgo3q5J2hfCTv1SShA=true&aid='.$discussionAuthor["id"].'&did='.$discussion["id"].'">
                        <span class="tooltip" data-text="Delete Discussion">
                          <div class="option ban">
                            <i class="fa-solid fa-ban"></i>
                          </div>
                        </span>
                      </a>
                    </div>
                  </td>
                </tr>
              ';
            }
          }
  } else {
      $url = $_SERVER["HTTP_REFERER"];
      header("location: $url?error=Nope");
      exit();
  }