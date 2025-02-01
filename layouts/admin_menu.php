<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  <ul>
  <li>
    <a href="admin.php">
      <i class="fa fa-home"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle" aria-expanded="false">
      <i class="fa fa-users"></i>
      <span>User Management</span>
      <span class="caret"></span>
    </a>
    <ul class="nav submenu">
      <li><a href="group.php">Manage Groups</a></li>
      <li><a href="users.php">Manage Users</a></li>
    </ul>
  </li>
  <li>
    <a href="categorie.php">
      <i class="fa fa-list-alt"></i>
      <span>Categories</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle" aria-expanded="false">
      <i class="fa fa-cubes"></i>
      <span>Products</span>
      <span class="caret"></span>
    </a>
    <ul class="nav submenu">
      <li><a href="product.php">Manage Products</a></li>
      <li><a href="add_product.php">Add Product</a></li>
    </ul>
  </li>
  <li>
    <a href="media.php">
      <i class="fa fa-picture-o"></i>
      <span>Media</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle" aria-expanded="false">
      <i class="fa fa-shopping-cart"></i>
      <span>Sales</span>
      <span class="caret"></span>
    </a>
    <ul class="nav submenu">
      <li><a href="sales.php">Manage Sales</a></li>
      <li><a href="add_sale.php">Add Sale</a></li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle" aria-expanded="false">
      <i class="fa fa-line-chart"></i>
      <span>Sales Report</span>
      <span class="caret"></span>
    </a>
    <ul class="nav submenu">
      <li><a href="sales_report.php">Sales by Dates</a></li>
      <li><a href="monthly_sales.php">Monthly Sales</a></li>
      <li><a href="daily_sales.php">Daily Sales</a></li>
    </ul>
  </li>
</ul>
</body>
</html>