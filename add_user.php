<?php
  $page_title = 'Add User';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password','level' );
   validate_fields($req_fields);

   if(empty($errors)){
           $name   = remove_junk($db->escape($_POST['full-name']));
       $username   = remove_junk($db->escape($_POST['username']));
       $password   = remove_junk($db->escape($_POST['password']));
       $user_level = (int)$db->escape($_POST['level']);
       $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="name,username,password,user_level,status";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
        $query .=")";
        if($db->query($query)){
          //sucess
          $session->msg('s',"User account has been creted! ");
          redirect('add_user.php', false);
        } else {
          //failed
          $session->msg('d',' Sorry failed to create account!');
          redirect('add_user.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('add_user.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="auth-container">
        <div class="form-header">
          <h2><i class="glyphicon glyphicon-user"></i> Add New User</h2>
        </div>
        <div class="form-body">
          <form method="post" action="add_user.php" class="user-form">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" class="form-control" name="full-name" placeholder="Enter full name" required>
            </div>
            
            <div class="form-group">
              <label>Username</label>
              <input type="text" class="form-control" name="username" placeholder="Choose username" required>
            </div>
            
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="Create password" required>
            </div>
            
            <div class="form-group">
              <label>User Role</label>
              <select class="form-control" name="level" required>
                <?php foreach ($groups as $group): ?>
                <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
              </select>
            </div>
            
            <div class="form-group">
              <button type="submit" name="add_user" class="btn btn-primary btn-block">
                <i class="glyphicon glyphicon-plus"></i> Create User
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<style>
  .auth-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin: 30px 0;
    overflow: hidden;
  }

  .form-header {
    background: #2c3e50;
    padding: 25px;
    text-align: center;
  }

  .form-header h2 {
    color: #fff;
    margin: 0;
    font-size: 24px;
    font-weight: 500;
  }

  .form-header .glyphicon {
    margin-right: 10px;
    font-size: 22px;
  }

  .form-body {
    padding: 30px;
  }

  .user-form .form-control {
    height: 45px;
    border-radius: 5px;
    border: 1px solid #e0e0e0;
    padding: 10px 15px;
    font-size: 15px;
    transition: all 0.3s;
  }

  .user-form .form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 8px rgba(52,152,219,0.2);
  }

  .user-form label {
    font-weight: 500;
    color: #555;
    margin-bottom: 8px;
    display: block;
  }

  .btn-primary {
    background: #3498db;
    border: none;
    padding: 12px;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s;
  }

  .btn-primary:hover {
    background: #2980b9;
    transform: translateY(-1px);
  }

  .btn-block {
    margin-top: 20px;
  }

  @media (max-width: 768px) {
    .auth-container {
      margin: 20px 15px;
    }
    
    .form-body {
      padding: 25px;
    }
  }
</style>

<?php include_once('layouts/footer.php'); ?>