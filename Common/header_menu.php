<?PHP
require_once (__DIR__.'/../Scripts/common.php');
?>
<nav>
    <ul>
    <li><a href="Home.php"><img src="Images/logo.png" height="50px" alt="Textbook Savers Logo" style="position: fixed; left: 5px; top: 0px;" />Home</a></li>
      <!-- <li><a href="Home.php">Home</a></li> -->

      <li><a href="About/About.php">About Us</a>
        <ul>
        <li>
          <a href="About/HowItWorks.php">How-It-Works</a>
        </li>
        <li>
          <a href="About/Contact.php">Contact Us</a>
        </li>
        </ul>
      </li>
      <li><a href="User/BuyTextbook.php">Buy Textbook</a></li>
      <li><a href="User/SellTextbook.php">Sell Textbook</a></li>
      <?PHP
      if (isset($_SESSION['UserId'])) {
      $currentUser = getUser($_SESSION['UserId']);
      /*
      $FirstName = $_SESSION['UserFirstName'];
      $MiddleName = $_SESSION['UserMiddleName'];
      $LastName = $_SESSION['UserLastName'];
      */
      
      ?>
      <li><a href="User/MyAccount.php">
      <?php 
      
      if (isset($currentUser['FacebookUsername']) && ($currentUser['FacebookUsername'] != NULL || $currentUser['FacebookUsername'] != "")) 
        echo "<img src=\"http://graph.facebook.com/".$currentUser['FacebookUsername']."/picture/\" height=\"30px\" width=\"30\" alt=\"User's Facebook profile photo\" style=\"position: fixed;\" />";
      //echo $FirstName.(isset($MiddleName)?" ".$MiddleName." ":"").$LastName;  
      echo "<span style=\"margin-left: 30px;\">".$currentUser['FirstName']." ".substr($currentUser['LastName'],0,1)."</span>";
      ?>
			</a>
        <ul>
            <li>
              <a href="User/MyAccount.php">
              My Account
              </a>
            </li>
            <li>
              <a href="User/Messages.php">
              My Messages
              </a>
            </li>
            <li>       
              <a href="User/AddToWishlist.php">
              Add to Wish-list
              </a>
            </li>
            <li>       
              <a href="User/CreateTextbook.php">
              Add a new Textbook
              </a>
            </li>
            <li>       
              <a href="User/CreateCourse.php">
              Add a new Course
              </a>
            </li>
            <li>       
              <a href="User/CreateSubject.php">
              Add a new Subject
              </a>
            </li>
            <li>       
              <a href="User/Logout.php">Logout</a>
            </li>
        </ul>
				<li>
				<a href="User/Messages.php">
				<img src="Images/mail2.png" width="36" height="25" alt="mail_icon" style="position: fixed; margin-left: -21px; "/>
        <span class="notificationCount" id="notificationCounter1" style="position: fixed; margin-left: -10px;">0</span></a>
				</li>
      <?PHP
      }
      else
      {
      ?>
      <li><a id="loginMenuItem" href="User/Login.php">Login</a>
      <script>
        $("#loginMenuItem").attr("href","javascript:loginPopup();");
      </script>
        <ul>
        <!--
            <li class="LoginPanel">            
              <form id="loginForm" name="loginForm" 
                  action="Scripts/processLogin.php" method="post"
                  onsubmit="return validateLoginForm();">                
                <fieldset>
                <legend><strong>Login</strong></legend>
                
                  <table summary="Login Form">
                    <tr>
                      <td>User Login (Email):</td>
                      <td valign="top"><input name="UserName" type="text"
                      id="UserName" size="20" /></td>
                    </tr>
                    <tr>
                      <td>Password:</td>
                      <td valign="top"><input name="UserPassword" type="password"
                      id="UserPassword" size="20" /></td>
                    </tr>
                    <tr>
                      <td><input type="submit" value="Login" /></td>
                      <td><input type="reset" value="Reset Form" /></td>
                    </tr>
                    <?php if ($retry == true) { ?>
                    <tr><td><hr /></td></tr>
                    <tr>
                      <td valign="top" colspan="2">There was an error in the login.<br />
                       Either username or password was incorrect.<br />
                       Please re-enter the correct login information.</td>
                    </tr>
                    <?php } ?>
                  </table>
                  
                  </fieldset>
              </form>
            </li>
            -->
        </ul>
      </li>  
      <li>
      <a href="User/SignUp.php">Sign Up</a>
      </li>        
      <?PHP
      }
      ?>
      
    </ul>
</nav>

<a href="About/HowItWorks.php"><div id="cornerBanner">Beta</div></a>

<div id="loginPanel" style="background-color: rgba(255,255,255,0.8); width: 100%; height: 0px; overflow: hidden;">Sign in: <input type="text">Test</input></div>