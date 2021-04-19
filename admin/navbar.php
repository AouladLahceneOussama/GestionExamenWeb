<header id="header" class="min_height">
    <nav>
        <a href="../index.php" target="_blank"><h3>ENSA<span>TE</span> Classrooms</h3></a>
        <ul>
            <?php
                session_start();
                if(isset($_SESSION["username"])){
                    echo '  <li><a href="index.php">Home</a></li>
                            <li><a href="classrooms.php">Classrooms</a></li>
                            <li><a href="professors.php">Professors</a></li>
                            <li><a href="courses.php">Courses</a></li>
                            <li><a href="../index.php" target="_blank">Userside</a></li>';
                }
            ?>
        </ul>
    </nav>
    <?php
        if(isset($_SESSION["username"])){
            echo '  <i id="menu_btn" class="fa fa-bars"></i>';
        }
    ?>
    
</header>