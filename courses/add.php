<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $editMode = false;
    $id = -1;

    if(isset($_GET['edit'])){
        $editMode = true;
        $id = $_GET['edit'];
        $select = "SELECT * FROM course WHERE id = $id";
        $ss = mysqli_query($connect,$select);
        $row = mysqli_fetch_assoc($ss);
        $name = $row['name'];
        $hours = $row['hours'];
    }

    if(isset($_POST['save'])){
        $CName = $_POST['CName'];
        $hours = $_POST['CHours'];
        $save = "UPDATE `course` SET `name` = '$CName',`hours`='$hours' WHERE `course`.`id` = $id;";
        mysqli_query($connect,$save);
        header("location: /university/courses/view.php");
    }

    if(isset($_POST['add'])){
        $CName = $_POST['CName'];
        $hours = $_POST['CHours'];
        $save = "INSERT INTO `course` (`id`, `name`,`hours`) VALUES (NULL, '$CName','$hours')";
        mysqli_query($connect,$save);
        header("location: /university/courses/view.php");
    }


?>



<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
    <?php if($editMode): ?>
        <h1 class="col-sm-12"> Edit: <?php echo $name; ?> </h1>
    <?php else: ?>
        <h1 class="col-sm-12"> Add New Course </h1>
    <?php endif; ?>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12">
            <label> Course Name: </label>
            <input type="text" name="CName" class="col-sm-12" value="<?php if($editMode){echo $name;}?>">
            
            <label> Course Hours: </label>
            <input type="text" name="CHours" class="col-sm-12" value="<?php if($editMode){echo $hours;}?>">

            <div class="col-sm-12 text-right p-0 pt-4">
            <?php if($editMode): ?>
                <button type="submit" name="save"> Save Course </button>
            <?php else: ?>
                <button type="submit" name="add"> Add Course </button>
            <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php 
    include '../shared/footer.php';
?>