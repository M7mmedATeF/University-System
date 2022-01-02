<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $id;
    $courses;
    if(isset($_GET['prof'])){
        $id=$_GET['prof'];
        $select = "SELECT regestcourse.id, course.name FROM `regestcourse` INNER JOIN course ON regestcourse.course_id = course.id WHERE regestcourse.student_id = $id AND regestcourse.accepted = '1';";
        $courses = mysqli_query($connect,$select);
    }
   
    $select = "SELECT * FROM `student` where id=$id";
    $tData = mysqli_query($connect,$select);
    $data = mysqli_fetch_assoc($tData);

?>


<div class="container course profile my-5">
    <div class="headline col-sm-12 py-3">
        <h1 class="text-center col-sm-12"> ST: <?php echo $data['name'] ?>'s Profile </h1>
    </div>
    <div class="inner form col-sm-12">
        <div class="left col-md-4">
            <div class="prof col-sm-12">
                <img src="<?php if($data['img'] != ""){ echo "./uploads/".$data['img']; }else{echo "../assets/student.png";} ?>" alt="<?php echo $data['name'] ?>">
            </div>
            <h3 class="col-sm-12 text-center"><?php echo $data['name'] ?></h3>
            <hr>
            <p class="text-center"><span>Level:</span> <?php echo $data['level'] ?></p>
            <p class="text-center"><span>GPA:</span> <?php echo number_format((float)$data['gpa'], 2, '.', '') ?></p>
            <p class="text-center"><span>Rate:</span> <?php
             if($data['gpa']==4)
             {echo "A+";}
             else if($data['gpa'] >= 3)
             { echo "B"; }
             else if($data['gpa']>=2)
             { echo "C"; }
             else if($data['gpa']>=1)
             { echo "D"; }
             else
             {echo "F"; }
              ?></p>
        </div>
        <div class="right col-md-8">
            <div class="drcourses">
                <div class="col-sm-12 p-0">
                    <h2>Courses:</h2>
                </div>
                <?php if(mysqli_num_rows($courses)): ?>
                    <?php foreach($courses as $course){ ?>
                        <div class="outer col-md-4 col-sm-6">
                            <div>
                                <img src="/university/assets/course.png">
                                <div class="details p-2 pt-3 text-center">
                                    <h4><?php echo $course['name'] ?></h4>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php else: ?>
                    <img src="../assets/notfound.png" width="100%">
                <?php endif; ?>
            </div>
        </div>
<?php 
    include '../shared/footer.php';
?>