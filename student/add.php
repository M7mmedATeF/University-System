<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $select = "SELECT doctor.id,doctor.name,COUNT(student.Advisor) as task FROM `doctor` LEFT JOIN `student` ON student.`Advisor` = doctor.id GROUP BY doctor.name;";
    $doctors = mysqli_query($connect,$select);

    $editMode = false;
    $id;
    if(isset($_GET['edit'])){
        $editMode = true;
        $id = $_GET['edit'];
        $select = "SELECT * FROM `student` WHERE id=$id;";
        $result = mysqli_query($connect,$select);
        $student = mysqli_fetch_assoc($result);
    }else if(isset($_GET['editprof'])){
        $editMode = true;
        $id = $_SESSION['key'];
        $select = "SELECT * FROM `student` WHERE id=$id;";
        $result = mysqli_query($connect,$select);
        $student = mysqli_fetch_assoc($result);
    }

    if(isset($_POST['editSup'])){
        $name = $_POST['SName'];
        $level = $_POST['level'];
        $advisor = $_POST['advisor'];
        if($_FILES['img']['name'] != ""){
            $type_img= $_FILES['img']['type'];
            $name_img= $_FILES['img']['name'];
            $tmp_img= $_FILES['img']['tmp_name'];
            $location = './uploads/';
            move_uploaded_file($tmp_img,$location.$name_img);
            $edit = "UPDATE `student` SET `name` = '$name', `level` = '$level', `img` = '$name_img' , `advisor` = '$advisor' WHERE `student`.`id` = $id";
            mysqli_query($connect,$edit);
            header("location: /university/student/view.php");
        }else{
            $edit = "UPDATE `student` SET `name` = '$name', `level` = '$level' , `advisor` = '$advisor' WHERE `student`.`id` = $id";
            mysqli_query($connect,$edit);
            header("location: /university/student/view.php");
        }
    }


    if(isset($_POST['add'])){
        $type_img= $_FILES['img']['type'];
        $name_img= $_FILES['img']['name'];
        $tmp_img= $_FILES['img']['tmp_name'];
        $location = './uploads/';
        move_uploaded_file($tmp_img,$location.$name_img);
        $SName = $_POST['SName'];
        $level = $_POST['level'];
        $advisor = $_POST['advisor'];
        $save = "INSERT INTO `student` (`id`, `name`, `level`, `img`,`advisor`) VALUES (NULL, '$SName', '$level', '$name_img',$advisor)";
        mysqli_query($connect,$save);
        $st_id = mysqli_query($connect,"SELECT id FROM `student` WHERE `name`='$SName' AND `level`= '$level' AND `advisor`= '$advisor';");
        $st_id = mysqli_fetch_assoc($st_id);
        $st_id = $st_id['id'];
        $createAcc = "INSERT INTO `admin`(`id`, `username`, `pass`, `userLevel`, `isConnected`, `ref_id`, `email`) VALUES (NULL,'$SName','student','3','0','$st_id','Please Enter Your E-mail')";
        mysqli_query($connect,$createAcc);
        header("location: /university/student/view.php");
    }


?>
<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
        <?php if($editMode): ?>
            <h1 class="col-sm-12"> Edit ST: <?php echo $student['name']; ?> </h1>
        <?php else: ?>
            <h1 class="col-sm-12"> Add New student </h1>
        <?php endif; ?>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12" enctype="multipart/form-data">
            <label> student Name: </label>
            <input type="text" name="SName" class="col-sm-12" value="<?php if($editMode){ echo $student['name']; } ?>">

            <label class="mt-2"> IMG: </label>
            <div class="img">
                <p> Choose Profile Image </p>
                <input type="file" name="img" class="col-sm-12">
            </div>

            <label class="mt-2"> Student Level: </label>
            <select name="level" class="col-sm-12" id="level">
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
                <option value="4">Level 4</option>
            </select>

            <label class="mt-2"> Academic Advisor: </label>
            <select name="advisor" class="col-sm-12" id="advisor">
                <?php foreach($doctors as $doc){ ?>
                    <option value="<?php echo $doc['id']; ?>"><?php echo $doc['name'] . "  ( Advisor for: " . $doc['task'] . " Students )"; ?></option>
                <?php } ?>
            </select>

            <div class="col-sm-12 text-right p-0 pt-4">
            <?php if($editMode): ?>
                <button type="submit" name="editSup"> Edit student </button>
            <?php else: ?>
                    <button type="submit" name="add"> Add student </button>
            <?php endif; ?>
            </div>
        </form>
    </div>
</div>


<?php if($editMode): ?>
    <script>
        document.getElementById('level').value = <?php echo $student['level'] ?>;
        document.getElementById('advisor').value = <?php echo $student['advisor'] ?>;
    </script>
<?php endif; ?>

<?php 
    include '../shared/footer.php';
?>