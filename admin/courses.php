<?php 
include("header.php");
if(!isset($_SESSION['username'])){
    header("location:login.php");
}
if($_GET['edit']=='success' || $_GET['delete']=='success'){
    header("location:courses.php");
}
?>

<h3>Welcome to the Courses section, first add all the profs in the database</h3>

<section class="add">
    <form method="post">
        <h1>Add Courses</h1>
        <input name="course_name" placeholder="Course name" pattern="*" type="text" required><br>
        <input name="course_hours" placeholder="Course hours" type="text" pattern="[0-9]{1,2}" oninvalid="setCustomValidity('Enter numbers')" required>
        <div class="radio_item">
            <div class="radio">
                <input name="course_type" value="cour" type="radio" checked>
                <span>Cour</span>
            </div>
            <div class="radio">
                <input name="course_type" value="td" type="radio" >
                <span>TD</span>
            </div>
            <div class="radio">
                <input name="course_type" value="tp" type="radio" >
                <span>TP</span>
            </div>
        </div>
        <input type="submit" value="Add" name="add">
    </form>
    <img src="img/modules.svg" width="400px"> 
</section>
<?php
    if(isset($_POST['add'])){
        $name=$_POST['course_name'];
        $hours=$_POST['course_hours'];
        $type=$_POST['course_type'];
        func::addCoursesData($dbh,$name,$hours,$type);
    }
?>
<section class="page_container">
    <h3>This table contains all the courses data and the possibility to edit and delete</h3>
    <table id="my_table">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Hours</th>
            <th>Type</th>
            <th><i class="fa fa-edit"></i>Edit</th>
            <th><i class="fa fa-trash"></i>Delete</th>
        </tr>
        <?php
            func::showCoursesData($dbh);
        ?>
</table>
</section>
<?php
    if(isset($_POST['delete'])){
        $id=$_POST['id'];
        func::deleteCoursesData($dbh,$id);
    }
?>
<?php
    if(isset($_POST['edit'])){
        $id=$_POST['id'];
        $name=$_POST['course_name'];
        $hours=$_POST['course_hours'];
        $type=$_POST['course_type'];
        func::editCoursesData($dbh,$id,$name,$hours,$type);
    }
?>

<script src="adminScripts/adminPage.js"></script>
<?php include("footer.php");?>
