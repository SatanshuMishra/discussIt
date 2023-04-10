<?php session_start(); 
  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?invalidadminaccessnotloggedin");
    exit();
  }
  require_once "./scripts/config.php";
  require_once "./scripts/functions-scripts.php";
   
  if(!(getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
    header("Location: ./index.php?invalidadminaccessnotadmin");
    exit();
  }
  $sessionUser = getUserByID($conn, $_SESSION["uid"]);
  header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/administrator-dashboard.css">
  <!-- LOCAL JS -->
  <!-- <script src="js/admin-portal.js"></script> -->
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Admin Portal</title>
</head>
<body>
  <nav class="nav-sidebar">
    <div class="upper-section">
      <div class="logo-container">
        <a href="./index.php">
          <img class="logo" src="./images/logoDarkBlue.png" alt="logo">
        </a>
      </div>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a href="./administrator-dashboard.php">
          <li class="nav-option active">
            <i class="fa-solid fa-chart-pie"></i>
          </li>
        </a>
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-regular fa-envelope"></i>
          </li>
        </a>
      </ul>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a href="./administrator-portal.php">
          <li class="nav-option">
            <i class="fa-regular fa-user"></i>
          </li>
        </a>
        <a href="./administrator-discussions.php">
          <li class="nav-option">
            <i class="fa-regular fa-message"></i>
          </li>
        </a>
      </ul>
    </div>
    <div class="lower-section">
      <div class="profile-image-conatainer">
        <img <?php echo 'src="./uploads/profile-'.$_SESSION["uid"].'.png?version=1231231"' ?> alt="ProflePicture">
      </div>
      <div class="exit-container">
        <a href="./index.php">
          <i class="fa-solid fa-door-open"></i>
        </a>
      </div>
    </div>
  </nav>

  <div class="toast">
    <div class="toast-content">
      <i class="fa-solid fa-bell check-icon"></i>
      <div class="message">
        <span class="text-toast text-1"></span>
        <span class="text-toast text-2"></span>
      </div>
      </div>
        <i class="fa-solid fa-xmark close-icon"></i>
      <div class="progress">
    </div>
  </div>

  <div class="content">
    <div class="header-container">
      <div class="view-info-container">
        <div class="icon-container">
          <i class="fa-solid fa-chart-pie"></i>
        </div>
        <div class="info">
          <span class="page-title">Dashboard</span>
          <span class="user">Welcome, <b><?php echo $sessionUser["firstName"] ?></b>!</span>
        </div>
      </div>
    </div>
    <div class="members-content">
      <div class="overview-statistics">
        <div class="members-stats stats-overview-container">
          <?php 
            $numberOfUsers = getNumberOfUsers($conn);
          ?>

          <div class="text-info">
            <span>Members</span>
            <span class="count"><?php echo $numberOfUsers[0]["numOfMembers"] ?></span>
          </div>

          <div>
            <canvas id="myChart"></canvas>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <script>
            const ctx = document.getElementById('myChart');
            <?php 
              $dicussionsByDay = getUsersByDay($conn);
              $data = "";
              foreach ($dicussionsByDay AS $discus) {
                $data = $data.$discus['count'].',';
              }
            ?>
            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                  data: [<?php echo $data ?>],
                  backgroundColor: ["#1E4736", "#15B471"], 
                  borderWidth: 1,
                  borderRadius: 15,
                }]
              },
              options: {
                plugins: { 
                  legend: { 
                    display: false 
                  }
                },
                scales: {
                  x: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    }
                  },
                  y: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    },
                    border:{
                      display:false
                    }
                  }
                }
              }
            });
          </script>
        </div>
        <div class="discussion-stats stats-overview-container">
          <div class="text-info">
            <span>Discussions</span>
            <?php 
              $numberOfDiscussions = getNumberOfDiscussions($conn);
            ?>
            <span class="count"><?php echo $numberOfDiscussions[0]["numOfMembers"] ?></span>
          </div>

          <div>
            <canvas id="myChartB"></canvas>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <script>
            const ctxb = document.getElementById('myChartB');
            <?php 
              $dicussionsByDay = getDiscussionsByDay($conn);
              $data = "";
              foreach ($dicussionsByDay AS $discus) {
                $data = $data.$discus['count'].',';
              }
            ?>
            new Chart(ctxb, {
              type: 'bar',
              data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                  data: [<?php echo $data ?>],
                  backgroundColor: ["#876409", "#C99103"], 
                  borderWidth: 1,
                  borderRadius: 15,
                }]
              },
              options: {
                plugins: { 
                  legend: { 
                    display: false 
                  }
                },
                scales: {
                  x: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    }
                  },
                  y: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    },
                    border:{
                      display:false
                    }
                  }
                }
              }
            });
          </script>
        </div>
        <div class="reports-stats stats-overview-container">
          <div class="text-info">
            <span>Reports</span>
            <span class="count">0</span>
          </div>

          <div>
            <canvas id="myChartC"></canvas>
          </div>

          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

          <script>
            const ctxc = document.getElementById('myChartC');

            new Chart(ctxc, {
              type: 'bar',
              data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                  data: [0, 0, 0, 0, 0, 0],
                  backgroundColor: ["#4D1D1D", "#A10F0F"], 
                  borderWidth: 1,
                  borderRadius: 15,
                }]
              },
              options: {
                plugins: { 
                  legend: { 
                    display: false 
                  }
                },
                scales: {
                  x: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    }
                  },
                  y: {
                    beginAtZero: true,
                    ticks: {
                      display: false
                    },
                    grid: {
                      drawBorder: false,
                      display: false,
                      drawTicks: false,
                      drawOnChatArea: false
                    },
                    border:{
                      display:false
                    }
                  }
                }
              }
            });
          </script>
        </div>
      </div>










    <!-- <div>
        <canvas id="myChart"></canvas>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      </script> -->

    </div>
  </div>
  <script>
    $(document).ready(function () {
      let toast = document.querySelector(".toast");
      let close = document.querySelector(".close-icon");
      let progress = document.querySelector(".progress");
      console.log(toast);
      console.log(close);
      console.log(progress);

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);

      console.log(queryString);
      console.log(urlParams);
      if(urlParams.has('message')){
        let title = document.querySelector(".text-1");
        let description = document.querySelector(".text-2");
        if(urlParams.get('message') == "usersuccessfullysuspended"){
          title.innerHTML= "Success";
          description.innerHTML= "The user was successfully suspended!";
        } else if(urlParams.get('message') == "usersuccessfullyunsuspended"){
          title.innerHTML= "Success";
          description.innerHTML= "The user account un-suspended!";
        } else if(urlParams.get('message') == "usersuccessfullyremoved"){
          title.innerHTML= "Success";
          description.innerHTML= "The user was successfully banned!.";
        } else if(urlParams.get('message') == "updatesuccessful"){
          title.innerHTML= "Update Successful";
          description.innerHTML= "The user was updated successfully!.";
        } 
        setTimeout(() => {
          toast.classList.add("active-toast");
          progress.classList.add("active-toast");
          
          setTimeout(() => {
            toast.classList.remove("active-toast");
          }, 5000);
        }, 50);
      }

      close.addEventListener("click", () => {
        toast.classList.remove("active-toast");
      })

      function loadUsers() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './scripts/loadAdminUsers.php');
        xhr.send();

        xhr.onload = function(){
          if (xhr.status != 200) { // analyze HTTP status of the response
            console.log(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
          } else { // show the result
            document.querySelector('#table-body').innerHTML = xhr.response; // response is the server response
          }
        }
        window.setTimeout(loadUsers, 1000);
      }
      // loadUsers();
    });
  </script>
</body>
</html>