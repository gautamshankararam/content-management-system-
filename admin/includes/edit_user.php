<?php 
   if(isset($_GET['edit_user'])){
      $user_id = $_GET['edit_user'];
      $query = "select * from users where user_id = $user_id";
      $select_users_query = mysqli_query($connection,$query);
      while($row = mysqli_fetch_assoc($select_users_query)){
          $user_id = $row['user_id'];
          $username = $row['username'];
          $user_password = $row['user_password'];
          $user_firstname = $row['user_firstname'];
          $user_lastname = $row['user_lastname'];
          $user_email = $row['user_email'];
      }          

   

   if(isset($_POST['edit_user'])){

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password']; 

   
   if(!empty($user_password)){
       $query_password= "select user_password from users where user_id = $user_id";
       $get_user = mysqli_query($connection,$query_password);
       confirmQuery($get_user);
       $row = mysqli_fetch_array($get_user);
       $db_user_password = $row['user_password'];

       if($db_user_password != $user_password){
        $hashed_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 12));
       }
       $query = "update users set user_firstname = '{$user_firstname}',user_lastname = '{$user_lastname}',username='{$username}',user_email='{$user_email}',user_password='{$hashed_password}' where user_id='$user_id' ";
       $edit_user_query = mysqli_query($connection,$query);
       confirmQuery($edit_user_query);
       echo "User Updated " . "<a href='users.php'>View Users</a>";
   

   }
   else{
    echo "<h6 class='text-centre'>Enter password to update</h6>";

   }

       
  }
 }
else{
       header("Location: index.php");
   }
?>





<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="firstname">Firstname</label>
          <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname" >
    </div>

    <div class="form-group">
        <label for="lastname">Lastname</label>
          <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>    

   
    <div class="form-group">
        <label for="username">Username</label>
          <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
  
    </div>

    <div class="form-group">
        <label for="password">Password</label>
          <input autocomplete="off" type="password"  class="form-control" name="user_password">
    </div>

    <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="Update">  
    </div>

 </form>   