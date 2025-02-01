<?php
  $page_title = 'All Sales';
  require_once('includes/load.php');
  page_require_level(3);
  $sales = find_all_sale();
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-10 col-md-offset-1"> <!-- Centered column -->
    <?php echo display_msg($msg); ?>
    
    <div class="panel panel-default">
      <div class="panel-heading text-left"> <!-- Centered heading -->
        <strong>
          <span class="glyphicon glyphicon-usd"></span>
          <span>SALES OVERVIEW</span>
          
        </strong>
        <div class="text-center" style="margin-top: 10px;"> <!-- Centered button -->
          <a href="add_sale.php" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus"></span> ADD NEW SALE
          </a>
        </div>
      </div>
      
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped center-table">
            <thead>
              <tr class="text-center">
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Product Name</th>
                <th style="width: 15%;">Quantity</th>
                <th style="width: 15%;">Total Price</th>
                <th style="width: 20%;">Date</th>
                <th style="width: 20%;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sales as $sale): ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk($sale['name']); ?></td>
                <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
                <td class="text-center"><?php echo $sale['date']; ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>" 
                       class="btn btn-warning btn-xs">
                       <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>" 
                       class="btn btn-danger btn-xs">
                       <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <div class="panel-footer text-center"> <!-- Centered footer -->
        <strong>Total Sales: <?php echo count($sales); ?> transactions</strong>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>