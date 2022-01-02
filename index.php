<?php
    include './shared/header.php';
    include './shared/config.php';
    session_start();

    if(isset($_POST['log'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        
        $select = "SELECT * From `admin` WHERE username='$user' AND pass='$pass' ";
        $data = mysqli_query($connect,$select);

        $row = mysqli_fetch_assoc($data);

        if(mysqli_num_rows($data) != 0){
            $id = $row['id'];
            $_SESSION['id'] = $id;
            $_SESSION['key'] = $row['ref_id'];
            mysqli_query($connect,"UPDATE `admin` SET `isConnected` = '1' WHERE `admin`.`id` = $id");
            header("location: /university/courses/view.php");
        }else{
            echo "<div class='errMSG alert alert-danger col-sm-8'><p>Username or Password is Wrong</p></div>";
        }

    }

?>

<div class="login">
    <div class="left"></div>
    <div class="right"></div>

    <div class="form col-lg-4 col-sm-8">
        <form method="POST">
            <label> Username: </label>
            <input type="username" name="user">
            <label> Password: </label>
            <input type="password" name="pass">
            <div>
                <button type="submit" class="btn" name="log"> Login </button>
            </div>
        </form>
    </div>

</div>

<?php include './shared/footer.php' ?>