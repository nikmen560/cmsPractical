
<form action="" method="post">
    <div class="form-group">
        
        
        <?php

            $cat_id = $_GET['edit'];
            $stmt = mysqli_prepare($conn,"SELECT cat_title FROM categories WHERE cat_id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $cat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $cat_title);

            while (mysqli_stmt_fetch($stmt)): 

                
                ?>


                <input value="<?php if (isset($cat_title)) echo $cat_title ?>" type="text" name="cat_title" class="form-control" placeholder="catergory title">

                <?php endwhile;  ?>
                <?php mysqli_stmt_close($stmt); ?>
                
                <?php
                if(isset($_POST['update_category_btn'])) {
                    $new_cat_title = $_POST['cat_title'];
                    
                    $update_stmt = mysqli_prepare($conn, "UPDATE categories SET cat_title=? WHERE cat_id = ?");

                    mysqli_stmt_bind_param($update_stmt, 'si', $new_cat_title, $cat_id );
                    mysqli_stmt_execute($update_stmt);

                    redirect('cms/admin/categories.php');
                    mysqli_stmt_close($update_stmt);
                }

                ?>

    </div>
    <div class="form-group">
        <input type="submit" name="update_category_btn" value="Update Category" class="btn btn-secondary">
    </div>
</form>