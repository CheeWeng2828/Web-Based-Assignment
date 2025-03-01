<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link type="icon" href="/image/login icon.jpg">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="login">
    <form action="login.php" method="post" autocomplete="off">
            <label for="uname"><strong>Username:</strong></label><br>
            <input type="text" name="uname" id="uname" placeholder="Username"><br><br>
            <label for="psword"><strong>Password:</strong></label><br>
            <input type="password" name="psword" id="psword" placeholder="Password!"><br><br>
            <input type="submit" value="Login">
            <button type="reset">Reset</button>
            
    </form>
    </div>
</body>
</html>