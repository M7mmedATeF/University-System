<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $id;
    if(isset($_GET['add'])){
        $id = $_GET['add'];
        $select = "SELECT * FROM `course` Where id NOT IN (SELECT course_id From drcourse WHERE doctor_id = $id);";
        $courses = mysqli_query($connect,$select);
    }

    if(isset($_POST['save'])){
        $crsId = $_POST['course'];
        $save = "INSERT INTO `drcourse` (`id`, `course_id`, `doctor_id`) VALUES (NULL, '$crsId', '$id');";
        $courses = mysqli_query($connect,$save);
        header("location: /university/doctor/view.php");
    }
    

?>

<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
        <h1 class="col-sm-12"> Assign Courses to Doctors </h1>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12" enctype="multipart/form-data">
            <label> Courses: </label>
            <select name="course">
                <?php foreach($courses as $course){ ?>
                    <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
                <?php } ?>
            </select>
            <div class="col-sm-12 text-right p-0 pt-4">
                <button type="submit" name="save"> Add Course to this Doctor </button>
            </div>
        </form>
    </div>
</div>

<?php 
    include '../shared/footer.php';
?>