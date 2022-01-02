<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $addMode=false;
    if(isset($_GET['addAcc'])){
        $addMode=true;
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
    }

    $select = "SELECT * FROM `admin` WHERE id = $id;";
    $data = mysqli_query($connect,$select);
    $admin = mysqli_fetch_assoc($data);
    $s = "SELECT * FROM admin WHERE id = $id";
    $userdata = mysqli_fetch_assoc(mysqli_query($connect,$s));

    if(isset($_POST['save'])){
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $email = $_POST['email'];

        $check = mysqli_query($connect,"SELECT COUNT(id) as 'data' FROM `admin` WHERE username= '$username' AND id <> $id;");
        $row = mysqli_fetch_assoc($check);

        if($row['data'] == 0){
            $update = "UPDATE `admin` SET `username`='$username',`pass`='$pass',`isConnected`='0',`email`='$email' WHERE id=$id";
            $order = mysqli_query($connect,$update);
            header("location: /university/admin/view.php");
        }else{
            echo "<div class='errMSG alert alert-danger col-sm-8'><p>Username is Already Used Before</p></div>";
        }
    }

    if(isset($_POST['add'])){
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $email = $_POST['email'];

        $check = mysqli_query($connect,"SELECT COUNT(id) as 'data' FROM `admin` WHERE username= '$username' AND id <> $id;");
        $row = mysqli_fetch_assoc($check);

        if($row['data'] == 0){
            $add = "INSERT INTO `admin`(`id`, `username`, `pass`, `userLevel`, `isConnected`, `ref_id`, `email`) VALUES ('Null','$username','$pass','1','0','0','$email')";
            $order = mysqli_query($connect,$add);
            header("location: /university/admin/view.php");
        }else{
            echo "<div class='errMSG alert alert-danger col-sm-8'><p>Username is Already Used Before</p></div>";
        }
    }

?>

<div class="course container my-5">
    <div class="headline col-sm-8 py-3">
        <?php if($addMode): ?>
        <h1 class="text-center profile-head col-sm-12"> Add Account </h1>
        <?php else: ?>
        <h1 class="text-center profile-head col-sm-12"> Edit Account </h1>
        <?php endif; ?>
    </div>
    <div class="form col-sm-8">
        <form method="POST" class="col-sm-12">
            
            <label> Username: </label>
            <input type="text" name="username" class="col-sm-12" value="<?php if(!$addMode): echo $userdata['username']; endif; ?>">
            
            <label> Password: </label>
            <input type="text" name="pass" class="col-sm-12" value="<?php if(!$addMode): echo $userdata['pass']; endif; ?>">
            
            <label> Email: </label>
            <input type="email" name="email" class="col-sm-12" value="<?php if(!$addMode): echo $userdata['email']; endif; ?>">

            <div class="col-sm-12 text-right p-0 pt-4">
            <?php if($addMode): ?>
                <button type="submit" name="add"> Add Admin </button>
            <?php else: ?>
                <button type="submit" name="save"> Save Changes </button>
            <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('userLevel').value = <?php echo $userdata['userLevel'] ?>;

</script>

<?php 
    include '../shared/footer.php';
?>