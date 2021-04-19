<?php include("header.php");?>
<header>
    <h3>ENSA<span>TE</span> Classrooms</h3>
</header>

<section class="container">
   
    <div class="modules">
        <?php
            func::moduleItems($dbh);
        ?>
    </div>

    <div class="exams">
        <?php
            func::examItems($dbh);
        ?> 
    </div>

</section>

<?php include("footer.php");?>