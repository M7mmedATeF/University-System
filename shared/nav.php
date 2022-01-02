<?php include '../shared/config.php';
      session_start();

  if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
  }else{
    header("location: /university/");
  }

  $counter = 1;

  $select = "SELECT * FROM `admin` WHERE id=$id";
  $row = mysqli_query($connect,$select);
  $data = mysqli_fetch_assoc($row);
  $userLevel = $data['userLevel'];
  $key = $data['ref_id'];
  $login_data = $data;

  echo $userLevel;
  
  if($userLevel == 1){
    $img = "/university/assets/admin.png";
  }else if($userLevel == 2){
    $select = "SELECT * FROM `doctor` WHERE id=$key";
    $row = mysqli_query($connect,$select);
    $drdata = mysqli_fetch_assoc($row);
    $login_data = $drdata;
    $img = "/university/doctor/uploads/" . $drdata['img'];
  }else{
    $select = "SELECT * FROM `student` WHERE id=$key";
    $row = mysqli_query($connect,$select);
    $stdata = mysqli_fetch_assoc($row);
    $login_data = $stdata;
    $img = "/university/student/uploads/" . $stdata['img'];
  }


  if(isset($_POST['logout'])){
    session_destroy();
    $logout = "UPDATE `admin` SET `isConnected` = '0' WHERE `admin`.`id` = $id";
    mysqli_query($connect,$logout);
    header("location: /university/");
  }

  function nameCut($name){
    if(strlen($name) > 13)
      return substr($name, 0, 13)."...";
    else
      return $name;
  }
?>

<nav>
  <div class="col-md-3 logo">
    <h1><i class="fas fa-laptop-code"></i>FCIS</h1>
  </div>

  <div class="col-md-6 links">
    <ul>
      <li> Courses
        <ul>
          <li> <a href="/university/courses/view.php">All Courses</a> </li>
    <?php if($userLevel == 1): ?>
          <li> <a href="/university/courses/add.php">Add Course</a> </li>
    <?php endif; ?>
    <?php if($userLevel == 3): ?>
          <li> <a href="/university/regCourse/regcourse.php">Ask for Course</a> </li>
    <?php endif; ?>
        </ul>
      </li>
      <li> Doctor
        <ul>
          <li> <a href="/university/doctor/view.php">All Doctors</a> </li>
    <?php if($userLevel == 1): ?>
          <li> <a href="/university/doctor/add.php">Add Doctor</a> </li>
    <?php endif; ?>
        </ul>
      </li>
      <li> Student
        <ul>
          <li> <a href="/university/student/view.php">All Students</a> </li>
    <?php if($userLevel == 1): ?>
          <li> <a href="/university/student/add.php">Add Student</a> </li>
    <?php endif; ?>
        </ul>
      </li>
    <?php if($userLevel < 3 ): ?>
      <li> <a href="/university/degrees/view.php" class="admins">Add Degrees</a> </li>
      <li><a href="/university/regCourse/dracept.php" class="admins">Course Registration</a></li>
    <?php endif; ?>
      </li>
    <?php if($userLevel == 1): ?>
      <li></li>
      <li> Admins
        <ul>
          <li> <a href="/university/admin/view.php">All Admins</a> </li>
          <li> <a href="/university/admin/account.php?addAcc=true">Add Admin</a> </li>
        </ul>
      </li>
    <?php endif; ?>
    </ul>
  </div>

  <div class="col-md-3 connected">
    <ul>
      <li> <div class="col-sm-12"> <span> Hello <?php if($userLevel != 1) {echo nameCut($login_data['name']);}else{echo $login_data['username'];} ?> <img src="<?php {echo $img; } ?>" alt="<?php echo $login_data['name'] ?>"> </span> </div>
        <ul>
        <?php if($userLevel == 3): ?>
          <li> <a href="/university/student/profile.php?prof=<?php echo $key ?>">My Profile</a> </li>
        <?php endif; ?>
          <li> <a href="/university/admin/account.php">Edit Account</a> </li>
        <?php if($userLevel == 2): ?>
          <li> <a href="/university/doctor/add.php?editprof=true">Edit Profile</a> </li>
        <?php endif; ?>
        <?php if($userLevel == 3 || $userLevel == 4): ?>
          <li> <a href="/university/student/add.php?editprof=true">Edit Profile</a> </li>
        <?php endif; ?>
          
          <li><form method="POST"> <button class="logout" name="logout" type="submit">Logout</button></form></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>