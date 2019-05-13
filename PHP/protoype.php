<form action="action_page.php">

<head>
  <link rel="stylesheet" type="text/css" href="CSS.css">
</head>

	<h1>Face de book</h1>
	<br>
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
	<br>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
	
	<br><label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label><br>

    <button type="submit">Login</button>
	<button type="button" style = "background-color:grey">Cancel</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>