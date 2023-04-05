<div class="footer-container spacer">
    <!-- <div class="wave">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div> -->
    <div class="footer-content">
      <div class="top">
        <div class="left-container">
          <h1>discussIt</h1>
          <span class="description footer-text">
            An unique take on a Discussion Board Website. Created by <a href="./previewaccount.php?userid=1">@SatanshuMishra</a> & <a class="disabled" >@BlackeAblitt</a>.
          </span>
        </div>
        <div class="right-container">
          <ul class="footer-list">
            <a href="./index.php">
              <li>Feed</li>
            </a>
            <a href="./discover.php">
              <li>Discover</li>
            </a>
            <a href="./Creatediscussion.php">
              <li>Create a Discussion</li>
            </a>
            <?php 
              if(!isset($_SESSION["uid"])) {
                echo '
                  <a href="./login.php">
                    <li>Log in/Sign up</li>
                  </a>
                ';
              } else {
                echo '
                  <a href="./scripts/logout-script.php">
                    <li>Sign out</li>
                  </a>
                '; 
              }
            ?>
            <a class="disabled">
              <li>Terms & Conditions</li>
            </a>
          </ul>
          <?php 
            if(isset($_SESSION["uid"])) {
              echo '
              <ul class="footer-list">
                <a href="./SettingsDirectory.php">
                  <li>Settings</li>
                </a>
                <a href="./previewaccount.php?userid='.$_SESSION["uid"].'">
                  <li>Your Profile</li>
                </a>
                <a>
                  <li></li>
                </a>
                <a>
                  <li></li>
                </a>
                <a>
                  <li></li>
                </a>
                <a>
                  <li></li>
                </a>
                <a>
                  <li></li>
                </a>
                <a>
                  <li></li>
                </a>
              </ul>
              ';
            }
          ?>
        </div>
      </div>
      <div class="bottom">
        <span class="copyrights footer-text">
          Copyrights Reserved: discussIt @2023
        </span>
        <a href="#reference-element">
          <div class="arrow-container">
            <i style="color:#000;" class="fa-solid fa-chevron-up"></i>
          </div>
        </a>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", (event) => {
      let backToTop = document.querySelector(".arrow-container");
      backToTop.addEventListener("mouseover", () => {
        backToTop.classList.add("fa-bounce");
      });
      backToTop.addEventListener("mouseout", () => {
        backToTop.classList.remove("fa-bounce");
      });
    });
  </script>