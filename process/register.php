<?php 
	session_start();
  require "../functions.php";
  
  // Escape special chars using the function inside of functions.php
  $userEmail = esc($_POST['userEmail']);
	$userEmail = strtolower($userEmail);
	$userFirstname = esc($_POST['userFirstname']);
	$userLastname = esc($_POST['userLastname']);
	$userPassword1 = esc($_POST['userPassword1']);
	$userPassword2 = esc($_POST['userPassword2']);
  // Hash the password using BCRYPT with an increased cost of 12 (default=10) which improves security at a cost of slightly increasing run time. To leave as default, delete the third parameter alltogether. 
	$passwordHash = password_hash($userPassword2, PASSWORD_DEFAULT, ['cost' => 12]);

//? Verify user provided values

// Ensure user came from the login-page by submitting the register form
if (!isset($_POST["register"])) {
  header("Location: ../login-page.php?message=registerFailed");
  exit();
}

if (isset($userEmail) && isset($userPassword1) && isset($userPassword2) && isset($passwordHash)) {
  // Check if user filled out the email, password1 and password2
  if (empty($userEmail) || empty($userPassword1) || empty($userPassword2)) {
    header("Location: ../login-page.php?message=missingValues");
    exit();
  }

  // Check if passwords match
  if ($userPassword1 !== $userPassword2) {
    header("Location: ../login-page.php?message=passwordsDoNotMatch");
    exit();
  }
  
  // Check if password is 6 - 24 characters
	if (mb_strlen($userPassword1) < 6 || mb_strlen($userPassword1) > 24) {
    header("Location: ../login-page.php?message=passwordLengthError");
    exit();
	}
  
  // Check if user provided email is a correctly formatted email address
	if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../login-page.php?message=invalidEmailAddress");
    exit();
	}
	
  // Check whether the email is already in the database
	$sql="SELECT email FROM userAccounts WHERE email=?;";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../login-page.php?message=SQLstmtFailed");
    exit();
	}
	mysqli_stmt_bind_param($stmt, "s", $userEmail);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
  
  // Fail registering if email already exists in the database
	if ($row = mysqli_fetch_assoc($result)) {
		//----------------------Register fail----------------------//
		mysqli_stmt_close($stmt);
    header("Location: ../login-page.php?message=userAlreadyExists");
    exit();

	} else {
		// Generate a random token which can be used for email verification. You can email this to the user (after registering succeeds), then check whether it is valid on the login-page
		$token=bin2hex(random_bytes(32));
    
    // Prepare, initialise and run the SQL statement
		$sql="INSERT INTO userAccounts (firstname, lastname, email, password, token) VALUES (?, ?, ?, ?, ?);";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../login-page.php?message=SQLstmtFailed");
      exit();
		}
		mysqli_stmt_bind_param($stmt, "sssss", $userFirstname, $userLastname, $userEmail, $passwordHash, $token);
    // Execute SQL statement
		mysqli_stmt_execute($stmt);
    
    // Check whether a record has been inserted into the database
		if (mysqli_affected_rows($conn) != 1) {
      $conn->close();
      mysqli_stmt_close($stmt);
      header("Location: ../login-page.php?message=registerFailed");
      exit();
		} else {
      $conn->close();
      mysqli_stmt_close($stmt);
      header("Location: ../login-page.php?message=registerSuccess");
      exit();
		}

	}
		
}