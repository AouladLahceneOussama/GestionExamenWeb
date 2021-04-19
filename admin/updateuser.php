<?php include("header.php");?>

<div class="log_container">
        <div class="form_section">
            <div class="form_content">
                <?php 
                    $userData=func::getUserData($dbh);

                    if(func::checkUser($dbh)){
                        echo'<h1>Update</h1>
                            <form method="post">
                                <div class="form_input">
                                    <input type="text" name="firstname" value="'.$userData[0].'" required>
                                    <label>
                                        <span>First name</span>
                                    </label>
                                </div>
            
                                <div class="form_input">
                                    <input type="text" name="lastname" value="'.$userData[1].'" required>
                                    <label>
                                        <span>Last name</span>
                                    </label>
                                </div>
            
                                <div class="form_input">
                                    <input type="text" name="username" value="'.$userData[2].'" required>
                                    <label>
                                        <span>Username</span>
                                    </label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="password" name="password" required>
                                    <label>
                                        <span>Password</span>
                                    </label>
                                    <div class="show_pass">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                </div>
                                <input type="submit" name="update" value="Update"><br>';
                    }
                    else{
                        echo'<h1>Register</h1>
                            <form method="post">
                                <div class="form_input">
                                    <input type="text" name="firstname" required>
                                    <label>
                                        <span>First name</span>
                                    </label>
                                </div>
            
                                <div class="form_input">
                                    <input type="text" name="lastname" required>
                                    <label>
                                        <span>Last name</span>
                                    </label>
                                </div>
            
                                <div class="form_input">
                                    <input type="text" name="username" required>
                                    <label>
                                        <span>Username</span>
                                    </label>
                                </div>
                                
                                <div class="form_input">
                                    <input type="password" name="password" required>
                                    <label>
                                        <span>Password</span>
                                    </label>
                                    <div class="show_pass">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                </div>
                                <input type="submit" name="signup" value="Sign up"><br>';
                    }
                ?>
                
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['signup'])){
            $fName=$_POST['firstname'];
            $lName=$_POST['lastname'];
            $username=$_POST['username'];
            $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
            func::addUser($dbh,$fName,$lName,$username,$password);
        }
        if(isset($_POST['update'])){
            $fName=$_POST['firstname'];
            $lName=$_POST['lastname'];
            $username=$_POST['username'];
            $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
            func::updateUser($dbh,$fName,$lName,$username,$password);
        }
    ?>
    <script src="adminScripts/adminLogin.js"></script>
    <?php include("footer.php");?>