<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Register & Login</title>
    
    <!-- Some basic styling -->
    <link rel="stylesheet" href="styling.css">
  </head>

  <body>

    <section class="register">
      <h1>Register</h1>
      <form name="register" method="post" action="process/register.php">
        <input name="userEmail" type="text" placeholder="Email" required>
        <input name="userFirstname" type="text" placeholder="First name">
        <input name="userLastname" type="text" placeholder="Last name">
        <input name="userPassword1" type="password" placeholder="Password" required>
        <input name="userPassword2" type="password" placeholder="Confirm password" required>
        <button name="register" type="submit">Register</button>
      </form>
    </section>

    <section class="login">
      <h1>Login</h1>
      <form name="login" method="post" action="process/login.php">
        <input name="userEmail" type="text" placeholder="Your email">
        <input name="userPassword" type="password" placeholder="Your password">
        <button name="login" type="submit">Login</button>
      </form>
    </section>

  </body>

</html>