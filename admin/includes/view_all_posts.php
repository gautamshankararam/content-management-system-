<?php 

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueID){
          $bulk_options = $_POST['bulk_options'];     

          switch($bulk_options){
              case 'Published':
              $query = "update posts set post_status = '{$bulk_options}' where post_id={$postValueID}";
              $update_to_published_status = mysqli_query($connection,$query);

              break;

              case 'Draft':
                $query = "update posts set post_status = '{$bulk_options}' where post_id={$postValueID}";
                $update_to_draft_status = mysqli_query($connection,$query);
                
                break;

                case 'Delete':
                    $query = "delete from posts where post_id={$postValueID}";
                    $update_to_delete_status = mysqli_query($connection,$query);
                    
                    break;
                    
                case 'Clone':
                    $query = "select * from posts where post_id='{$postValueID}'" ;
                    $select_post_query = mysqli_query($connection,$query);
                    
                    while($row=mysqli_fetch_array($select_post_query)){
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_date = $row['post_date'];
                        $post_author = $row['post_author'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                    }
                    $query = "insert into posts(post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_comment_count,post_status) ";
                    $query .= "values({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}',0,'{$post_status}')";
                    $copy_query = mysqli_query($connection,$query);         


          }
    }

}


?>





<form action="" method="post">
    <div id="bulkOptionsContainer" style="padding : 0px; "class="col-xs-4">

    <select class="form-control" name="bulk_options" id="">
       <option value="Draft">Select Options</option>
       <option value="Published">Publish</option>
       <option value="Draft">Draft</option>
       <option value="Delete">Delete</option>
       <option value="Clone">Clone</option>
    </select>

    </div>

    <div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
  
    </div>
                    <table class="table table-bordered table-hover">
                       <thead> 
                       <tr> 
                           <th><input id="selectAllBoxes" type="checkbox"></th>   
                           <th>Id</th>
                           <th>Author</th>
                           <th>Title</th>
                           <th>Category</th>
                           <th>Status</th>
                           <th>Image</th>
                           <th>Tags</th>
                           <th>Comments</th>
                           <th>Date</th>
                           <th>View Post</th>
                           <th>Edit</th>
                           <th>Delete</th>
                           <th>Views</th>
                        </tr>   
                       <thead>
                       <tbody>

                        <?php

                            $query = "select * from posts order by post_id desc";
                            $select_posts = mysqli_query($connection,$query);
                            while($row = mysqli_fetch_assoc($select_posts)){
                                $post_id = $row['post_id'];
                                $post_author = $row['post_author'];
                                $post_title = $row['post_title'];
                                $post_category_id = $row['post_category_id'];
                                $post_status = $row['post_status'];
                                $post_image = $row['post_image'];
                                $post_tags = $row['post_tags'];
                                $post_comment_count = $row['post_comment_count'];
                                $post_date = $row['post_date'];
                                $post_views_count = $row['post_views_count'];
                                echo "<tr>
                                      <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$post_id'></td>
                                      <td>$post_id</td>
                                      <td>$post_author</td>
                                      <td>$post_title</td>";
                                      
                                      $query = "select * from categories where cat_id = {$post_category_id}";
                                      $select_categories_id = mysqli_query($connection,$query);
                                      while($row = mysqli_fetch_assoc($select_categories_id)){
                                          $cat_id = $row['cat_id'];
                                          $cat_title = $row['cat_title'];
                                          echo "<td>$cat_title</td>";

                                      }
                                      echo "
                                      <td>$post_status</td>
                                      <td><img width='100' src='../images/$post_image'> </td>
                                      <td>$post_tags</td>";

                                      $query = "select * from comments where comment_post_id = $post_id";
                                      $send_comment_query = mysqli_query($connection,$query);
                                      $count_comments = mysqli_num_rows($send_comment_query);
                    

                                      echo "
                                      <td>$count_comments</td>
                                      <td>$post_date</td>
                                      <td><a href='../post.php?p_id={$post_id}'>View Post</a></td>
                                      <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
                                      <td><a onClick=\"javascript: return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>                     
                                      <td><a href='posts.php?reset={$post_id}'>$post_views_count</a></td>
                                      </tr>";
                            }
                        
                        ?>
                        
                       </tbody>
                    </table>
</form>
 <?php 
    
    if(isset($_GET['delete'])){
        $post_id = $_GET['delete'];
        $query = "delete from posts where post_id = {$post_id}";
        $delete_query = mysqli_query($connection,$query);
        header("Location: posts.php");
    }
 
 ?>           

<?php 
    
    if(isset($_GET['reset'])){
        $post_id = $_GET['reset'];
        $query = "update  posts set post_views_count=0 where post_id = {$post_id}";
        $reset_query = mysqli_query($connection,$query);
        header("Location: posts.php");
    }
 
 ?>           