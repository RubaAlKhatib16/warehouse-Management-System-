<?php
  $page_title = 'Admin Dashboard';
  require_once('includes/load.php');
  page_require_level(1);
?>

<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="libs/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include_once('layouts/header.php'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <?php echo display_msg($msg); ?>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row dashboard-summary">
    <div class="col-md-3 col-sm-6">
      <div class="card summary-card user-card">
        <div class="card-body">
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="content">
            <h2><?php echo $c_user['total']; ?></h2>
            <p>Users</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card summary-card category-card">
        <div class="card-body">
          <div class="icon">
            <i class="fas fa-tags"></i>
          </div>
          <div class="content">
            <h2><?php echo $c_categorie['total']; ?></h2>
            <p>Categories</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card summary-card product-card">
        <div class="card-body">
          <div class="icon">
            <i class="fas fa-box-open"></i>
          </div>
          <div class="content">
            <h2><?php echo $c_product['total']; ?></h2>
            <p>Products</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3 col-sm-6">
      <div class="card summary-card sales-card">
        <div class="card-body">
          <div class="icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="content">
            <h2><?php echo $c_sale['total']; ?></h2>
            <p>Sales</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Analytics Section -->
  <div class="row analytics-section">
    <!-- Top Products -->
    <div class="col-lg-4 col-md-6">
      <div class="card analytic-card">
        <div class="card-header">
          <h4><i class="fas fa-fire"></i> Top Selling Products</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="thead-light">
                <tr>
                  <th>Product</th>
                  <th class="text-right">Sold</th>
                  <th class="text-right">Qty</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products_sold as $product_sold): ?>
                <tr>
                  <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                  <td class="text-right"><?php echo (int)$product_sold['totalSold']; ?></td>
                  <td class="text-right"><?php echo (int)$product_sold['totalQty']; ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Sales -->
    <div class="col-lg-4 col-md-6">
      <div class="card analytic-card">
        <div class="card-header">
          <h4><i class="fas fa-clock"></i> Recent Transactions</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Product</th>
                  <th class="text-right">Amount</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_sales as $recent_sale): ?>
                <tr>
                  <td><?php echo count_id(); ?></td>
                  <td>
                    <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>" class="text-primary">
                      <?php echo remove_junk(first_character($recent_sale['name'])); ?>
                    </a>
                  </td>
                  <td class="text-right">$<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
                  <td><?php echo date('M d, Y', strtotime($recent_sale['date'])); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- New Products -->
    <div class="col-lg-4 col-md-12">
      <div class="card analytic-card">
        <div class="card-header">
          <h4><i class="fas fa-cube"></i> New Arrivals</h4>
        </div>
        <div class="card-body">
          <div class="list-group">
            <?php foreach ($recent_products as $recent_product): ?>
            <a href="edit_product.php?id=<?php echo (int)$recent_product['id']; ?>" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center">
                <div class="product-thumb">
                  <?php if ($recent_product['media_id'] === '0'): ?>
                    <img src="uploads/products/no_image.jpg" alt="Product">
                  <?php else: ?>
                    <img src="uploads/products/<?php echo $recent_product['image']; ?>" alt="Product">
                  <?php endif; ?>
                </div>
                <div class="ml-3">
                  <h6 class="mb-1"><?php echo remove_junk(first_character($recent_product['name'])); ?></h6>
                  <small class="text-muted"><?php echo remove_junk(first_character($recent_product['categorie'])); ?></small>
                </div>
                <div class="ml-auto">
                  <span class="badge badge-primary">$<?php echo (int)$recent_product['sale_price']; ?></span>
                </div>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<style>
  .dashboard-summary {
    margin-bottom: 30px;
  }

  .summary-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    transition: transform 0.3s ease;
  }

  .summary-card:hover {
    transform: translateY(-5px);
  }

  .summary-card .card-body {
    display: flex;
    align-items: center;
    padding: 25px;
  }

  .summary-card .icon {
    font-size: 2.5rem;
    margin-right: 20px;
  }

  .summary-card .content h2 {
    margin: 0;
    font-weight: 700;
    color: #2c3e50;
  }

  .analytic-card {
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .analytic-card .card-header {
    background: #ffffff;
    border-bottom: 2px solid #f8f9fa;
    padding: 15px 20px;
  }

  .analytic-card .card-header h4 {
    margin: 0;
    font-size: 1.1rem;
    color: #34495e;
  }

  .product-thumb {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
  }

  .product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .list-group-item {
    border: none;
    border-bottom: 1px solid #f8f9fa;
    padding: 15px;
  }
</style>
</body>
</html>