<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $product = $_POST['product_name'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message1 = mysqli_query($conn, "SELECT admin_id FROM `products` WHERE name = '$product'") or die('query failed');

   if(mysqli_num_rows($select_message1) > 0){
      $row = mysqli_fetch_assoc($select_message1);
      $admin_id = $row['admin_id'];
      $select_message2 = mysqli_query($conn, "SELECT * FROM `message` WHERE message = '$msg' AND admin_id = '$admin_id' AND user_id = '$user_id'") or die('query failed');

      if(mysqli_num_rows($select_message2) > 0){
         $message[] = 'message sent already!';
      }else{
         mysqli_query($conn, "INSERT INTO `message`(admin_id, user_id, name, email, number, message) VALUES('$admin_id', '$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
         $message[] = 'message sent successfully!';
      }
   }else{
      $message[] = 'product name not found!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>contact us</h3>
   <p> <a href="home.php">home</a> / contact </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <input type="text" name="product_name" required placeholder="enter product name" class="box">
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>