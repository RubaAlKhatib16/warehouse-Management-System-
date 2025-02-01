<?php
$page_title = 'User Management';
require_once('includes/load.php');
page_require_level(1);
$all_users = find_all_user();
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading clearfix text-center">
        <div style="margin-bottom: 15px;">
          <h2 class="panel-title">
            <span class="glyphicon glyphicon-user"></span>
            User Management
          </h2>
        </div>
        <a href="add_user.php" class="btn btn-primary btn-lg">
          <span class="glyphicon glyphicon-plus"></span> Add New User
        </a>
      </div>

      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-hover table-condensed">
            <thead class="bg-primary">
              <tr>
                <th class="text-center">#</th>
                <th>Name</th>
                <th>Username</th>
                <th class="text-center">Role</th>
                <th class="text-center">Status</th>
                <th class="text-center">Last Login</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_users as $a_user): ?>
                <tr>
                  <td class="text-center"><?php echo count_id(); ?></td>
                  <td><?php echo remove_junk(ucwords($a_user['name'])) ?></td>
                  <td><?php echo remove_junk(ucwords($a_user['username'])) ?></td>
                  <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])) ?></td>
                  <td class="text-center">
                    <span class="label <?php echo ($a_user['status'] === '1') ? 'label-success' : 'label-danger'; ?> status-label">
                      <?php echo ($a_user['status'] === '1') ? "Active" : "Inactive"; ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <?php

                    $date = new DateTime($a_user['last_login'], new DateTimeZone('UTC'));
                    $date->setTimezone(new DateTimeZone('Asia/Amman'));
                    echo $date->format('M j, Y g:i A');
                    ?>
                  </td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_user.php?id=<?php echo (int)$a_user['id']; ?>"
                        class="btn btn-warning btn-sm action-btn"
                        data-toggle="tooltip"
                        title="Edit">
                        <i class="glyphicon glyphicon-edit"></i>
                      </a>
                      <a href="delete_user.php?id=<?php echo (int)$a_user['id']; ?>"
                        class="btn btn-danger btn-sm action-btn"
                        data-toggle="tooltip"
                        title="Delete">
                        <i class="glyphicon glyphicon-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .panel-title {
    font-size: 24px;
    color: #2c3e50;
    padding: 10px 0;
  }

  .table-condensed thead.bg-primary th {
    background-color: #3498db;
    color: white;
    font-size: 15px;
    border-bottom: 2px solid #2980b9;
  }

  .status-label {
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    min-width: 80px;
    display: inline-block;
  }

  .action-btn {
    margin: 0 3px;
    padding: 6px 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
  }

  .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .table-hover tbody tr:hover {
    background-color: #f5f6fa;
  }
</style>

<?php include_once('layouts/footer.php'); ?>