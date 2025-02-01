<?php
  $page_title = 'User Groups Management';
  require_once('includes/load.php');
  page_require_level(1);
  $all_groups = find_all('user_groups');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row" style="margin-top: 20px;">
  <div class="col-md-8 col-md-offset-2">
    <!-- Header Section -->
    <div class="text-center header-section">
      <h1 class="page-header">
        <span class="glyphicon glyphicon-user"></span>
        USER GROUPS MANAGEMENT
      </h1>
      <div class="header-actions">
        <a href="add_group.php" class="btn btn-success btn-lg">
          <span class="glyphicon glyphicon-plus"></span> ADD NEW GROUP
        </a>
      </div>
    </div>

    <!-- Groups Table -->
    <div class="panel panel-primary">
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-hover table-condensed">
            <thead>
              <tr class="active">
                <th class="text-center" style="width: 30%">Group Name</th>
                <th class="text-center" style="width: 20%">Group Level</th>
                <th class="text-center" style="width: 20%">Status</th>
                <th class="text-center" style="width: 30%">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($all_groups as $a_group): ?>
              <tr>
                <td class="text-center"><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
                <td class="text-center"><?php echo remove_junk(ucwords($a_group['group_level']))?></td>
                <td class="text-center">
                  <span class="label label-success status-label">
                    <?php echo ($a_group['group_status'] === '1') ? 'ACTIVE' : 'INACTIVE'; ?>
                  </span>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_group.php?id=<?php echo (int)$a_group['id'];?>" 
                       class="btn btn-warning btn-sm action-btn">
                      <span class="glyphicon glyphicon-edit"></span> Edit
                    </a>
                    <a href="delete_group.php?id=<?php echo (int)$a_group['id'];?>" 
                       class="btn btn-danger btn-sm action-btn">
                      <span class="glyphicon glyphicon-trash"></span> Delete
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Time Display -->
    <div class="time-display text-center">
      <div class="well well-sm">
        <strong>CURRENT TIME:</strong><br>
        <?php 
        $date = new DateTime('now', new DateTimeZone('Asia/Amman'));
        echo $date->format("F j, Y") . "<br>" . $date->format("g:i a");
        ?>
      </div>
    </div>
  </div>
</div>

<style>
  .page-header {
    margin: 30px 0;
    color: #2c3e50;
  }
  
  .header-actions {
    margin: 25px 0 40px;
  }
  
  .panel-primary {
    border-color: #3498db;
  }
  
  .panel-primary .panel-body {
    padding: 20px;
  }
  
  .status-label {
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 4px;
  }
  
  .action-btn {
    margin: 0 5px;
    padding: 6px 12px;
    border-radius: 3px;
    transition: all 0.3s ease;
  }
  
  .action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .time-display {
    margin: 30px 0;
    font-size: 16px;
    color: #7f8c8d;
  }
</style>

<?php include_once('layouts/footer.php'); ?>