<?php 

function confirmQuery($result){
    global $connection;
    if(!$result){
        die("query failed " . mysqli_error($connection));
    }
}

function insert_categories(){

    global $connection;
    if(isset($_POST['submit'])){
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)){
             echo "This field cannot be empty";
         }
         else{
             $query = "insert into categories(cat_title) value('{$cat_title}')";
             $create_category_query = mysqli_query($connection,$query);
    
         }
    }


}

function find_all_categories(){
    global $connection;
    $query = "select * from categories";
         $select_all_categories_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_all_categories_query)){
            $cat_id = $row['cat_id']; 
            $cat_title = $row['cat_title'];          
            echo "<tr> 
                  <td>{$cat_id}</td>
                  <td>{$cat_title}</td>    
                  <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>                                
                  <td><a href='categories.php?edit={$cat_id}'>Edit</a></td> 
                  </tr>";
        }

}

function delete_categories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "delete from categories where cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection,$query);
        header("Location: categories.php");
    }
}

function users_online(){
    if(isset($_GET['onlineusers'])){
        global $connection;
        if(!$connection){
            session_start();
            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;
            $query = "select * from users_online where session = '$session'";
            $send_query = mysqli_query($connection,$query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL){
                mysqli_query($connection,"insert into users_online(session,time) values('$session','$time')");
            }else{
                mysqli_query($connection,"update  users_online set time='$time' where session='$session'");
            }
            $users_online_query = mysqli_query($connection,"select * from users_online where time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query );

        }
    
    }

}

users_online();

function recordCount($table){
    global $connection;
    $query = "select * from $table";
    $select_all_post = mysqli_query($connection,$query);
    $result = mysqli_num_rows($select_all_post);
    return $result;
}


function checkStatus($table,$column,$status){
    global $connection;
    $query = "select * from $table where $column = '$status' ";
    $select_all_published_posts = mysqli_query($connection,$query);
    $result = mysqli_num_rows($select_all_published_posts);
    return $result;
}

function checkUserRole($table,$column,$role){
    global $connection;
    $query = "select * from $table where $column = '$role' ";
    $select_all_subscribers = mysqli_query($connection,$query);
    $result = mysqli_num_rows($select_all_subscribers);
    return $result;
}


function is_admin($username){
    global $connection;
    $query = "select user_role from users where username = '$username'";
    $result = mysqli_query($connection,$query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if($row['user_role'] == 'Admin'){
        return true;
    }
    else{
        return false;
    }
}

function username_exists($username){
    global $connection;
    $query = "select username from users where username = '$username'";
    $result = mysqli_query($connection,$query);
    confirmQuery($result);
    if(mysqli_num_rows($result)>0){
        return true;
    }
    else{
        return false;
    }
}


function email_exists($email){
    global $connection;
    $query = "select user_email from users where user_email = '$email'";
    $result = mysqli_query($connection,$query);
    confirmQuery($result);
    if(mysqli_num_rows($result)>0){
        return true;
    }
    else{
        return false;
    }
}

function register_user($username,$email,$password){
    global $connection;
    
    $username = mysqli_real_escape_string($connection,$username);
    $email = mysqli_real_escape_string($connection,$email);
    $password = mysqli_real_escape_string($connection,$password);
    $password = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12));

    $query = "insert into users (username,user_email,user_password,user_role) values('{$username}','{$email}','{$password}','Subscriber')";
    $register_user_query = mysqli_query($connection,$query);  
    
}

function login_user($username,$password){
    global $connection;
    $username = trim($username);  
    $password = trim($password);
    $username = mysqli_real_escape_string($connection,$username);
    $password = mysqli_real_escape_string($connection,$password);

    $query = "select * from users where username = '{$username}' ";
    $select_user_query = mysqli_query($connection,$query);

    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];

    }

    
    if(password_verify($password,$db_user_password)){
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_firstname;
        $_SESSION['lastname'] = $db_lastname;
        $_SESSION['user_role'] = $db_user_role;
        header("Location: ../admin/index.php");
    }
    else{
        header("Location: ../index.php");

    }

}


?>