
                    <table class="table table-bordered table-hover">
                       <thead> 
                       <tr>
                           <th>Id</th>
                           <th>Username</th>
                           <th>Firstname</th>
                           <th>Lastname</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Admin</th>
                           <th>Subscriber</th>
                           <th>Edit</th>
                           <th>Delete</th>
                        </tr>   
                       <thead>
                       <tbody>

                        <?php

                            $query = "select * from users";
                            $select_users = mysqli_query($connection,$query);
                            while($row = mysqli_fetch_assoc($select_users)){
                                $user_id = $row['user_id'];
                                $username = $row['username'];
                                $user_password = $row['user_password'];
                                $user_firstname = $row['user_firstname'];
                                $user_lastname = $row['user_lastname'];
                                $user_email = $row['user_email'];
                                $user_role = $row['user_role'];
                            
                                echo "<tr>
                                      <td>$user_id</td>
                                      <td>$username</td>
                                      <td>$user_firstname</td>
                                      <td>$user_lastname</td>
                                      <td>$user_email</td>
                                      <td>$user_role</td>
                                      
                                      <td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>
                                      <td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>
                                      <td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>                     
                                      <td><a href='users.php?delete={$user_id}'>Delete</a></td>                     
                                      </tr>";
                            }
                        
                        ?>
                        
                       </tbody>
                    </table>

 <?php 
    
    if(isset($_GET['change_to_admin'])){
        $user_id = $_GET['change_to_admin'];
        $query = "update users set user_role = 'Admin' where user_id = $user_id ";
        $change_admin_query = mysqli_query($connection,$query);
        header("Location: users.php");
        
    }

    if(isset($_GET['change_to_sub'])){
        $user_id = $_GET['change_to_sub'];
        $query = "update users set user_role  = 'Subscriber' where user_id = $user_id ";
        $change_sub_query = mysqli_query($connection,$query);
        header("Location: users.php");
        
    }

    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role']== 'Admin'){
                $user_id = mysqli_real_escape_string($connection,$_GET['delete']);
                $query = "delete from users where user_id = {$user_id}";
                $delete_query = mysqli_query($connection,$query);
                header("Location: users.php");
            }
        }
    }
 
 ?>           