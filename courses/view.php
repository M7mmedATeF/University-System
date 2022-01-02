<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    $select = "SELECT * FROM `course`";

    if(isset($_POST['searchKey'])){
        $serchName=strtolower($_POST['searchKey']);
        $select = "SELECT * FROM `course` WHERE LOWER(name) LIKE '%$serchName%';";
    }

    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
        $delete = "DELETE FROM `course` WHERE `course`.`id` = $id";
        $deletedr = "DELETE FROM `drcourse` WHERE `course`.`course_id` = $id";
        mysqli_query($connect,$deletedr);
        mysqli_query($connect,$delete);
    }
   
    $tData = mysqli_query($connect,$select);

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> All Courses </h1>
    </div>
    <div class="form col-sm-12">
        <form method="POST" class="search text-right col-sm-12">
            <input type="text" name="searchKey" class="input" placeholder="What are you searching For ?">
            <button type="submit" name="searchBTN" class="btn btn-info"><i class="fas fa-search"></i></button>
        </form>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Course Name</th>
                    <th>Course Hours</th>
                <?php if($userLevel == 1): ?>
                    <th>Actions</th>
                <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['name'] ?></td>
                    <td><?php echo $data['hours'] ?></td>
                <?php if($userLevel == 1): ?>
                    <td>
                        <a href="/university/courses/view.php?delete=<?php echo $data['id'] ?>" data-tip="Delete" class="btn btn-danger mr-2 tip">X</a>
                        <a href="/university/courses/add.php?edit=<?php echo $data['id'] ?>" data-tip="Edit" class="btn btn-warning tip"><i class="fas fa-edit"></i></a>
                    </td>
                <?php endif; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<?php 
    include '../shared/footer.php';
?>