<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
        $delete = "DELETE FROM `student` WHERE `student`.`id` = $id";
        $deleteAcc = "DELETE FROM `admin` WHERE `ref_id` = $id AND `userlevel` = 3";
        mysqli_query($connect,$deleteAcc);
        mysqli_query($connect,$delete);
    }

    $select = "SELECT * FROM `student`";
    
    if(isset($_POST['searchKey'])){
        $serchName=strtolower($_POST['searchKey']);
        $select = "SELECT * FROM `student` WHERE LOWER(name) LIKE '%$serchName%';";
    }
   
    $tData = mysqli_query($connect,$select);

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> students </h1>
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
                    <th>student Name</th>
                    <th>Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['name'] ?></td>
                    <td><?php echo $data['level'] ?></td>
                    <td>
                <?php if($userLevel == 1): ?>
                        <a href="/university/student/view.php?delete= <?php echo $data['id'] ?>" class="btn btn-danger mr-2 tip" data-tip="Delete" >X</a>
                <?php endif; ?>
                        <a href="/university/student/profile.php?prof=<?php echo $data['id'] ?>" class="btn btn-info mr-2 tip" data-tip="Profile" ><i class="far fa-eye"></i></a>
                <?php if($userLevel == 1): ?>
                        <a href="/university/regCourse/regcourse.php?st_id=<?php echo $data['id'] ?>" class="btn btn-success mr-2 tip" data-tip="Assign to Course" ><i class="fas fa-book"></i></a>
                        <a href="/university/student/add.php?edit=<?php echo $data['id'] ?>" class="btn btn-warning tip" data-tip="Edit" ><i class="fas fa-edit"></i></a>
                <?php endif; ?>
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