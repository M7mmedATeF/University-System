<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $id;
    $courses;
    if(isset($_GET['prof'])){
        $id=$_GET['prof'];
        $select = "SELECT drcourse.doctor_id,course.name FROM drcourse INNER JOIN course ON drcourse.course_id = course.id WHERE drcourse.doctor_id = $id";
        $courses = mysqli_query($connect,$select);
    }
   
    $select = "SELECT * FROM `doctor` where id=$id";
    $tData = mysqli_query($connect,$select);
    $data = mysqli_fetch_assoc($tData);

?>


<div class="container course profile my-5">
    <div class="headline col-sm-12 py-3">
        <h1 class="text-center col-sm-12"> DR: <?php echo $data['name'] ?>'s Profile </h1>
    </div>
    <div class="inner form">
        <div class="left col-md-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="prof col-sm-12">
                <img src="<?php if($data['img'] != ""){ echo "./uploads/".$data['img']; }else{echo "../assets/doctor.png";} ?>" alt="<?php echo $data['name'] ?>">
                </div>
                <h3 class="col-sm-12 text-center"><?php echo $data['name'] ?></h3>
            </form>
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
                                    <div class="details p-2 pt-4 text-center">
                                        <h4><?php echo $course['name'] ?></h4>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php else: ?>
                        <img src="../assets/notfound.png" width="100%">
                    <?php endif; ?>
                </div>
<?php 
    include '../shared/footer.php';
?>