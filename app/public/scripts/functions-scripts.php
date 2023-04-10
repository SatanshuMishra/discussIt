<?php 
/**
 * Checks if a given username contains valid characters.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $username User's Username
 * @return true|false Returns boolean value represnting if the username is valid.
 */ 
function invalidUsername($username) {
  $result = true;
  if(preg_match("/^[a-zA-Z0-9]*$/", $username)){
    $result = false;
  }
  return $result;
}

function encryptPassword($password, $protocol){
  return password_hash($password, $protocol);
}



/**
 * Checks if a given username already exists within the database and returns it.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $username User's Username
 * @return array|false Returns array with query result for the user for the given username.
 */ 
function usernameExists($conn, $username){
  $sql = "SELECT * FROM user WHERE username = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfaileduniqueusername");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "s", $username);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}

function addTopic($conn, $discussionID,$topicID){
  $sql = "INSERT INTO topicManager(discussionID, topicID) VALUES (?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){
    header("location: ../index.php?error=stmtfailedtopicManager");
    exit();
  }
  //BIND ID VALUES
  mysqli_stmt_bind_param($stmt,"ii",$discussionID,$topicID);
  //EXECUTE
  mysqli_stmt_execute($stmt);
  //CLOSE
  mysqli_stmt_close($stmt);

}


/**
 * Checks is password is correct and returns a boolean value representing the result.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $currentPassword User's Current Password
 * @param string $username User's username
 * @return false|true If the password is correct
 */ 
function CurrentPasswordMatch($conn, $currentPassword, $username){
  // PULL CURRENT USERNAME 
  $unameExists = usernameExists($conn, $username);
  // CURRENT USERS PREVIOUS PASWORD
  $hashedpasswd = $unameExists["password"];
  //CHECK IF PASSWORDS MATCH FROM FORM AND DATABASE
  if(!password_verify($currentPassword,$hashedpasswd)){
    return false;
  }else{
    //CREATE SESSION VARIABLE OF USERNAME FOR INSERT IF THERE IS A MATCH
    $_SESSION['User'] = $unameExists["username"];
    return true;
  }
}



/**
 * Creates a user using the given information and add them to the database
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $firstName User's First Name (Not Required)
 * @param string $lastName User's Last Name (Not Required)
 * @param string $uname User's Username (Required)
 * @param string $pwd User's Password (Required)
 * @return void
 */ 
function createUser($conn, $firstName, $lastName, $uname, $pwd){
  $sql = "INSERT INTO user (firstName, lastName, username, password, demeritPoints, userKey, administratorPermissions, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedcreateuser");
    exit();
  }

  $hashedPwd = encryptPassword($pwd, PASSWORD_DEFAULT);
  $createdAt = gmdate('y-m-d h:i:s');
  $demeritPoints = 0;
  $userKey = implode("-", generateUUID());
  $adminPerms = 0;
  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ssssisis", $firstName, $lastName, $uname, $hashedPwd, $demeritPoints, $userKey, $adminPerms, $createdAt);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  $redirect = "../choose-profile-picture.php";
  loginUserR($conn, $uname, $pwd);

  setProfilePicture($_SESSION['uid']);

  header("location: $redirect");
  exit();
}

function createDiscussion($conn, $topic1, $topic2) {
  //Create New Discussion
  
  $sql = "INSERT INTO discussion (isVisible) VALUES (TRUE)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedcreatediscussion");
    exit();
  }
  //EXECUTE
  mysqli_stmt_execute($stmt);
  $discussionID = mysqli_stmt_insert_id($stmt);

  //CLOSE
  mysqli_stmt_close($stmt);
  //FETCH TOPIC IDS
  $id = getTopicID($conn,$topic1);
  $id2 = getTopicID($conn,$topic2);
  
  //ADD TOPIC IDS TO TOPICMANAGER TABLE 
  addTopic($conn, $discussionID,$id);
  addTopic($conn,$discussionID,$id2);
    return $discussionID;
}


function createDiscussionOne($conn, $topic1) {
  //Create New Discussion
  
  $sql = "INSERT INTO discussion (isVisible) VALUES (TRUE)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedcreatediscussion");
    exit();
  }
  //EXECUTE
  mysqli_stmt_execute($stmt);
  $discussionID = mysqli_stmt_insert_id($stmt);

  //CLOSE
  mysqli_stmt_close($stmt);
  //FETCH TOPIC IDS
  $id = getTopicID($conn,$topic1);
  
  //ADD TOPIC IDS TO TOPICMANAGER TABLE 
  addTopic($conn, $discussionID,$id);
    return $discussionID;
}

function createPost($conn, $postContent,$postTitle,$topic1,$topic2, $postCreator){
    if($topic2 == null){
      $discussionId = createDiscussionOne($conn, $topic1);
      //Getting UserID
      $unameExists = usernameExists($conn,$postCreator);
      $uid = $unameExists["id"];
      $sql = "INSERT into post(discussionID,authorID,postTitle,postContent,createdAt) VALUES(?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailedcreatePost");
        exit();
      }
      $createdAt = gmdate('y-m-d h:i:s');
      //SET DATA
      mysqli_stmt_bind_param($stmt,"sssss",$discussionId,$uid,$postTitle,$postContent,$createdAt);
    } else {
      $discussionId = createDiscussion($conn,$topic1,$topic2);
      //Getting UserID
      $unameExists = usernameExists($conn,$postCreator);
      $uid = $unameExists["id"];
      $sql = "INSERT into post(discussionID,authorID,postTitle,postContent,createdAt) VALUES(?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../index.php?error=stmtfailedcreatePost");
        exit();
      }
      $createdAt = gmdate('y-m-d h:i:s');
      //SET DATA
      mysqli_stmt_bind_param($stmt,"sssss",$discussionId,$uid,$postTitle,$postContent,$createdAt);
    }

    //EXECUTE
    mysqli_stmt_execute($stmt);

    //CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return $discussionId;
    
}

function getTopicID($conn, $topic){
  $sql = "SELECT id FROM topicType WHERE topic = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedtopicId");
    exit();
  }
  //BIND TOPIC NAME TO SQL
  mysqli_stmt_bind_param($stmt,"s",$topic);
  
  //EXECUTE STATMENT
  mysqli_stmt_execute($stmt);
  //GET RESULT
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  
  return $id;
}

/**
 * Log's in a user with the given username and password. Does NOT redirect the user to index.php upon successful login.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $uname User's username
 * @param string $pwd User's password
 * @return void
 */ 
function loginUserR($conn, $uname, $pwd){
  $unameExists = usernameExists($conn, $uname);
  
  if($unameExists === false){
    header("location: ../login.php?error=invalidusernameorpassword");
    exit();
  }

  $pwdHashed = $unameExists["password"];
  $checkPwd = password_verify($pwd, $pwdHashed);

  if($checkPwd === false){
    header("location: ../login.php?error=invalidusernameorpassword");
    exit();
  }
  else if($checkPwd === true){
    session_start();
    $_SESSION["uid"] = $unameExists["id"];
    $_SESSION["uname"] = $unameExists["username"];
  }
}



/**
 * Log's in a user with the given username and password. Does NOT redirect the user to index.php upon successful login.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $uname User's username
 * @param string $pwd User's password
 * @return void
 */ 
function loginUser($conn, $uname, $pwd){
  $unameExists = usernameExists($conn, $uname);
  
  if($unameExists === false){
    header("location: ../login.php?error=invalidusernameorpassword");
    exit();
  }

  $pwdHashed = $unameExists["password"];
  $checkPwd = password_verify($pwd, $pwdHashed);

  if($checkPwd === false){
    header("location: ../login.php?error=invalidusernameorpassword");
    exit();
  }
  else if($checkPwd === true){
    session_start();
    $_SESSION["uid"] = $unameExists["id"];
    $_SESSION["uname"] = $unameExists["username"];
    if(isset($_SESSION["redirect_url"])){
      $url = $_SESSION["redirect_url"];
      unset($_SESSION["redirect_url"]);
      header("location: ../$url");
    } else {
      header("location: ../index.php ");
    }
  }
}



/**
 * Gets a discussion for a given discussion ID
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion's ID
 * @return array|false Returns array with query result for the discussion for the given discussion ID.
 */ 
function getDiscussion($conn, $discussid) {
  $sql = "SELECT * FROM discussion WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetdiscussion");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}
/**
 * Gets a discussions by a given author
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $authorId Discussion's author ID
 * @return array|false Returns array with query result for the discussion for the given discussion ID.
 */ 
function getDiscussionByAuthorId($conn, $authorId) {
  $sql = "SELECT discussion.id FROM discussion JOIN post ON discussion.id = post.discussionId WHERE authorId = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetdiscussionbyauthorid");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $authorId);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets a replies by a given author
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $authorId Discussion's author ID
 * @return array|false Returns array with query result for the discussion for the given discussion ID.
 */ 
function getRepliesByAuthorId($conn, $authorId) {
  $sql = "SELECT discussionId FROM reply WHERE authorId = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetrepliesbyauthorid");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $authorId);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}




/**
 * Gets the post for a given discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion's ID
 * @return array|false Returns array with query result for the post for the given discussion.
 */ 
function getPost($conn, $discussid) {
  $sql = "SELECT * FROM post JOIN user ON post.authorId = user.id WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetpost");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets all the topics for a given discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion's ID
 * @return array|false Returns array with query results for all the topics for the given discussion.
 */ 
function getTopics($conn, $discussid) {
  $sql = "SELECT topic FROM topicManager JOIN topicType ON topicManager.topicId = topicType.id WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgettopics");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_all($results, MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets all the replies for a given discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion's ID
 * @return array|false Returns array with query results for all the replies for the given discussion.
 */ 
function getReplies($conn, $discussid){
  $sql = "SELECT reply.id, authorId, replyTo, username, content, reply.createdAt FROM reply JOIN user on reply.authorId = user.id WHERE discussionId = ? ORDER BY createdAt DESC;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  $replies = array();
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    $replies[] = $row;
    return json_encode($replies);
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}




/**
 * Add's a given reply to the reply table.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $authorid Reply author's ID
 * @param integer $discussionid Discussion's ID for reply
 * @param string $replyContent Reply content
 * @return true|false Returns boolean representing whether the reply was successfully inserted.
 */ 
function postReply($conn, $replyTo, $authorid, $discussionid, $replyContent){
  $sql = "INSERT INTO reply (replyTo, discussionId, authorId, content, createdAt) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedpostreply");
    exit();
  }
  $time = gmdate('Y-m-d h:i:s');
  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "sssss", $replyTo, $discussionid, $authorid, $replyContent, $time);

  // EXECUTE $STMT PREPARED STATEMENT
  $isSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
  return $isSuccessful;
}



// TODO: IMPLEMENT AJAX TO LOAD DISCUSSIONS 10 AT A TIME
/**
 * Gets all the discussions.
 * @param mysqli|false $conn MySQLi Connection Object
 * @return array|false Returns array with query results for all the discussions.
 */ 
function getDiscussions($conn, $onlyVisible = false){
  $sql = "SELECT discussion.id AS id, isVisible, authorId, postTitle, postContent, createdAt FROM discussion JOIN post ON discussion.id = post.discussionId ORDER BY createdAt DESC;";
  if($onlyVisible){
    $sql = "SELECT discussion.id AS id, isVisible, authorId, postTitle, postContent, createdAt FROM discussion JOIN post ON discussion.id = post.discussionId WHERE isVisible = TRUE ORDER BY createdAt DESC;";
  }
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetdiscussions");
    exit();
  }

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }


  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}

/**
 * Gets all the discussions.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param int $topicId Integer representing the required topic ID
 * @return array|false Returns array with query results for all the discussions.
 */ 
function getDiscussionsByTopic($conn, $topicId){
  $sql = "SELECT discussTable.id, isVisible, authorId, postTitle, postContent, createdAt FROM topicManager JOIN (SELECT discussion.id AS id, isVisible, authorId, postTitle, postContent, createdAt FROM discussion JOIN post ON discussion.id = post.discussionId ORDER BY createdAt DESC) AS discussTable ON topicManager.discussionId = discussTable.id WHERE topicManager.topicId = ?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetdiscussions");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $topicId);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }


  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}

function generateSQL($authorCount, $titleCount, $topicCount){

  $topicWhereClause = "(";
  $titleWhereClause = "(";
  $authorWhereClause = "(";

  for($i=0; $i < $topicCount; $i++){
    if($i == $topicCount - 1){
      $topicWhereClause = $topicWhereClause." topicType.topic = ?)";
    } else {
      $topicWhereClause = $topicWhereClause." topicType.topic = ? OR";
    }
  }

  for($i=0; $i < $titleCount; $i++){
    if($i == $titleCount - 1){
      $titleWhereClause = $titleWhereClause." discussPostTable.postTitle LIKE CONCAT('%', ? ,'%'))";
    } else {
      $titleWhereClause = $titleWhereClause." discussPostTable.postTitle LIKE CONCAT('%', ? ,'%') OR";
    }
  }

  for($i=0; $i < $authorCount; $i++){
    if($i == $authorCount - 1){
      $authorWhereClause = $authorWhereClause." user.username = ?)";
    } else {
      $authorWhereClause = $authorWhereClause." user.username = ? OR";
    }
  }



  return  "SELECT DISTINCT discussId, isVisible, authorId, postTitle, postContent, createdAt FROM topicType JOIN (SELECT discussId, isVisible, authorId, postTitle, postContent, createdAt, topicId FROM topicManager JOIN (SELECT id, firstName, lastName, username, password, biography, twitterAccount, linkedinAccount, pgwebAddress, demeritPoints, userKey, isSuspended, administratorPermissions, discussId, isVisible, authorId, postTitle, postContent, discussPostTable.createdAt FROM user JOIN (SELECT discussion.id AS discussId, isVisible, authorId, postTitle, postContent, createdAt FROM discussion JOIN post ON discussion.id = post.discussionId WHERE isVisible = TRUE) AS discussPostTable ON user.id = discussPostTable.authorId".(($authorCount > 0  || $titleCount > 0) ? " WHERE ".

    (
      (
        ($authorCount > 0) ? $authorWhereClause.(($titleCount > 0) ? " AND ": "") : "").(($titleCount > 0) ? $titleWhereClause : "")
      ) 
      : "")
      
      .") AS tableB ON topicManager.discussionId = tableB.discussId) AS tableC ON topicType.id = tableC.topicId".
      
      (($topicCount > 0) ? " WHERE ".$topicWhereClause : "").";";
}


function getSearchResults($conn, $authorArray, $titleArray, $topicArray){
  $authorCount = count($authorArray);
  $titleCount = count($titleArray);
  $topicCount = count($topicArray);

  $sqlSt = generateSQL($authorCount, $titleCount, $topicCount);
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sqlSt)){
    header("location: ../index.php?error=stmtfailedgetdiscussions");
    exit();
  }
  $structure = str_repeat("s", ($authorCount + $titleCount + $topicCount));
  $arr = [];
  array_push($arr, ...$authorArray, ...$titleArray, ...$topicArray);
  mysqli_stmt_bind_param($stmt, $structure, ...$arr);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}

/**
 * Gets all the contributions (Discussions & Replies) by a given user.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $authorid Author ID of the discussion
 * @return array|false Returns array with query results for all the discussions.
 */ 
function getContributionsByAuthor($conn, $authorid){
  $sql = "SELECT DISTINCT * FROM (SELECT discussion.id AS id, isVisible, authorId, postTitle FROM discussion JOIN post ON discussion.id = post.discussionId WHERE authorId = ? ORDER BY createdAt DESC) AS tableA UNION (SELECT discussTable.id, isVisible, post.authorId, postTitle from post JOIN (SELECT discussion.id AS id, isVisible, authorId FROM discussion JOIN reply on discussion.id = reply.discussionId WHERE authorId = ?) AS discussTable ON post.discussionId = discussTable.id);";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetcontributions");
    exit();
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ii", $authorid, $authorid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets the user associated with a given ID.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid Discussion ID
 * @return array|false Returns array with query results for user matching given ID.
 */ 
function getUsers($conn){
  $sql = "SELECT * FROM user;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedgetusers");
    exit();
  }

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets the user associated with a given ID.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid Discussion ID
 * @return array|false Returns array with query results for user matching given ID.
 */ 
function getUserByID($conn, $userid){
  $sql = "SELECT * FROM user WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedgetuserbyid");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $userid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  //mysqli_stmt_close($stmt);
}


/**
 * Gets the reply associated with a given ID.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid Discussion ID
 * @return array|false Returns array with query results for user matching given ID.
 */ 
function getReplyByID($conn, $userid){
  $sql = "SELECT * FROM reply WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedgetuserbyid");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $userid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}


/**
 * Gets the number of replies for a given discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion ID
 * @return array|false Returns array with query results for number of replies for given discussion.
 */ 
function getRepliesCount($conn, $discussid){
  $sql = "SELECT COUNT(discussionId) as numReplies FROM reply WHERE discussionId = ? GROUP BY discussionId;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedgetrepliescount");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = mysqli_fetch_assoc($results)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $row;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Gets the number of reactions for a given discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $discussid Discussion ID
 * @return integer Returns the number of reactions.
 */ 
function getNumberOfReactions($conn, $discussid){
  $sql = "SELECT userid FROM discussionReactionManager WHERE discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedlikemanager");
    exit();
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussid);

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results -> fetch_all(MYSQLI_ASSOC)){
    
    // RETURN COUNT
    return count($row);
  }
  else {
    $results = 0;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}


/**
 * Checks if the given user has reacted to a give discussion.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User's ID
 * @param integer $discussid Discussion ID
 * @return true|false Returns boolen value representing whether the user has reacted to the given discussion.
 */ 
function checkIfReacted($conn, $userid, $discussid){
  $sql = "SELECT userid FROM discussionReactionManager WHERE userid = ? AND discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ii", $userid, $discussid);

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return true;
  } else {
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return false;
  }
}



/**
 * Adds a reaction to discussionReactionManager.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User's ID
 * @param integer $discussid Discussion ID
 * @return void
 */ 
function addReaction($conn, $userid, $discussid){
  $sql = "INSERT INTO discussionReactionManager (userid, discussionid) VALUES (?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedinsertreaction");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ii", $userid, $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  try {
    mysqli_stmt_execute($stmt);
  } catch (mysqli_sql_exception $exception) {
    mysqli_stmt_close($stmt);
    return;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}



/**
 * Removes a reaction from the discussionReactionManager table.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User ID value
 * @param integer $discussid Discussion ID value
 * @return void
 */ 
function removeReaction($conn, $userid, $discussid){
  $sql = "DELETE FROM discussionReactionManager WHERE userid = ? AND discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremovereaction");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ii", $userid, $discussid);

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
  // exit();
}



/**
 * Generates a UUID for the user.
 * @return null|array Returns the arrary containing the string representation of the user's UUID
 */ 
function generateUUID($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return str_split(bin2hex($data), 4);
}



// TODO : CHANGE TO TAKE IN A GIVEN FORMAT INSTEAD OF STATIC
/**
 * Takes a DATETIME string value (SQL Format) and returns a string representation in a given format.
 * @param String $sqlTime Date in DATETIME format (SQL)
 * @return string|false Returns string representation of date in 'YYYY-MM-DD' format.
 */ 
function convertSQLTime($sqlTime){
  $phpdate = strtotime( $sqlTime );
  return date( 'Y-m-d', $phpdate );
}



/**
 * Authenticates username with recovery key.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $username User's username
 * @param string $recoveryKey User's Recovery Key
 * @return true|false Returns a boolen value representing whether the username and recovery key are a match.
 */ 
function authenticateRecovery($conn, $username, $recoveryKey){
  if($usernameExists = usernameExists($conn, $username)){
    if($recoveryKey == $usernameExists["userKey"]){
      return true;
    } else {
      return false;
    }
  } else {
    header("location: ../forgot-password-login.php?error=usernamenotfound");
    exit();
  }
}


/**
 * Resets the given user's password with the one provided.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param string $username User's username
 * @param string $new_password The user's new password
 * @return true|false Returns a boolen value representing whether the update was successful.
 */ 
function resetPassword($conn, $username, $new_password){
  $sql = "UPDATE user SET password = ? WHERE username = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedresetpassword");
    exit();
  }

  // ENCRYPT PASSWORD
  $encryptedPassword = encryptPassword($new_password, PASSWORD_DEFAULT);

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ss", $encryptedPassword, $username);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

/**
 * Randomly set's the default profile picture for a given user.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User's ID
 * @return void
 */ 
function setProfilePicture($userid){
  $randomValue = rand(1, 10);
  $from = "../images/user-profile-pictures/user-profile-collection-$randomValue.png";
  $to  = "../uploads/profile-$userid.png";
  $success = copy($from, $to);
  return $success;
}

/**
 * Updates user profile with additional details.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User's ID
 * @param string $bio Biography Text
 * @param string $twitter Twitter account address
 * @param string $linkedin LinkedIn account address
 * @param string $pweb Personal website account address
 * @return true|false Returns a boolen value representing whether the update was successful.
 */ 
function personalizeUser($conn, $userid, $bio, $twitter, $linkedin, $pweb){
  $sql = "UPDATE user SET biography = ?, twitterAccount = ?, linkedinAccount = ?, pgwebAddress = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedpersonalizeuser");
    exit();
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "sssss", $bio, $twitter, $linkedin, $pweb, $userid);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

/**
 * Gets the top 10 discussions with the most replies ordered by createdAt for the last 24hr.
 * @param mysqli|false $conn MySQLi Connection Object
 * @return array|false Returns array with query results for all the discussions.
 */ 
function getTopDiscussions($conn){
  $sql = "SELECT DISTINCT discussion.id, title FROM discussion JOIN (SELECT reply.discussionId as id, post.postTitle as title FROM post JOIN reply ON post.discussionId = reply.discussionId WHERE post.createdAt > NOW() - INTERVAL 1 DAY AND reply.createdAt > NOW() - INTERVAL 1 DAY ORDER BY post.createdAt, reply.createdAt) AS postRepliesTable ON discussion.id = postRepliesTable.id LIMIT 10;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetdiscussions");
    exit();
  }

  // EXECUTE $STMT PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($rows = $results->fetch_all(MYSQLI_ASSOC)){
    // RETURN DATA FROM PREPARED STATEMENT
    return $rows;
  }
  else {
    $results = false;
    return $results;
  }

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);
}

/**
 * Checks is the given user is an administrator.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param int $userid User's ID
 * @return true|false Returns boolean value indicating if the user is an administrator.
 */ 
function hasAdministratorPermissions($conn, $userid){
  $user = getUserByID($conn, $userid);
  return $user["administratorPermissions"] == true;
}

function updateUser($conn, $userid, $enteredUsername, $enteredFirstName, $enteredLastName, $enteredDemeritPoints, $enteredAdministratorPerms) {
  $sql = "UPDATE user SET username = ?, firstName = ?, lastName = ?, demeritPoints = ?, administratorPermissions = ? WHERE id = ? ;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "sssiii", $enteredUsername, $enteredFirstName, $enteredLastName, $enteredDemeritPoints, $enteredAdministratorPerms, $userid);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function updateUserName($conn, $userid, $enteredFirstName, $enteredLastName) {
  $sql = "UPDATE user SET firstName = ?, lastName = ? WHERE id = ? ;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "ssi", $enteredFirstName, $enteredLastName, $userid);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function removeUserByID($conn, $userid) {
  $sql = "DELETE FROM user WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $userid);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  removeProfilePicture($userid);

  return ($wasSuccessful) ? "discussionDeleteSuccessful" : "discussionDeleteFailed";
}

/**
 * Removes's the profile picture for a given user.
 * @param mysqli|false $conn MySQLi Connection Object
 * @param integer $userid User's ID
 * @return void
 */ 
function removeProfilePicture($userid){
  return unlink("../uploads/profile-$userid.png");
}

function removeTopicsByDiscussionID($conn, $discussId) {
  $sql = "DELETE FROM topicManager WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function removeReportsByDiscussionID($conn, $discussId) {
  $sql = "DELETE FROM report WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function removeReplyReactionsByDiscussionID($conn, $discussId) {
  $sql = "DELETE FROM replyReactionManager WHERE discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function removeDiscussionReactionsByDiscussionID($conn, $discussId) {
  $sql = "DELETE FROM discussionReactionManager WHERE discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function helperUpdateReplyByDiscussionID($conn, $discussId) {
  $sql = "UPDATE reply SET replyTo = NULL WHERE discussionid = ?;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    return false;
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function removeReplyByDiscussionID($conn, $discussId) {
  helperUpdateReplyByDiscussionID($conn, $discussId);
  $sql = "DELETE FROM reply WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}


function removePostByDiscussionID($conn, $discussId) {
  $sql = "DELETE FROM post WHERE discussionId = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return $wasSuccessful;
}

function checkUserViolation($conn, $userId){
  $user = getUserByID($conn, $userId);
  if($user["demeritPoints"] >= 3){
    suspendUserByID($conn, $userId);
  }
}

function demeritUser($conn, $authorId) {
  $author = getUserByID($conn, $authorId);
  if($author["demeritPoints"] < 3){
    $sql = "UPDATE user SET demeritPoints = demeritPoints + 1 WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
      return false;
    }

    // SET DATA IN PREPARED STATEMENT
    mysqli_stmt_bind_param($stmt, "i", $authorId);

    // EXECUTE STATEMENT
    $wasSuccessful = mysqli_stmt_execute($stmt);

    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);

    checkUserViolation($conn, $authorId);
    return $wasSuccessful;
  }
}

function removeDiscussionByID($conn, $discussId, $authorId) {
  removeTopicsByDiscussionID($conn, $discussId);
  removeReportsByDiscussionID($conn, $discussId);
  removeReplyReactionsByDiscussionID($conn, $discussId);
  removeDiscussionReactionsByDiscussionID($conn, $discussId);
  removeReplyByDiscussionID($conn, $discussId);
  removePostByDiscussionID($conn, $discussId);

  $sql = "DELETE FROM discussion WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  // SET DATA INTO PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE $STMT PREPARED STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  demeritUser($conn, $authorId);

  return ($wasSuccessful) ? "discussionDeleteSuccessful" : "discussionDeleteFailed";
}

function suspendUserByID($conn, $userid) {
  $user = getUserByID($conn, $userid);
  $sql = "UPDATE user SET isSuspended = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);
  
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedremoveuser");
    exit();
  }

  if($user['isSuspended']){
    $suspend = 0;
    // SET DATA INTO PREPARED STATEMENT
    mysqli_stmt_bind_param($stmt, "ii", $suspend, $userid);
  } else {
    $suspend = 1;
    // SET DATA INTO PREPARED STATEMENT
    mysqli_stmt_bind_param($stmt, "ii", $suspend, $userid);
  }

  // EXECUTE $STMT PREPARED STATEMENT
  $success = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  if($success){  
    if($suspend){
      return "usersuccessfullysuspended";
    } else {
      return "usersuccessfullyunsuspended";
    }
  } else {
    return false;
  }
}

function toggleDiscussionVisibility($conn, $discussId){
  $sql = "UPDATE discussion SET isVisible = NOT isVisible WHERE discussion.id = ?;";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../signup.php?error=stmtfailedresetpassword");
    exit();
  }

  // SET DATA IN PREPARED STATEMENT
  mysqli_stmt_bind_param($stmt, "i", $discussId);

  // EXECUTE STATEMENT
  $wasSuccessful = mysqli_stmt_execute($stmt);

  // CLOSE STATEMENT
  mysqli_stmt_close($stmt);

  return ($wasSuccessful) ? "discussionUpdateSuccessfully" : "discussionUpdateUnsuccessful";
}

function getNumberOfUsers($conn){
  $sql = "SELECT COUNT(*) AS numOfMembers FROM user;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return $row;
  } else {
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return false;
  }
}

function getNumberOfDiscussions($conn){
  $sql = "SELECT COUNT(*) AS numOfMembers FROM discussion;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return $row;
  } else {
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return false;
  }
}

function getUsersByDay($conn){
  $sql = "SELECT COUNT(*) AS count FROM user GROUP BY createdAt ORDER BY createdAt ASC LIMIT 6;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return $row;
  } else {
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return false;
  }
}

function getDiscussionsByDay($conn){
  $sql = "SELECT COUNT(*) AS count FROM post GROUP BY createdAt ORDER BY createdAt ASC LIMIT 6;";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../index.php?error=stmtfailedgetreplies");
    exit();
  }

  // EXECUTE PREPARED STATEMENT
  mysqli_stmt_execute($stmt);

  // GET RESULT FROM $STMT PREPARED STATEMENT
  $results = mysqli_stmt_get_result($stmt);
  if($row = $results->fetch_all(MYSQLI_ASSOC)){
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return $row;
  } else {
    // CLOSE STATEMENT
    mysqli_stmt_close($stmt);
    return false;
  }
}
?>