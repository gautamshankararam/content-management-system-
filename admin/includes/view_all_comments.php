
                    <table class="table table-bordered table-hover">
                       <thead> 
                       <tr>
                           <th>Id</th>
                           <th>Author</th>
                           <th>Comment</th>
                           <th>Email</th>
                           <th>Status</th>
                           <th>In Response to</th>
                           <th>Date</th>
                           <th>Approve</th>
                           <th>Unapprove</th> 
                           <th>Delete</th>
                        </tr>   
                       <thead>
                       <tbody>

                        <?php

                            $query = "select * from comments";
                            $select_comments = mysqli_query($connection,$query);
                            while($row = mysqli_fetch_assoc($select_comments)){
                                $comment_id = $row['comment_id'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_author = $row['comment_author'];
                                $comment_content = $row['comment_content'];
                                $comment_email = $row['comment_email'];
                                $comment_status = $row['comment_status'];
                                $comment_date = $row['comment_date'];
                            
                                echo "<tr>
                                      <td>$comment_id</td>
                                      <td>$comment_author</td>
                                      <td>$comment_content</td>
                                      <td>$comment_email</td>
                                      <td>$comment_status</td>";


                                      $query = "select * from posts where post_id = $comment_post_id";
                                      $select_post_id_query = mysqli_query($connection,$query);
                                      while($row = mysqli_fetch_assoc($select_post_id_query)){
                                          $post_id = $row['post_id'];
                                          $post_title = $row['post_title'];
                                          echo "<td><a href='../post.php?p_id=$post_id'>$post_title </a></td>";


                                      }

                                      
                                echo  "<td>$comment_date</td>
                                      <td><a href='comments.php?approve=$comment_id'>Approve</a></td>
                                      <td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>
                                      <td><a href='comments.php?delete=$comment_id'>Delete</a></td>                     
                                      </tr>";
                            }
                        
                        ?>
                        
                       </tbody>
                    </table>

 <?php 
    
    if(isset($_GET['approve'])){
        $comment_id = $_GET['approve'];
        $query = "update comments set comment_status = 'approved' where comment_id = $comment_id ";
        $approve_comment_query = mysqli_query($connection,$query);
        header("Location: comments.php");
        
    }

    if(isset($_GET['unapprove'])){
        $comment_id = $_GET['unapprove'];
        $query = "update comments set comment_status = 'unapproved' where comment_id = $comment_id ";
        $unapprove_comment_query = mysqli_query($connection,$query);
        header("Location: comments.php");
        
    }

    if(isset($_GET['delete'])){
        $comment_id = $_GET['delete'];
        $query = "delete from comments where comment_id = {$comment_id}";
        $delete_query = mysqli_query($connection,$query);
        header("Location: comments.php");
        
    }
 
 ?>           