<?php 
    include '../shared/config.php';
    include '../shared/header.php';
    include '../shared/nav.php';

    if(isset($_GET['delete'])){
        $id=$_GET['delete'];
        $delete = "DELETE FROM `doctor` WHERE `doctor`.`id` = $id";
        $deletedr = "DELETE FROM `drcourse` WHERE doctor_id = $id";
        $deleteAcc = "DELETE FROM `admin` WHERE `ref_id` = $id AND `userlevel` = 2";
        mysqli_query($connect,$deleteAcc);
        mysqli_query($connect,$deletedr);
        mysqli_query($connect,$delete);
    }
   
    $select = "SELECT doctor.* , admin.email From doctor LEFT JOIN admin On doctor.id = admin.ref_id AND admin.userLevel=2;";

    if(isset($_POST['searchKey'])){
        $serchName=strtolower($_POST['searchKey']);
        $select = "SELECT doctor.* , admin.email From doctor LEFT JOIN admin On doctor.id = admin.ref_id AND admin.userLevel=2 WHERE LOWER(doctor.name) LIKE '%$serchName%';";
    }

    $tData = mysqli_query($connect,$select);

?>


<div class="course container my-5">
    <div class="headline col-sm-12">
        <h1 class="col-sm-12"> Doctors </h1>
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
                    <th>doctor Name</th>
                    <th>doctor E-Mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tData as $data){?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $data['name'] ?></td>
                <?php if($data['email'] != "Please Enter Your E-mail"): ?>
                    <td><a href="mailto:<?php echo $data['email'] ?>"><?php echo $data['email'] ?></a></td>
                <?php else: ?>
                    <td><a><?php echo "Has no mail" ?></a></td>
                <?php endif; ?>
                    <td>
                <?php if($userLevel == 1): ?>
                        <a href="/university/doctor/view.php?delete= <?php echo $data['id'] ?>" class="btn btn-danger mr-2 tip" data-tip="Delete" >X</a>
                <?php endif; ?>
                        <a href="/university/doctor/profile.php?prof=<?php echo $data['id'] ?>" class="btn btn-info mr-2 tip" data-tip="Profile" ><i class="far fa-eye"></i></a>
                <?php if($userLevel == 1): ?>
                        <a href="/university/doctor/drcrs.php?add=<?php echo $data['id'] ?>" class="btn btn-success mr-2 tip" data-tip="Add Course" ><i class="fas fa-book"></i></a>
                        <a href="/university/doctor/add.php?edit=<?php echo $data['id'] ?>" class="btn btn-warning tip" data-tip="Edit" ><i class="fas fa-edit"></i></a>
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