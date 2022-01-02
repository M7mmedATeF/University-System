<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $select = "SELECT * FROM `course`";
    
    if($userLevel == 2){
        $select = "SELECT course.* FROM `course` LEFT JOIN drcourse On course.id = drcourse.course_id WHERE drcourse.doctor_id = $key;";
    }
   
    $tData = mysqli_query($connect,$select);

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> Subject </h1>
    </div>
    <div class="form col-sm-12">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['name'] ?></td>
                    <td>
                        <a href="/university/degrees/add.php?subj=<?php echo $data['id'] ?>" class="btn btn-info mr-2 tip" data-tip="Add Degrees" ><i class="fas fa-chevron-right"></i></a>
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