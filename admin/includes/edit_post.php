<?php

                           if(isset($_GET['p_id'])){
                              $post_id = $_GET['p_id'];
                            }

                            $query = "select * from posts where post_id = {$post_id} ";
                            $select_posts_by_id = mysqli_query($connection,$query);
                            while($row = mysqli_fetch_assoc($select_posts_by_id)){
                                $post_author = $row['post_author'];
                                $post_title = $row['post_title'];
                                $post_category_id = $row['post_category_id'];
                                $post_status = $row['post_status'];
                                $post_image = $row['post_image'];
                                $post_tags = $row['post_tags'];
                                $post_content = $row['post_content'];
                                $post_comment_count = $row['post_comment_count'];
                                $post_date = $row['post_date'];
                            }


                            if(isset($_POST['update_post'])){
                              $post_title = $_POST['title'];
                              $post_author = $_POST['author'];
                              $post_category_id = $_POST['post_category'];
                              $post_status = $_POST['post_status'];
                       
                              $post_image = $_FILES['image']['name'];
                              $post_image_temp = $_FILES['image']['tmp_name'];
                       
                              $post_tags = $_POST['post_tags'];
                              $post_content = $_POST['post_content'];
                             
                              move_uploaded_file($post_image_temp , "../images/$post_image");
                              
                              if(empty($post_image)){
                                  $query="select * from posts where post_id = $post_id";
                                  $select_image = mysqli_query($connection,$query);
                                  while ($row=mysqli_fetch_assoc($select_image)){
                                      $post_image = $row['post_image'];
                                  }
                              }
                              
                              $query = "update posts set post_title = '{$post_title}',post_category_id='{$post_category_id}',post_date=now(),post_author='{$post_author}',post_status='{$post_status}',post_tags='{$post_tags}',post_content='{$post_content}',post_image='{$post_image}' where post_id={$post_id} ";
                              
                              $update_post = mysqli_query($connection,$query);
                              confirmQuery($update_post);

                              echo "<p class='bg-success'>Post Updated . <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
                            }
  
?>






<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
       <label for="title">Post Title</label>
          <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <select name="post_category" id="">
    <?php
    $query = "select * from categories";
    $select_categories =  mysqli_query($connection,$query);
    confirmQuery($select_categories);
    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['cat_id']; 
        $cat_title = $row['cat_title'];   
        if($cat_id == $post_category_id){
            echo "<option selected value='{$cat_id}'> {$cat_title}</option>";

        }
        else{
            echo "<option value='{$cat_id}'> {$cat_title}</option>";
            
        }   
        
    }
    ?> 
        </select>                       
    </div>

    <div class="form-group">
        <label for="title">Post Author</label>
          <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <?php 
            if($post_status=='Published'){
                echo "<option vaue='Published'>Published</option>";
                echo "<option vaue='Draft'>Draft</option>";     
            }
            else{
                
                echo "<option vaue='Draft'>Draft</option>";
                echo "<option vaue='Published'>Published</option>";
            }
            
            ?>

    
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label><br>  
        <img width="100" src="../images/<?php echo $post_image ?>" >
        <input type="file" class="form-control" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
          <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
          <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?> 
          </textarea>
    </div>

    <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_post" value="Update post">  
    </div>

 </form>   