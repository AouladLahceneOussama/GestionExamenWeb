<?php 
include("header.php");
if(!isset($_SESSION['username'])){
    header("location:login.php");
}
if($_GET['edit']=='success' || $_GET['delete']=='success'){
    header("location:professors.php");
}
?>

<h3>Welcome to the <span>professors</span> section, first add all the profs in the database</h3>

<section class="add">
    <img src="img/teacher.svg" width="400px">
    <form method="post">
        <h1>Add Professors</h1>
        <input name="prof_cni" placeholder="CNI" type="text" pattern="[A-Z]{1,2}[1-9][0-9]{5}" required><br>
        <input name="prof_first_name" placeholder="First name" pattern="[a-z A-Z]{1,20}" type="text" required><br>
        <input name="prof_last_name" placeholder="Last name" pattern="[a-z A-Z]{1,20}" type="text" required><br>
        <input type="submit" value="Add" name="add">
    </form>
</section>
<?php
    if(isset($_POST['add'])){
        $cni=$_POST['prof_cni'];
        $firstName=$_POST['prof_first_name'];
        $lastName=$_POST['prof_last_name'];
        func::addProfData($dbh,$cni,$firstName,$lastName);
    }
?>
<section class="page_container">
    <h3>This table contains all the professors data and the possibility to edit and delete</h3>
    <table id="my_table">
        <tr>
            <th>Id</th>
            <th>CNI</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th><i class="fa fa-edit"></i>Edit</th>
            <th><i class="fa fa-trash"></i>Delete</th>
        </tr>
        <?php
            func::showProfData($dbh);
        ?>
    </table>
</section>
<?php
    if(isset($_POST['delete'])){
        $id=$_POST['id'];
        func::deleteProfData($dbh,$id);
    }
?>
<?php
    if(isset($_POST['edit'])){
        $id=$_POST['id'];
        $cni=$_POST['prof_cni'];
        $firstName=$_POST['prof_first_name'];
        $lastName=$_POST['prof_last_name'];
        func::editProfData($dbh,$id,$cni,$firstName,$lastName);
    }
?>

<script src="adminScripts/adminPage.js"></script>
<?php include("footer.php");?>
