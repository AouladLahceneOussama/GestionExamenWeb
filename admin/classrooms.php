<?php 
include("header.php");
if(!isset($_SESSION['username'])){
    header("location:login.php");
}
if($_GET['edit']=='success' || $_GET['delete']=='success'){
    header("location:classrooms.php");
}
?>

<h3>Welcome to the Classrooms section, first add all the profs in the database</h3>

<section class="add">
    <form method="post">
        <h1>Add classrooms</h1>
        <input name="class_number" placeholder="Classroom number" type="text" pattern="[0-9]{1,3}" required><br>
        <input name="class_floor" placeholder="Classroom floor" type="text" pattern="[1-9]" required><br>
        <input name="class_seats" placeholder="Seats" type="text" pattern="[0-9]{1,3}" required><br>
        <input type="submit" value="Add" name="add">
    </form>
    <img src="img/classroom.svg" width="400px">
</section>
<?php
    if(isset($_POST['add'])){
        $nb=$_POST['class_number'];
        $floor=$_POST['class_floor'];
        $seats=$_POST['class_seats'];
        func::addClassroomData($dbh,$nb,$floor,$seats);
    }
?>
<section class="page_container">
    <h3>This table contains all the classrooms data and the possibility to edit and delete</h3>
    <table id="my_table">
        <tr>
            <th>Id</th>
            <th>Number</th>
            <th>Floor</th>
            <th>Seats</th>
            <th><i class="fa fa-edit"></i>Edit</th>
            <th><i class="fa fa-trash"></i>Delete</th>
        </tr>
        <?php
            func::showClassroomData($dbh);
        ?>
</table>
</section>

<?php
    if(isset($_POST['delete'])){
        $id=$_POST['id'];
        func::deleteClassroomfData($dbh,$id);
    }
?>
<?php
    if(isset($_POST['edit'])){
        $id=$_POST['id'];
        $nb=$_POST['class_number'];
        $floor=$_POST['class_floor'];
        $seats=$_POST['class_seats'];
        func::editClassroomData($dbh,$id,$nb,$floor,$seats);
    }
?>

<script src="adminScripts/adminPage.js"></script>
<?php include("footer.php");?>
