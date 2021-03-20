<?php 
	session_start();
	require '../functions.php';

	$userEmail = esc($_POST['userEmail']);
	$userEmail = strtolower($userEmail);
	$userPassword = esc($_POST['userPassword']);

//? Functions 
  function userSelect($conn, $userEmail) {
    $sql="SELECT * FROM userAccounts WHERE email=?";
    $stmt = mysqli_stmt_init($conn);
  
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login-page.php?message=SQLstmtFailed");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
  
    if (!$row = mysqli_fetch_assoc($result)) {
      return false;
    } else {
      return $row;
    }
  }

  function userPasswordVerify($userDBData, $userPassword, $userEmail) {
    $dbPassword = $userDBData['password'];
    $dbEmail = strtolower($userDBData['email']);
    
    if (password_verify($userPassword, $dbPassword) && $dbEmail == $userEmail) {
      return true;
    } else { 
      return false;
    }
  }

//? Verify login

  // Ensure user came from the login-page by submitting the login form
  if (!isset($_POST['login'])) {
    header("Location: ../login-page.php?message=loginFailed");
    exit();
  }
  
  // Check if user filled out the email and password
  if (empty($userEmail) || empty($userPassword)) {
    header("Location: ../login-page.php?message=missingValues");
    exit();
  }
  
  // Call userSelect function which returns $row if user exists, or false if user doesn't exist
  $userSelect = userSelect($conn, $userEmail);
  if ($userSelect === false) {
    header("Location: ../login-page.php?message=userDoesNotExist");
    exit();
  } else {
    $userDBData = $userSelect;
  }

  // Here you could check whether the user has verified their email by seeing whether $userDBData["token"] is still set to the randomly generated token from registration
  
  // Verify password and email with database values
  $userPasswordVerify = userPasswordVerify($userDBData, $userPassword, $userEmail);

  // Fail login if user provided values do not match with database values
  if ($userPasswordVerify === false) {
    $conn->close();
    header("Location: ../login-page.php?message=incorrectPassword");
    exit();
  }
  // Log user in if user provided values match with database values
  if ($userPasswordVerify === true) {
    // Variable keys to be set into $_SESSION. If you need to store more variables inside of $_SESSION, simply add them to the $keyVariables array below but make sure they are in the database in the first place
    $keyVariables = array('profileID', 'firstname', 'lastname', 'email');
    
    foreach ($keyVariables as $val) {
      $_SESSION["user"][$val] = $userDBData[$val];
    }
    
    $_SESSION["user"]["loggedIn"] = true;
    $conn->close();
    header("Location: ../login-page.php?message=loginSuccess");
  }