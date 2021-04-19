<?php
class func{
    
    public static function checkLogDataBase($dbh,$username,$password){
        $query='SELECT * FROM users WHERE users_username=:username;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":username"=>$username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row['users_username']==$username && 
            password_verify($password,$row['users_password'])){
            return true;
        }
    }
    /******************************USER SECTION********************************************/
    public static function checkUser($dbh){
        $query='SELECT * FROM users;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        if($row['users_id']>0) return true;
    }

    public static function getUserData($dbh){
        $query='SELECT * FROM users;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $userData=array($row['users_firstname'],$row['users_lastname']
        ,$row['users_username']);
        return $userData;
    }

    public static function updateUser($dbh,$userFirst,$userLast,$username,$password){
        $query='UPDATE users SET users_firstname=:userFirst,users_lastname=:userLast,
        users_username=:username,users_password=:password WHERE users_id=1;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":userFirst"=>$userFirst,":userLast"=>$userLast,
        ":username"=>$username,":password"=>$password,":username"=>$username));
        header("location:index.php");
    }

    public static function addUser($dbh,$userFirst,$userLast,$username,$password){
        $query='INSERT INTO users(users_id,users_firstname,users_lastname,users_username,
        users_password) VALUES(1,:userFirst,:userLast,:username,:password);';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":userFirst"=>$userFirst,":userLast"=>$userLast,
        ":username"=>$username,":password"=>$password));
        header("location:login.php");
    }
    /******************************USER SECTION**********************************************/

    /***************************************PROF SECTION****************************************/
    public static function checkProfCNI($dbh,$cni){
        $query='SELECT * FROM professors WHERE professors_cni=:cni;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":cni"=>$cni));
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($row as $rows){
            if($rows["professors_id"]>0) return true;
        }
    }
    
    public static function addProfData($dbh,$cni,$firstName,$lastName){
        if(!func::checkProfCNI($dbh,$cni)){
            $query='INSERT INTO professors (professors_cni,professors_firstname,
            professors_lastname) VALUES(:cni,:firstName,:lastName);';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":cni"=>$cni,":firstName"=>$firstName,":lastName"=>$lastName));
        }
        else{
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$cni.'</span> this prof CNI exist you should enter other CNI. 
                        </p>
                    </div>
                </div>';
        }
    }

    public static function editProfData($dbh,$id,$cni,$firstName,$lastName){

        $query='SELECT * FROM professors WHERE professors_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["professors_id"]>0) $cniId=$row["professors_cni"];

        if((func::checkProfCNI($dbh,$cni) && $cni==$cniId) || !func::checkProfCNI($dbh,$cni)){
            $query='UPDATE professors SET professors_cni=:cni,professors_firstname=:firstName,
            professors_lastname=:lastName WHERE professors_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":cni"=>$cni,":firstName"=>$firstName,":lastName"=>$lastName,":id"=>$id));

            $query='SELECT * FROM affectations;';
            $stmt=$dbh->prepare($query);
            $stmt->execute();
            $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($row as $rows){
                for($i=1;$i<=5;$i++){
                    if($rows["affectations_prof".$i]!='none'){
                        $prof=explode(".",$rows["affectations_prof".$i]);
                        $idProf=$prof[0];
                        if($id==$idProf){
                            func::setProfDataAffectation($dbh,$i,$id,$firstName,$lastName,$rows["affectations_prof".$i]);
                        }
                    }
                }
            }
            echo '<script type="text/javascript"> window.location="professors.php?edit=success" </script>';
        }
        if(func::checkProfCNI($dbh,$cni)){
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$cni.'</span> this prof CNI exist you cant continue editing. 
                        </p>
                    </div>
                </div>';
        }
    }
    
    public static function setProfDataAffectation($dbh,$i,$id,$firstName,$lastName,$oldName){
        $query='UPDATE affectations SET affectations_prof'.$i.'=:name WHERE affectations_prof'.$i.'=:oldName;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":name"=>$id.'.'.$firstName.'.'.$lastName,":oldName"=>$oldName));
    }
    
    public static function ProfStateDelete($dbh,$profName){
        for($i=1;$i<=5;$i++){

            $query='SELECT * FROM affectations WHERE affectations_prof'.$i.'=:profName;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":profName"=>$profName));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            foreach($row as $rows){
                if($rows["affectations_id"]>0) return true;
            }
        }
    }

    public static function deleteProfData($dbh,$id){
        $query='SELECT * FROM professors WHERE professors_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $profName=$row["professors_id"].'.'.$row["professors_firstname"].'.'.$row["professors_lastname"];

        if(!func::ProfStateDelete($dbh,$profName)){
            $query='DELETE FROM  professors WHERE professors_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":id"=>$id));
           echo '<script type="text/javascript"> window.location="professors.php?delete=success" </script>';
        }
        else{
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$row["professors_firstname"].' '.$row["professors_lastname"].'</span> this prof is affected you should delete the affectations then you
                            can delete the professor data. 
                        </p>
                    </div>
                </div>';
        }
       
    }

    public static function showProfData($dbh){
        $query='SELECT * FROM professors;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num=1;

        foreach($row as $rows){    
            if($rows['professors_id']>0){
                echo ' <tr>
                        <td>'.$rows['professors_id'].'</td>
                        <td>'.$rows['professors_cni'].'</td>
                        <td>'.$rows['professors_firstname'].'</td>
                        <td>'.$rows['professors_lastname'].'</td>
                        <td><button num="'.$num.'" class="edit">Edit</button></td>
                        <td>
                            <form class="delete_form" method="post">
                                <input type="text" value="'.$rows['professors_id'].'" name="id" >
                                <input type="submit" name="delete" value="Delete" class="delete"></td>
                            </form>
                    </tr>
                    <tr>
                        <td colspan="6" class="input_edit">
                            <form method="post">
                                <input type="text" value="'.$rows['professors_id'].'" name="id" >
                                <input type="text" placeholder="cni" value="'.$rows['professors_cni'].'" name="prof_cni" pattern="[A-Z]{1,2}[1-9][0-9]{5}" required>
                                <input type="text" placeholder="First name" value="'.$rows['professors_firstname'].'" name="prof_first_name" pattern="[a-z A-Z]{1,20}"  required>
                                <input type="text" placeholder="Last name" value="'.$rows['professors_lastname'].'" name="prof_last_name" pattern="[a-z A-Z]{1,20}" required>
                                <input type="submit" name="edit" value="Edit">
                            </form>
                        </td>
                    </tr>';
                    $num+=2;
            }
        }
    }
    /***************************************PROF SECTION****************************************/

    /**********************************CLASSROOM SECTION****************************************/
    public static function checkClassroomData($dbh,$nb){
        $query='SELECT * FROM classrooms WHERE classrooms_number=:nb;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":nb"=>$nb));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["classrooms_id"]>0) return true;
    }
    
    public static function addClassroomData($dbh,$nb,$floors,$seats){
        if(!func::checkClassroomData($dbh,$nb)){
            $query='INSERT INTO classrooms (classrooms_number,classrooms_floor,
            classrooms_seats) VALUES(:nb,:floors,:seats);';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":nb"=>$nb,":floors"=>$floors,":seats"=>$seats));
        }else{
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$nb.'</span> this number classroom exist you should enter other number. 
                        </p>
                    </div>
                </div>';
        }


    }

    public static function editClassroomData($dbh,$id,$nb,$floors,$seats){

        $query='SELECT * FROM classrooms WHERE classrooms_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["classrooms_id"]>0) $nbId=$row["classrooms_number"];

        if((func::checkClassroomData($dbh,$nb) && $nb==$nbId) || !func::checkClassroomData($dbh,$nb)){

            $query='UPDATE classrooms SET classrooms_number=:nb,classrooms_floor=:floors,
            classrooms_seats=:seats WHERE classrooms_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":nb"=>$nb,":floors"=>$floors,":seats"=>$seats,":id"=>$id));
            echo '<script type="text/javascript"> window.location="classrooms.php?edit=success" </script>';

        }
        if(func::checkClassroomData($dbh,$nb)){
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$nb.'</span> this number classroom exist you cant continue editing. 
                        </p>
                    </div>
                </div>';
        }
    }

    public static function checkClassroomDelete($dbh,$classId){
        $query='SELECT * FROM affectations WHERE affectations_classid=:classId;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":classId"=>$classId));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["affectations_id"]>0) return true;
    }

    public static function deleteClassroomfData($dbh,$id){
        if(!func::checkClassroomDelete($dbh,$id)){
            $query='DELETE FROM classrooms WHERE classrooms_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":id"=>$id));
            echo '<script type="text/javascript"> window.location="classrooms.php?delete=success" </script>';
        }
        else{
            $query='SELECT * FROM classrooms WHERE classrooms_id=:classId;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":classId"=>$id));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            echo '
            <div class="modale">
                <div class="modale_data">
                    <i id="close" class="fa fa-plus-circle"></i>
                    <p>
                        <span>'.$row["classrooms_number"].'</span> this classroom is affected in exams table you should
                        delete it first from the exmas table. 
                    </p>
                </div>
            </div>';
        }

    }

    public static function showClassroomData($dbh){
        $query='SELECT * FROM classrooms;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num=1;

        foreach($row as $rows){    
            if($rows['classrooms_id']>0){
                echo ' <tr>
                        <td>'.$rows['classrooms_id'].'</td>
                        <td>'.$rows['classrooms_number'].'</td>
                        <td>'.$rows['classrooms_floor'].'</td>
                        <td>'.$rows['classrooms_seats'].'</td>
                        <td><button num="'.$num.'" class="edit">Edit</button></td>
                        <td>
                            <form class="delete_form"  method="post">
                                <input type="text" value="'.$rows['classrooms_id'].'" name="id" >
                                <input type="submit" name="delete" value="Delete" class="delete"></td>
                            </form>
                    </tr>
                    <tr>
                        <td colspan="6" class="input_edit">
                            <form method="post">
                                <input type="text" value="'.$rows['classrooms_id'].'" name="id" >
                                <input type="text" name="class_number" placeholder="Classroom number" value="'.$rows['classrooms_number'].'" pattern="[0-9]{1,3}" required>
                                <input type="text" name="class_floor" placeholder="Classroom floor" value="'.$rows['classrooms_floor'].'" pattern="[1-9]" required>
                                <input type="text" name="class_seats" placeholder="Seats" value="'.$rows['classrooms_seats'].'" pattern="[0-9]{1,3}" required>
                                <input type="submit" name="edit" value="Edit">
                            </form>
                        </td>
                    </tr>';
                    $num+=2;
            }
        }
    }
    /**********************************CLASSROOM SECTION****************************************/

    /**********************************COURSES SECTION****************************************/
    public static function checkCourseData($dbh,$name){
        $query='SELECT * FROM courses WHERE courses_name=:name;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":name"=>$name));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["courses_id"]>0) return true;
    }

    public static function addCoursesData($dbh,$name,$hours,$type){
        if(!func::checkCourseData($dbh,$name)){
            $query='INSERT INTO courses (courses_name,courses_hours,
            courses_type) VALUES(:name,:hours,:type);';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":name"=>$name,":hours"=>$hours,":type"=>$type));
        }else{
            echo '
                <div class="modale">
                    <div class="modale_data">
                        <i id="close" class="fa fa-plus-circle"></i>
                        <p>
                            <span>'.$name.'</span> this course name exist you should enter other course. 
                        </p>
                    </div>
                </div>';
        }
    }

    public static function editCoursesData($dbh,$id,$name,$hours,$type){
        $query='SELECT * FROM courses WHERE courses_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["courses_id"]>0) $nameId=$row["courses_name"];
        
        if((func::checkCourseData($dbh,$name) && $name==$nameId) || !func::checkCourseData($dbh,$name)){
            $query='UPDATE courses SET courses_name=:name,courses_hours=:hours,
            courses_type=:type WHERE courses_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":name"=>$name,":hours"=>$hours,":type"=>$type,":id"=>$id));
            echo '<script type="text/javascript"> window.location="courses.php?edit=success" </script>';
        }
        if(func::checkCourseData($dbh,$name)){
            echo '
            <div class="modale">
                <div class="modale_data">
                    <i id="close" class="fa fa-plus-circle"></i>
                    <p>
                        <span>'.$name.'</span> this course name exist you cant continue editing. 
                    </p>
                </div>
            </div>';
        }
    }

    public static function checkCourseDelete($dbh,$courseId){
        $query='SELECT * FROM affectations WHERE affectations_courseid=:courseId;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":courseId"=>$courseId));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row["affectations_id"]>0) return true;
    }

    public static function deleteCoursesData($dbh,$id){
        if(!func::checkCourseDelete($dbh,$id)){
            $query='DELETE FROM courses WHERE courses_id=:id;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":id"=>$id));
            echo '<script type="text/javascript"> window.location="courses.php?delete=success" </script>';
        }
        else{
            $query='SELECT * FROM courses WHERE courses_id=:courseId;';
            $stmt=$dbh->prepare($query);
            $stmt->execute(array(":courseId"=>$id));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            echo '
            <div class="modale">
                <div class="modale_data">
                    <i id="close" class="fa fa-plus-circle"></i>
                    <p>
                        <span>'.$row["courses_name"].'</span> this course is affected in exams table you should
                        delete it first from the exmas table. 
                    </p>
                </div>
            </div>';
        }
    }

    public static function showCoursesData($dbh){
        $query='SELECT * FROM courses;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num=1;

        foreach($row as $rows){    
            if($rows['courses_id']>0){
                echo ' <tr>
                        <td>'.$rows['courses_id'].'</td>
                        <td>'.$rows['courses_name'].'</td>
                        <td>'.$rows['courses_hours'].'</td>
                        <td>'.$rows['courses_type'].'</td>
                        <td><button num="'.$num.'" class="edit">Edit</button></td>
                        <td>
                            <form class="delete_form" method="post">
                                <input type="text" value="'.$rows['courses_id'].'" name="id" >
                                <input type="submit" name="delete" value="Delete" class="delete"></td>
                            </form>
                    </tr>
                    <tr>
                        <td colspan="6" class="input_edit">
                            <form method="post">
                                <input type="text" value="'.$rows['courses_id'].'" name="id" >
                                <input type="text" name="course_name" placeholder="course name" value="'.$rows['courses_name'].'" pattern="*" required>
                                <input type="text" name="course_hours" placeholder="course hours" value="'.$rows['courses_hours'].'" pattern="[0-9]{1,2}" required>
                                <div class="radio_item">';
                                    if($rows['courses_type']=='cour'){
                                    echo'<div class="radio">
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
                                        </div>';
                                    }
                                    if($rows['courses_type']=='td'){
                                        echo'<div class="radio">
                                                <input name="course_type" value="cour" type="radio" >
                                                <span>Cour</span>
                                            </div>
                                            <div class="radio">
                                                <input name="course_type" value="td" type="radio" checked >
                                                <span>TD</span>
                                            </div>
                                            <div class="radio">
                                                <input name="course_type" value="tp" type="radio" >
                                                <span>TP</span>
                                            </div>';
                                    }
                                    if($rows['courses_type']=='tp'){
                                        echo'<div class="radio">
                                                <input name="course_type" value="cour" type="radio" >
                                                <span>Cour</span>
                                            </div>
                                            <div class="radio">
                                                <input name="course_type" value="td" type="radio" >
                                                <span>TD</span>
                                            </div>
                                            <div class="radio">
                                                <input name="course_type" value="tp" type="radio" checked >
                                                <span>TP</span>
                                            </div>';
                                    }
                            echo'</div>
                                <input type="submit" name="edit" value="Edit">
                            </form>
                        </td>
                    </tr>';
                    $num+=2;
            }
        }
    }
    /**********************************COURSES SECTION****************************************/

    /**********************************INDEX SECTION****************************************/
    public static function existentProf($dbh,$date,$start){
        $query='SELECT * FROM affectations WHERE affectations_date=:date
                AND affectations_start=:start;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":date"=>$date,":start"=>$start));
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $profTable = [];
        $i=0;
        foreach($row as $rows){
            if($rows["affectations_id"]>0){
                $profTable[$i]=$rows['affectations_prof1'];$i++;
                $profTable[$i]=$rows['affectations_prof2'];$i++;
                $profTable[$i]=$rows['affectations_prof3'];$i++;
                $profTable[$i]=$rows['affectations_prof4'];$i++;
                $profTable[$i]=$rows['affectations_prof5'];$i++;
            }
        }
        return $profTable;
    }

    public static function showProfessorsList($dbh,$date,$start){
        $query='SELECT * FROM professors;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $profNameOccupped=func::existentProf($dbh,$date,$start);
        $profNameDb = [];
        $i=0;

        foreach($row as $rows){
            if($rows['professors_id']>0){
                $profNameDb[$i++]=$rows['professors_id'].'.'.$rows['professors_firstname']
                                .'.'.$rows['professors_lastname'];
            }
        }

        for($i=0;$i<count($profNameDb);$i++){
            if(!in_array($profNameDb[$i],$profNameOccupped))
                echo '<option>'.$profNameDb[$i].'</option></br>';
        }
    }

    public static function existentCourse($dbh,$date,$start){
        $query='SELECT * FROM affectations;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $course = [];
        $i=0;
        
        foreach($row as $rows){
            if($rows['affectations_date']!=$date||($rows['affectations_date']==$date && $rows['affectations_start']!=$start)){
                if(!in_array($rows['affectations_courseid'],$course)){
                    $course[$i++]=$rows['affectations_courseid']; 
                }
            }
        }
        return $course;
    }
    
    public static function showCoursesList($dbh,$date,$start,$courseId){
        $query='SELECT * FROM courses;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courseOccupped=func::existentCourse($dbh,$date,$start);
        $courseNameDb = [];
        $i=0;

        foreach($row as $rows){
            if($rows['courses_id']>0){
                $courseNameDb[$i++]=$rows['courses_id'];
            }
        }

        for($i=0;$i<count($courseNameDb);$i++){
            if(!in_array($courseNameDb[$i],$courseOccupped)){
                $query='SELECT * FROM courses WHERE courses_id=:courseNameDb;';
                $stmt=$dbh->prepare($query);
                $stmt->execute(array("courseNameDb"=>$courseNameDb[$i]));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if($courseId==$courseNameDb[$i])
                    echo '<option selected>'.$row["courses_name"].'</option></br>';
                else
                    echo '<option>'.$row["courses_name"].'</option></br>';
            }
        }
    }

    public static function existentClass($dbh,$date,$start){
        $query='SELECT * FROM affectations WHERE affectations_date=:date
        AND affectations_start=:start;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":date"=>$date,":start"=>$start));
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $classTable = [];
        $i=0;

        foreach($row as $rows){
            if($rows["affectations_id"]>0){
                $classTable[$i++]=$rows['affectations_classid'];
            }
        }
        return $classTable;
    }

    public static function showClassroomList($dbh,$date,$start){
        $query='SELECT * FROM classrooms;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $classOccupped=func::existentClass($dbh,$date,$start);
        $classNameDb = [];
        $i=0;

        foreach($row as $rows){
            if($rows['classrooms_id']>0){
                $classNameDb[$i++]=$rows['classrooms_id'];
            }
        }

        for($i=0;$i<count($classNameDb);$i++){
            if(!in_array($classNameDb[$i],$classOccupped)){
                $query='SELECT * FROM classrooms WHERE classrooms_id=:classNameDb;';
                $stmt=$dbh->prepare($query);
                $stmt->execute(array("classNameDb"=>$classNameDb[$i]));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                echo '<option>'.$row["classrooms_number"].'</option></br>';
            }
        }
    }

    public static function addAffect($dbh,$classroomNb,$courseName,$date,$start,
        $end,$prof1,$prof2,$prof3,$prof4,$prof5){
        
        $query='SELECT * FROM courses WHERE courses_name=:courseName;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":courseName"=>$courseName));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $courseId=$row['courses_id'];

        $query='SELECT * FROM classrooms WHERE classrooms_number=:classroomNb;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":classroomNb"=>$classroomNb));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $classId=$row['classrooms_id'];

        $query='INSERT INTO affectations(affectations_classid,affectations_courseid
        ,affectations_date,affectations_start,affectations_end,affectations_prof1,
        affectations_prof2,affectations_prof3,affectations_prof4,affectations_prof5)
        VALUES(:classId,:courseId,:date,:start,:end,:prof1,:prof2,:prof3,:prof4,:prof5);';

        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":classId"=>$classId,":courseId"=>$courseId,
        ":date"=>$date,":start"=>$start,":end"=>$end,":prof1"=>$prof1,":prof2"=>$prof2,
        ":prof3"=>$prof3,":prof4"=>$prof4,":prof5"=>$prof5));
    
        header("location:index.php");
    }

    public static function deleteExam($dbh,$courseId){
        $query='DELETE FROM affectations WHERE affectations_courseid=:courseId;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":courseId"=>$courseId));
    }

    public static function showAffect($dbh){
        $query='SELECT *
                FROM affectations,classrooms,courses
                WHERE affectations_classid=classrooms_id AND affectations_courseid=courses_id  
                ORDER BY affectations_date,affectations_start ASC;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $course = "";
        foreach($row as $rows){    
            
            if($rows['affectations_id']>0){
                $fullDay=explode("-",$rows['affectations_date']);
                $day=$fullDay[2];
                $month=$fullDay[1];
                $year=$fullDay[0];
                $dayName=date("l",mktime(10,0,0,$month,$day,$year));

                $fullTimeStart=explode(":",$rows['affectations_start']);
                $start=$fullTimeStart[0].':'.$fullTimeStart[1];

                $fullTimeEnd=explode(":",$rows['affectations_end']);
                $end=$fullTimeEnd[0].':'.$fullTimeEnd[1];

                if($course!=$rows['courses_name']){
                    $first=0;
                }
                if($first==0){
                    echo '
                    <tr class="background_th">
                        <th colspan="2">Date</th>
                        <th>Module</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <tr class="background">
                        <td colspan="2">'.$dayName.'</br>'.$rows['affectations_date'].'</br>'.$start.' >> '.$end.'</td>
                        <td>'.$rows['courses_name'].'</td>
                        <td>
                            <form class="delete_form" action="index.php?edit=start&editExam=start" method="post">
                                <input type="text" value="'.$rows['affectations_courseid'].'" name="course">                           
                                <input type="submit" name="edit_exam" value="Edit Exam" class="edit">
                            </form>
                        </td>
                        <td>
                            <form class="delete_form" action="index.php?delete=success" method="post"> 
                                <input type="text" value="'.$rows['affectations_courseid'].'" name="course">                           
                                <input type="submit" name="delete_exam" value="Delete Exam" class="delete">
                            </form>
                        </td>
                    </tr>';
                    $course=$rows['courses_name'];
                    $first=1;
                }

                echo ' 
                <tr>  
                    <td>'.$rows['affectations_id'].'</td>
                    <td>'.$rows['classrooms_number'].'</td>
                    <td>';
                        for($i=1;$i<=5;$i++){
                            if($rows['affectations_prof'.$i]!='none'){
                                $profName=explode(".",$rows['affectations_prof'.$i]);
                                echo  $profName[1].' '.$profName[2].'</br>';
                            }
                        }
            echo    '<td>
                        <form class="delete_form" action="index.php?edit=start&editGlobal=start" method="post">
                            <input type="text" value="'.$rows['affectations_id'].'" name="id">
                            <input type="submit" name="edit" value="Edit" class="edit">
                        </form>
                    </td>
                    <td>
                        <form class="delete_form" action="index.php?delete=success" method="post">
                            <input type="text" value="'.$rows['affectations_id'].'" name="id">                           
                            <input type="submit" name="delete" value="Delete" class="delete">
                        </form>
                    </td>
                    </tr>';
            }
        }
    }

    public static function checkDeleteAll($dbh){
        $query='SELECT * FROM affectations;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row =$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($row)>3) return true;
    }

    public static function getEditDate($dbh,$courseId){

        $query='SELECT * FROM affectations WHERE affectations_courseid=:courseId;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":courseId"=>$courseId));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        echo ' 
        <form method="post" action="index.php?update=success" id="edit_form">
            <h1>Edit Exams</h1>
            <div class="items_container">

                <div class="items" >
                    <span>Date</span>
                    <input type="date" value="'.$row["affectations_date"].'" name="date" id="date" required>
                </div>

                <div class="items" >
                    <span>Hour start</span>
                    <input type="text" placeholder="hh:mm:ss" value="'.$row["affectations_start"].'" name="start" id="start" required><br>
                    <span>Hour end</span>
                    <input type="text" placeholder="hh:mm:ss" value="'.$row["affectations_end"].'" name="end" id="end" required>
                </div>

                <div class="items" >
                <span>Course</span>
                    <select name="module" id="module" required>';
                    func::showCoursesList($dbh,$row['affectations_date'],$row['affectations_start'],$courseId);    
                echo'</select>
                </div>

                <input type="text" value="'.$courseId.'" name="course" id="update_id">
                <input type="submit" value="Update" name="update_exam">
            </div>
        </form>';
    }

    public static function updateAffectDate($dbh,$fullDateDay,$start,$end,$courseName,$oldCourseId){
       
        $query='SELECT * FROM courses WHERE courses_name=:courseName;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":courseName"=>$courseName));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $courseId=$row["courses_id"];
        
        $query='UPDATE affectations SET
        affectations_courseid=:courseId, 
        affectations_date=:date,
        affectations_start=:start,
        affectations_end=:end
        WHERE
        affectations_courseid=:oldCourseId;';

        $stmt=$dbh->prepare($query);
        $stmt->execute(array(
            ":courseId"=>$courseId,
            ":date"=>$fullDateDay,
            ":start"=>$start,
            ":end"=>$end,
            ":oldCourseId"=>$oldCourseId
        ));
    }

    public static function getEditData($dbh,$id){

        $query='SELECT * FROM affectations WHERE affectations_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);

        $queryClass='SELECT * FROM classrooms WHERE classrooms_id=:classId;';
        $stmtClass=$dbh->prepare($queryClass);
        $stmtClass->execute(array(":classId"=>$row["affectations_classid"]));
        $rowClass =$stmtClass->fetch(PDO::FETCH_ASSOC); 
        
        echo ' 
        <form method="post" action="" id="edit_form">
            <h1>Edit Exams</h1>
            <div class="items_container">

                <p id="valide_data" class="text_translate_100"></p>
                <div class="items">
                    <span>Classroom</span>
                    <select name="classroom" id="classroom" required>
                        <option selected>'.$rowClass['classrooms_number'].'</option>';                           
                            func::showClassroomList($dbh,$row['affectations_date'],$row['affectations_start']);           
                    echo'</select>
                </div>';

                for($i=1;$i<=5;$i++){
                    echo 
                    '<div class="items">   
                        <span>Professors '.$i.'</span>
                        <select name="prof'.$i.'" id="prof'.$i.'"required>
                            <option>none</option>';
                            if($row['affectations_prof'.$i]!='none')
                            echo '<option selected>'.$row['affectations_prof'.$i].'</option>';
                            func::showProfessorsList($dbh,$row['affectations_date'],$row['affectations_start']);
                        echo'</select>
                    </div>';
                }

                echo'
                <input type="text" value="'.$id.'" name="id" id="update_id">
                <input type="button" value="Update" id="update" name="update">
            </div>
        </form>';
    }

    public static function updateAffect($dbh,$id,$classroomNb,$prof1,$prof2
    ,$prof3,$prof4,$prof5){  
        $query='SELECT * FROM classrooms WHERE classrooms_number=:classroomNb;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":classroomNb"=>$classroomNb));
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $classId=$row["classrooms_id"];

        $query='UPDATE affectations SET 
        affectations_classid=:classId,
        affectations_prof1=:prof1,
        affectations_prof2=:prof2,
        affectations_prof3=:prof3,
        affectations_prof4=:prof4,
        affectations_prof5=:prof5 WHERE
        affectations_id=:id;';

        $stmt=$dbh->prepare($query);
        $stmt->execute(array(
            ":classId"=>$classId,
            ":prof1"=>$prof1,
            ":prof2"=>$prof2,
            ":prof3"=>$prof3,
            ":prof4"=>$prof4,
            ":prof5"=>$prof5,
            ":id"=>$id
        ));
    }

    public static function deleteAffect($dbh,$id){
        $query='DELETE FROM affectations WHERE affectations_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));     
    } 

    public static function deleteAll($dbh){
        $query='DELETE FROM affectations;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
    }
    /**********************************INDEX SECTION****************************************/
    /**********************************USER SECTION****************************************/
    public static function class($dbh,$id){
        $query='SELECT * FROM classrooms WHERE classrooms_id=:id;';
        $stmt=$dbh->prepare($query);
        $stmt->execute(array(":id"=>$id));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row['classrooms_floor'];
    }

    public static function dateExistent($dbh){
        $query='SELECT * FROM affectations ORDER BY affectations_date,affectations_start ASC;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $date = [];
        $i=0;

        foreach($row as $rows){
            if($rows['affectations_id']>0){
                if(!in_array($rows['affectations_date'],$date)){
                    $date[$i++]=$rows['affectations_date'];
                }
            }
        }
        return $date;
    }

    public static function courseExistent($dbh){
        $query='SELECT * FROM affectations ORDER BY affectations_date,affectations_start ASC;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $course = [];
        $i=0;

        foreach($row as $rows){
            if($rows['affectations_id']>0){
                if(!in_array($rows['affectations_courseid'],$course)){
                    $course[$i++]=$rows['affectations_courseid'];
                }
            }
        }
        return $course;
    }

    public static function moduleItems($dbh){
        $query='SELECT * FROM affectations ORDER BY affectations_date,affectations_start ASC;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $date=func::dateExistent($dbh);
        $i=1;
        $course = [];

        for($j=0;$j<count($date);$j++){
            $fullDay=explode("-",$date[$j]);
            $day=$fullDay[2];
            $month=$fullDay[1];
            $year=$fullDay[0];
            $dayName=date("l",mktime(10,0,0,$month,$day,$year));
            echo '<p>'.$dayName.' '.$day.'/'.$month.'/'.$year.'</p><div class="module">';
            foreach($row as $rows){
                if($rows['affectations_id']>0){
                    if($rows['affectations_date']==$date[$j] &&
                        !in_array($rows['affectations_courseid'],$course)){

                            $queryCourse='SELECT * FROM courses WHERE courses_id=:courseId;';
                            $stmtCourse=$dbh->prepare($queryCourse);
                            $stmtCourse->execute(array(":courseId"=>$rows['affectations_courseid']));
                            $rowCourse=$stmtCourse->fetch(PDO::FETCH_ASSOC);

                            $course[$i-1]=$rowCourse['courses_id'];
                            echo '<button num="'.$i.'">'.$rowCourse['courses_name'].'</button>';
                            $i++;
                    }
                }
            }
            echo '</div>';
        }
        
    }

    public static function examItems($dbh){
        $query='SELECT * FROM affectations ORDER BY affectations_date;';
        $stmt=$dbh->prepare($query);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $course=func::courseExistent($dbh);
        $i=1;

        for($c=0;$c<count($course);$c++){
            if($i==1) echo '<div class="exam up" num="'.$i.'">';
            else echo '<div class="exam back" num="'.$i.'">';
            foreach($row as $rows){
                if($rows['affectations_id']>0){
                    $classFloor=func::class($dbh,$rows['affectations_classid']);

                    $queryClass='SELECT * FROM classrooms WHERE classrooms_id=:classId;';
                    $stmtClass=$dbh->prepare($queryClass);
                    $stmtClass->execute(array(":classId"=>$rows['affectations_classid']));
                    $rowClass=$stmtClass->fetch(PDO::FETCH_ASSOC);

                    $classNb=$rowClass['classrooms_number'];

                    $fullTimeStart=explode(":",$rows['affectations_start']);
                    $start=$fullTimeStart[0].':'.$fullTimeStart[1];
    
                    $fullTimeEnd=explode(":",$rows['affectations_end']);
                    $end=$fullTimeEnd[0].':'.$fullTimeEnd[1];

                    if($course[$c]==$rows['affectations_courseid']){
                    echo    '<div class="exam_emploi">
                                <p>'.$start.' >> '.$end.'</p>
                                <p>salle : '.$classNb.'</p>
                                <p>Professors</p>';
                                for($j=1;$j<=5;$j++){
                                    if($rows['affectations_prof'.$j]!='none'){
                                        $profName=explode(".",$rows['affectations_prof'.$j]);

                                        echo '<p>'.$profName[1].' '.$profName[2].'</p>';
                                    }
                                }
                        echo   '<p>classroom floor <span>'.$classFloor.'</span></p>
                            </div>';
                    }
                }   
            }
            echo '</div>';
            $i++;
        }

    }
    /**********************************USER SECTION****************************************/

}
