<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $editMode = false;
    $id;
    if(isset($_GET['edit'])){
        $editMode = true;
        $id = $_GET['edit'];
        $select = "SELECT * FROM `doctor` WHERE id=$id;";
        $result=mysqli_query($connect,$select);
        $doctor = mysqli_fetch_assoc($result);
    }

    if(isset($_POST['editSup'])){
        $name = $_POST['DName'];
        if($_FILES['img']['name'] != ""){
            $type_img= $_FILES['img']['type'];
            $name_img= $_FILES['img']['name'];
            $tmp_img= $_FILES['img']['tmp_name'];
            $location = './uploads/';
            move_uploaded_file($tmp_img,$location.$name_img);
            $edit = "UPDATE `doctor` SET `name` = '$name' , `img` = '$name_img' WHERE `doctor`.`id` = $id;";
            mysqli_query($connect,$edit);
            header("location: /university/doctor/view.php");
        }else{
            $edit = "UPDATE `doctor` SET `name` = '$name' WHERE `doctor`.`id` = $id;";
            mysqli_query($connect,$edit);
            header("location: /university/doctor/view.php");
        }
    }


    if(isset($_POST['add'])){
        $type_img= $_FILES['img']['type'];
        $name_img= $_FILES['img']['name'];
        $tmp_img= $_FILES['img']['tmp_name'];
        $location = './uploads/';
        move_uploaded_file($tmp_img,$location.$name_img);
        $DName = $_POST['DName'];
        $save = "INSERT INTO `Doctor` (`id`, `name`,`img`) VALUES (NULL, '$DName','$name_img')";
        mysqli_query($connect,$save);
        $dr_id = mysqli_query($connect,"SELECT id FROM `doctor` WHERE `name`='$DName' AND `img`= '$name_img';");
        $dr_id = mysqli_fetch_assoc($dr_id);
        $dr_id = $dr_id['id'];
        $createAcc = "INSERT INTO `admin`(`id`, `username`, `pass`, `userLevel`, `isConnected`, `ref_id`, `email`) VALUES (NULL,'$DName','doctor','2','0','$dr_id','Please Enter Your E-mail')";
        mysqli_query($connect,$createAcc);
        header("location: /university/doctor/view.php");
    }


?>

<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
        <?php if($editMode): ?>
            <h1 class="col-sm-12"> Edit DR: <?php echo $doctor['name']; ?> </h1>
        <?php else: ?>
            <h1 class="col-sm-12"> Add New Doctor </h1>
        <?php endif; ?>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12" enctype="multipart/form-data">
            <label> Doctor Name: </label>
            <input type="text" name="DName" class="col-sm-12" value="<?php if($editMode){ echo $doctor['name']; } ?>">

            <label class="mt-2"> IMG: </label>
            <div class="img">
                <p> Choose Profile Image </p>
                <input type="file" name="img" class="col-sm-12">
            </div>

            <div class="col-sm-12 text-right p-0 pt-4">
            <?php if($editMode): ?>
                <button type="submit" name="editSup"> Edit Doctor </button>
            <?php else: ?>
                    <button type="submit" name="add"> Add Doctor </button>
            <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<?php 
    include '../shared/footer.php';
?>