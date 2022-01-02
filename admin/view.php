<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

       
    $select = "SELECT * FROM `admin` ORDER BY `userLevel` ASC";

    if(isset($_POST['searchKey'])){
        $serchName=strtolower($_POST['searchKey']);
        $select = "SELECT * FROM `admin` WHERE LOWER(username) LIKE '%$serchName%';";
    }

    $tData = mysqli_query($connect,$select);
    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
        $delete = "DELETE FROM `admin` WHERE `admin`.`id` = $id";
        mysqli_query($connect,$delete);
        if($_GET['lvl']==2){
            $deletedr = "DELETE FROM `doctor` WHERE id = $id";
            $deletedrcr = "DELETE FROM `drcourse` WHERE doctor_id = $id";
            mysqli_query($connect,$deletedr);
            mysqli_query($connect,$deletedrcr);
        }else if($_GET['lvl']==3){
            $deletest = "DELETE FROM `student` WHERE id = $id";
            $deletereg = "DELETE FROM `regestcourse` WHERE student_id = $id";
            $deleterdeg = "DELETE FROM `degree` WHERE std_id = $id";
            mysqli_query($connect,$deleterdeg);
            mysqli_query($connect,$deletereg);
            mysqli_query($connect,$deletest);
        }
        header("location: /university/admin/view.php");
    }

    if($userLevel != 1){
        header("location: /university/student/view.php");
    }

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> admins </h1>
    </div>
    <div class="form col-sm-12">
        <form method="POST" class="search text-right col-sm-12">
            <input type="text" name="searchKey" class="input" placeholder="Who are you searching For ?">
            <button type="submit" name="searchBTN" class="btn btn-info"><i class="fas fa-search"></i></button>
        </form>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Users</th>
                    <th>User Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['username'] ?></td>
                    <td>
                        <?php
                            if($data['userLevel']==1){
                                echo "admin";
                            }elseif($data['userLevel']==2){
                                echo "Doctor";
                            }else{
                                echo "Student";
                            }
                        ?>
                    </td>
                    <td>
                        <a href="/university/admin/view.php?delete=<?php echo $data['id'] ?>&lvl=<?php echo $data['userLevel'] ?>" class="btn btn-danger mr-2 tip" data-tip="Delete" >X</a>
                        <a href="/university/admin/account.php?edit=<?php echo $data['id'] ?>" class="btn btn-warning tip" data-tip="Edit" ><i class="fas fa-edit"></i></a>
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