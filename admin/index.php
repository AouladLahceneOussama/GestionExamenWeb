<?php 
include("header.php");
$userData=func::getUserData($dbh);
if(!isset($_SESSION['username'])){
    header("location:login.php");
}
if(isset($_GET['update'])){
    if($_GET['update']=='success'){
        header("location:index.php");
    }
}
if(isset($_GET['delete'])){
    if($_GET['delete']=='success'){
        header("location:index.php");
    }
}

?>
<section class="container">
    <div class="profile_container translate_profile_left">
        <div class="plus_icon">
            <i id="plus_icon" class="fa fa-plus-circle"></i>
        </div>
        <img src="img/user.png">
        <div class="profile_data">
            <h2><?php echo $userData[0];?><br><?php echo $userData[1];?></h2>
            <p class="welcome_admin">
                Welcome to the admin section 
                of ENSA<span>TE</span> Classrooms, you will be able to set multiple
                data of yours website add, edit or delete.</p>
            <a href="updateuser.php">Edit</a>
            <a href="logout.php">logout</a>
        </div>  
    </div>
</section>

<section class="list_container">
    <div class="list_content">
        <h3>Home Page</h3>
        <h3>1. First insert all the data of professors,classrooms 
            and courses in the specific page.</h3>
        <h3>2. Second make the affectation that you want from this lists.</h3>
        <h3>3. Make sure that you respect the order of professors's list and the minimum
            is 3 professors for each class. 
        </h3>
        <h3>4. Third the platform give you the possibility to edit and delete.</h3>
        <h3>5. Be carefull if you make any affectations you want be able to delete
            the data in the other tables until you delete it from the affectations table.</h3>
        <h3>6. Logout or modify your authentification data click on the black plus up.</h3>
    </div>
    <?php
        if($_GET['edit']!='start'){
           
        echo'
        <form method="post">
            <h1>Add Exams</h1>
            <div class="items_container">

                <div class="items" >
                    <span>Date</span>
                    <input type="date" name="date" id="date" required>
                </div>
    
                <div class="items" >
                    <span>Hour start</span>
                    <input type="text" placeholder="hh:mm:00" name="start" id="start" pattern="[0-9]{2}:[0-9]{2}:0{2}" required><br>
                    <span>Hour end</span>
                    <input type="text" placeholder="hh:mm:00" name="end" id="end" pattern="[0-9]{2}:[0-9]{2}:0{2}" required>
                </div>
    
                <input type="submit" id="search" name="search" value="Available data">
    
                <div id="touch" class="dont_touch">
                    <p id="valide_data" class="text_translate_100"></p>
                    <div class="items">
                        <span>Classroom</span>
                        <select name="classroom" id="classroom" required>';                            
                            if(isset($_POST['search'])){
                                $fullDateDay=$_POST['date'];
                                $start=$_POST['start'];
                            }
                            func::showClassroomList($dbh,$fullDateDay,$start);           
                    echo'</select>
                </div>
                
                <div class="items" >
                    <span>Course</span>
                        <select name="module" id="module" required>';
                           func::showCoursesList($dbh,$fullDateDay,$start,"none");    
                    echo'</select>
                </div>';
                    for($i=1;$i<=5;$i++){
                        echo 
                        '<div class="items">   
                            <span>Professors '.$i.'</span>
                            <select name="prof'.$i.'" id="prof'.$i.'"required>
                                <option>none</option>';
                                func::showProfessorsList($dbh,$fullDateDay,$start);
                            echo'</select>
                        </div>';
                    }
            echo'<input type="button" value="Add" id="add" name="add">
                </div>
            </div>
        </form>';
        }
        else{ 
            if($_GET['editGlobal']=='start')        
                func::getEditData($dbh,$_POST['id']);
            else
                func::getEditDate($dbh,$_POST['course']);
        }
    ?>
    
</section>


<?php
    if(isset($_POST['add'])){
        $classroomNb=$_POST['classroom'];
        $courseName=$_POST['module'];
        $fullDateDay=$_POST['date'];
        $start=$_POST['start'];
        $end=$_POST['end'];
        $prof1=$_POST['prof1'];
        $prof2=$_POST['prof2'];
        $prof3=$_POST['prof3'];
        $prof4=$_POST['prof4'];
        $prof5=$_POST['prof5'];
        
        func::addAffect($dbh,$classroomNb,$courseName,$fullDateDay,$start,
        $end,$prof1,$prof2,$prof3,$prof4,$prof5);
    }
?>

<section class="page_container">
    <h3>This table contains all the exams and the possibility to edit and delete</h3>
    <table id="my_table_index">
        <tr>
            <th>Id</th>
            <th>Class</th>
            <th>Professors</th>
            <th><i class="fa fa-edit"></i>Edit</th>
            <th><i class="fa fa-trash"></i>Delete</th>
            
        </tr>
        <?php
            func::showAffect($dbh);
           
        ?>
    </table>
    <?php
         if(func::checkDeleteAll($dbh)){
            echo '  <form action="index.php?delete=success" method="post">
                        <input type="submit" value="Delete All" name="delete_all" class="delete_all">
                    </form>';
        }
    ?>
</section>
<?php
    
    if(isset($_POST['update'])){
        $classroomNb=$_POST['classroom'];
        $fullDateDay=$_POST['date'];
        $start=$_POST['start'];
        $end=$_POST['end'];
        $prof1=$_POST['prof1'];
        $prof2=$_POST['prof2'];
        $prof3=$_POST['prof3'];
        $prof4=$_POST['prof4'];
        $prof5=$_POST['prof5'];
        $id=$_POST['id'];

        func::updateAffect($dbh,$id,$classroomNb,$prof1,$prof2,$prof3,$prof4,$prof5);
    }
    if(isset($_POST['update_exam'])){
        $fullDateDay=$_POST['date'];
        $start=$_POST['start'];
        $end=$_POST['end'];
        $courseName=$_POST['module'];
        $oldCourseId=$_POST['course'];

        func::updateAffectDate($dbh,$fullDateDay,$start,$end,$courseName,$oldCourseId);
    }
?>
<?php
    if(isset($_POST['delete'])){
        func::deleteAffect($dbh,$_POST["id"]);
    }
    if(isset($_POST['delete_exam'])){
        func::deleteExam($dbh,$_POST["course"]);
    }       
    if(isset($_POST['delete_all'])){
        func::deleteAll($dbh);
    } 
?>

<script src="adminScripts/indexPage.js"></script>
<?php include("footer.php");?>