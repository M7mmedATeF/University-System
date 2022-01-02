<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $id = $key;

    $adminMode = false;
    
    if(isset($_GET['st_id'])){
        $adminMode = true;
        $id = $_GET['st_id'];
    }

    $select = "SELECT * FROM `course` Where id NOT IN (SELECT course_id From regestcourse WHERE student_id = $id);";
    $courses = mysqli_query($connect,$select);

    if(isset($_POST['req'])){
        $select = "SELECT * FROM `student` WHERE id=$id";
        $data = mysqli_query($connect,$select);
        $doc_id = mysqli_fetch_assoc($data);
        $doc_id = $doc_id['advisor'];
        $course = $_POST['course'];
        $add = "INSERT INTO `regestcourse` (`id`, `student_Id`, `course_id`, `accepted`, `doc_id`) VALUES (NULL, '$id', '$course', '0', '$doc_id');";
        $courses = mysqli_query($connect,$add);
        if($adminMode)
            header("location: /university/regcourse/regcourse.php?st_id=$id");
        else
            header("location: /university/regcourse/regcourse.php");
    }
    

?>

<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
        <h1 class="col-sm-12"> Ask For Course </h1>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12" enctype="multipart/form-data">
            <label> Courses: </label>
            <select name="course">
                <?php foreach($courses as $course){ ?>
                    <option value="<?php echo $course['id'] ?>"><?php echo $course['name']."  ( ".$course['hours']." Hours )"; ?></option>
                <?php } ?>
            </select>
            <div class="col-sm-12 text-right p-0 pt-4">
                <button type="submit" name="req"> Request Course </button>
            </div>
        </form>
    </div>
</div>

<?php 
    include '../shared/footer.php';
?>