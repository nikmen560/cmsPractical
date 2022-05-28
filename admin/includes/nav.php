
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php"> <?php if (is_admin()) echo "CMS admin";
                                                else echo "User Dashboard" ?>  </a>
<small style="color: white;">Users Online: <span class="usersonline"></span></small>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if(!is_admin()):  ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php">My data</a>
            </li>
            <?php endif; ?>
        <li class="nav-item">
        </li>
        <?php if(is_admin()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"></i> Dashboard</a>
                </li>
                <?php endif; ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-user"> </i>
                   <?php echo $_SESSION['username']; ?> 
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item" href="posts.php?u_id=<?php echo get_current_user_id()?>">My posts</a> 
                    <a class="dropdown-item" href="comments.php?u_id=<?php echo get_current_user_id() ?>">My comments</a> 

                    <!-- TODO: CREATE MY POSTS PAGE -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="includes/logout.php">Log out</a>
                </div>
            </li>
        <?php if(is_admin()): ?>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Categories</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Posts 
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="posts.php?source=add_post">Add post</a>
                    <a class="dropdown-item" href="posts.php">All posts</a> 
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Users
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="users.php?source=add_user">Add user</a>
                    <a class="dropdown-item" href="users.php">All users</a> 
                </div>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="/cms">Home page</a>
            </li>
        </ul>
    </div>
</nav>

<!-- body content -->
    <div class="container"> 