<?php include("header.php");
if(!func::checkUser($dbh)){
    header("location:updateuser.php");
    exit;
}
?>
    <div class="log_container">
        <div class="admin_desc">
            <h1>ENSA<span>TE</span> Classroom</h1>
            <p>Connect to the admin section to specified the multipile functions in this platfrom,
                that allow you to create the distribution of professors and courses on the classrooms.
            </p>
        </div>
        <div class="form_section">
            <div class="form_content">
                <h1>Login</h1>
                
                <?php
                    if(isset($_GET['login'])){
                        if($_GET['login']=='failed'){
                            echo '  <div class="error_login">
                                        <p> Wrong Password or Username</p>
                                    </div>';
                        }
                    }
                ?>
                <form method="post">
                    
                    <div class="form_input">
                        <input type="text" name="username" required>
                        <label>
                            <span>username</span>
                        </label>
                    </div>
                    
                    <div class="form_input">
                        <input type="password" name="password" required>
                        <label>
                            <span>password</span>
                        </label>
                        <div class="show_pass">
                            <i class="fa fa-eye"></i>
                        </div>
                    </div>
                    <input type="submit" name="login" value="Login"><br>
                </form>
            </div>
        </div>
    </div>
    <script src="adminScripts/adminPage.js"></script>
    <?php
        session_start();
        
        if(isset($_POST['login'])){
            $username=$_POST['username'];
            $password=$_POST['password'];
            if(func::checkLogDataBase($dbh,$username,$password)==true){
                $_SESSION['username']=$username;
                header("location:index.php");
            }
            else{
                header("location:login.php?login=failed");
            }
        }
        
    ?>
<script src="adminScripts/adminLogin.js"></script>
<?php include("footer.php");?>