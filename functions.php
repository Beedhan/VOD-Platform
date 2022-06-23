<?php
include("config.php");
function checkUser($con, $username)
{
   $usernameCheck = "SELECT username from users WHERE username='$username' limit 1";

   $userResult = mysqli_query($con, $usernameCheck);
   if ($userResult->num_rows > 0) {
      return htmlspecialchars("Sorry, $username is already taken ");
   }
}
function checkEmail($con, $email)
{
   $emailCheck = "SELECT email from users WHERE email='$email' limit 1";

   $emailResult = mysqli_query($con, $emailCheck);
   if ($emailResult->num_rows > 0) {
      return "There is already a user with this email address";
   }
}
function video_id(){
   return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,8);
}