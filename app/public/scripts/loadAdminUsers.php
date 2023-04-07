<?php session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      require_once 'config.php';
      require_once 'functions-scripts.php';
      $users = getUsers($conn);
      if($users){
        foreach($users as $user){
          echo '
            <tr class="member-row">
              <td class="name">
                <div class="cell name-cell">
                  <img src="./uploads/profile-'.$user["id"].'.png?version=1231231" />
                  <div class="text-info">
                    <span class="name">'.$user["firstName"].' '.$user["lastName"].'</span>
                    <span class="username">@'.$user["username"].'</span>
                  </div>
                </div>
              </td>
              <td class="roles">
                <div class="cell">'.
                  (($user['isSuspended']) ? '<div class="suspended">Suspended</div>' : '<div class="active-member">Active</div>')
              .'</div>
              </td>
              <td class="roles">
                <div class="cell">'.
                  (($user["administratorPermissions"]) ? '<div class="admin">Admin</div>' : '<div class="member">Member</div>')
              .'</div>
              </td>
              <td class="options">
                <div class="cell">
                  <a class="delete-link-btn" href="./administrator-modify.php?userId='.$user["id"].'">
                    <span class="tooltip" data-text="Modify Account">
                      <div id="edit-'.$user["id"].'" class="option edit">
                        <i class="fa-solid fa-brush"></i>
                      </div>
                    </span>
                  </a>
                  <a class="delete-link-btn" href="./scripts/suspend-account.php?iAFgo3q5J2hfCTv1SShA=true&uid='.$user["id"].'">
                    <span class="tooltip" data-text="'.(($user["isSuspended"]) ? 'Un-Suspend Account' : 'Suspend Account').'">
                      <div class="option suspend">
                        <i class="fa-solid fa-icicles"></i>
                      </div>
                    </span>
                  </a>
                  <a class="delete-link-btn" href="./scripts/remove-account.php?iAFgo3q5J2hfCTv1SShA=true&uid='.$user["id"].'">
                    <span class="tooltip" data-text="Ban Account">
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