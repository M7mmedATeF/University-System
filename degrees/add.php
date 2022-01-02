<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $crs_id;

    if(isset($_GET['subj'])){
        $crs_id = $_GET['subj'];
    }

    $select = "SELECT student.id,student.name,student.grade,student.hours as st_hours,student.grade,degree.degree,degree.id as deg_id ,course.hours as cr_hours FROM `student` LEFT JOIN `regestcourse` ON student.id = regestcourse.student_Id LEFT JOIN `degree` ON student.id = degree.std_id AND degree.crs_id = $crs_id LEFT JOIN `course` On course.id = $crs_id WHERE regestcourse.accepted = '1' AND regestcourse.course_id = $crs_id;";
    $tData = mysqli_query($connect,$select);
    
    if(isset($_POST['save'])){
        foreach($tData as $data){
            $std=strval($data['id']);
            $degree = $_POST[''.$std.''];
            $SID = $data['id'];
            
            if($data['degree'] == 0 || $data['degree'] == ""){
                $update = "INSERT INTO `degree`(`id`, `std_id`, `crs_id`, `degree`) VALUES ('Null','$SID','$crs_id','$degree');";
                mysqli_query($connect,$update);

                $degree = $_POST[''.$std.''] + $data['grade'];
                $gpa = ($degree/$data['st_hours']) * 4;
                $update = "UPDATE `student` SET `grade`='$degree',`gpa`='$gpa' WHERE `id`='$SID';";
                mysqli_query($connect,$update);
            }else{
                $degree = $_POST[''.$std.''];
                $deg_id = $data['deg_id'];
                $update = "UPDATE `degree` SET `degree`='$degree' WHERE id=$deg_id";
                mysqli_query($connect,$update);

                $degree = $_POST[''.$std.''] - $data['degree'] + $data['grade'];
                $gpa = ($degree/$data['st_hours']) * 4;
                $update = "UPDATE `student` SET `grade`='$degree',`gpa`='$gpa' WHERE `id`='$SID';";
                mysqli_query($connect,$update);
            }


            header("location: /university/degrees/view.php");
        }
    }

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> Degrees </h1>
    </div>
    <div class="form col-sm-12">
        <form method="POST">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>student Name</th>
                        <th>Hours Achived</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tData as $data){?>
                    <tr>
                        <td><?php echo $data['id'] ?></td>
                        <td><?php echo $data['name'] ?></td>
                        <td>
                            <input type="number" name="<?php echo $data['id'] ?>" value="<?php echo $data['degree'] ?>" min="0" max="<?php echo $data['cr_hours'] ?>">
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button class="col-sm-12 btn" name="save">Submit Degrees</button>
        </form>
    </div>
</div>


<?php 
    include '../shared/footer.php';
?>