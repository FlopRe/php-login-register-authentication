<?php
  // Start session on every page which needs to access $_SESSION
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Register & Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <!-- Some basic styling -->
    <link rel="stylesheet" href="styling.css">
  </head>

  <body>
    
    <?php
      // Display status based on the $_GET variable inside the URL passed from register, login or logout
      if (isset($_GET["message"])) {
        echo "
        <section class='error'>
          <fieldset>
            <legend>Status</legend>
            <h3>{$_GET["message"]}</h3>
          </fieldset>
        </section>
        ";
      }

      // Display either: logout section if logged in, or register & login sections if user is not logged in
      if (isset($_SESSION["user"]["loggedIn"]) && $_SESSION["user"]["loggedIn"]===true) {
        echo "
        <section class='logout'>
          <h1>Signed in</h1>
          <p>Welcome back, {$_SESSION["user"]["firstname"]}</p>
          <a href='process/logout.php'>
            <button>Log out</button>
          </a>
        </section>
        ";

      } else {
        echo "
        <section class='register'>
          <h1>Register</h1>
          <form name='register' method='post' action='process/register.php'>
            <input name='userEmail' type='text' placeholder='Email' required>
            <input name='userFirstname' type='text' placeholder='First name'>
            <input name='userLastname' type='text' placeholder='Last name'>
            <input name='userPassword1' type='password' placeholder='Password' required>
            <input name='userPassword2' type='password' placeholder='Confirm password' required>
            <button name='register' type='submit'>Register</button>
          </form>
        </section>

        <section class='login'>
          <h1>Log in</h1>
          <form name='login' method='post' action='process/login.php'>
            <input name='userEmail' type='text' placeholder='Your email'>
            <input name='userPassword' type='password' placeholder='Your password'>
            <button name='login' type='submit'>Log in</button>
          </form>
        </section>
        ";
      }
    ?>

  </body>

</html>