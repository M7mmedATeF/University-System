<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $select;
    if($userLevel == 1){
        $select = "SELECT regestcourse.id, regestcourse.student_Id as st_id , student.hours as st_hours ,student.name as st_name , course.name as cr_name , course.id as cr_id , course.hours as cr_hours FROM `regestcourse` LEFT JOIN `student` ON regestcourse.student_Id = student.id LEFT JOIN `course` ON regestcourse.course_id = course.id WHERE accepted = 0";
    }else if($userLevel == 2){
        $select = "SELECT regestcourse.id, regestcourse.student_Id as st_id , student.hours as st_hours ,student.name as st_name , course.name as cr_name , course.id as cr_id , course.hours as cr_hours FROM `regestcourse` LEFT JOIN `student` ON regestcourse.student_Id = student.id LEFT JOIN `course` ON regestcourse.course_id = course.id WHERE doc_id=$key AND accepted = 0";
    }else{
        header("location: /universty/student/view.php");
    }

    if(isset($_GET['accept'])){
        $id=$_GET['accept'];
        $hours = $_GET['hours'] + $_GET['Shours'];
        $S_id = $_GET['SID'];
        $C_id = $_GET['CID'];
        $updatereg = "UPDATE `regestcourse` SET `accepted`='1' WHERE id=$id";
        $updatest = "UPDATE `student` SET `hours`='$hours' WHERE id=$S_id";
        mysqli_query($connect,$updatereg);
        mysqli_query($connect,$updatest);
    }

    if(isset($_GET['refuse'])){
        $id=$_GET['refuse'];
        $update = "DELETE FROM `regestcourse` WHERE id=$id;";
        mysqli_query($connect,$update);
    }

    $tData = mysqli_query($connect,$select);

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> Course Regestration </h1>
    </div>
    <div class="form col-sm-12">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['st_name'] ?></td>
                    <td><?php echo $data['cr_name'] ?></td>
                    <td>
                        <a href="/university/regCourse/dracept.php?accept=<?php echo $data['id']; ?>&hours=<?php echo $data['cr_hours']; ?>&Shours=<?php echo $data['st_hours']; ?>&SID=<?php echo $data['st_id'];?>&CID=<?php echo $data['cr_id']; ?>" class="btn btn-success mr-2 tip" data-tip="Accepted" ><i class="fas fa-check"></i></a>
                        <a href="/university/regCourse/dracept.php?refuse=<?php echo $data['id']; ?>" class="btn btn-danger tip" data-tip="Refused" ><i class="fas fa-times"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php 
    include '../shared/footer.php';
?>