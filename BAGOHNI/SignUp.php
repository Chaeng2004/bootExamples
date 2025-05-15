<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up HopStop</title>
    <link rel="stylesheet" href="style2.css">
        
</head>
<body>
    <div class="container">
        
        <h2>Sign Up</h2>
        <form class="form" id="formId" method="POST" action="registration.php">
        <div class="profile-pic">
            <img src="../images/Jennie Kim.jpg" alt="Profile Picture">
            
        </div>
        <div class="input-box">
            <label>First Name</label>
            <input type="text" id="firstName" name= "firstName"  required>
        </div>
        <div class="input-box">
            <label>Last Name</label>
            <input type="text" id="lastName" name="lastName" required>
        </div>
        <div class="input-box">
            <label>Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-box">
            <label>Create Password</label>
            <input type="password" id="password" name="password" required>
        </div>
         <div class="btn">
            <input type="submit" name="submit" value="Sign In" class="button"> 
        </div>
            
        </form>
   
        <div class="signin">
            Already have an account? <a href="LogIn.php">Sign in</a>
        </div>
    </div>
 
   <script src="SignUp.js"></script>
</body>
</html>