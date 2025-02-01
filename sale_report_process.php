<?php
$page_title = 'Sales Report';
$results = '';
require_once('includes/load.php');
page_require_level(3);

if(isset($_POST['submit'])) {
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        $results = find_sale_by_dates($start_date, $end_date);
    } else {
        $session->msg("d", $errors);
        redirect('sales_report.php', false);
    }
} else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
}
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sales Report - <?= date('Y-m-d') ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <style>
        @media print {
            html, body {
                font-size: 10pt;
                margin: 5mm;
            }
            .page-break {
                margin: 0;
                padding: 0;
                border: none;
            }
            .no-print, .btn {
                display: none !important;
            }
        }
        .report-header {
            margin: 30px 0;
            padding: 20px;
            border-bottom: 2px solid #333;
        }
        .table > thead > tr > th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table tbody tr td {
            vertical-align: middle;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .currency {
            text-align: right;
            min-width: 100px;
        }
        .print-button {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <?php if($results): ?>
        <div class="container-fluid">
            <div class="report-header text-center">
                <h2>Sales Report</h2>
                <h4><?= date('F j, Y', strtotime($start_date)) ?> to <?= date('F j, Y', strtotime($end_date)) ?></h4>
                <button onclick="window.print()" class="btn btn-primary print-button no-print">
                    <i class="glyphicon glyphicon-print"></i> Print Report
                </button>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th class="currency">Unit Cost</th>
                        <th class="currency">Unit Price</th>
                        <th>Qty Sold</th>
                        <th class="currency">Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    $total_cost = 0;
                    foreach($results as $result): 
                        $grand_total += $result['total_saleing_price'];
                        $total_cost += ($result['buy_price'] * $result['total_sales']);
                    ?>
                    <tr>
                        <td><?= date('M j, Y', strtotime($result['date'])) ?></td>
                        <td><?= ucwords($result['name']) ?></td>
                        <td class="currency">$<?= number_format($result['buy_price'], 2) ?></td>
                        <td class="currency">$<?= number_format($result['sale_price'], 2) ?></td>
                        <td><?= $result['total_sales'] ?></td>
                        <td class="currency">$<?= number_format($result['total_saleing_price'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4"></td>
                        <td>Total Sales:</td>
                        <td class="currency">$<?= number_format($grand_total, 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4"></td>
                        <td>Total Cost:</td>
                        <td class="currency">$<?= number_format($total_cost, 2) ?></td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4"></td>
                        <td>Net Profit:</td>
                        <td class="currency">$<?= number_format(($grand_total - $total_cost), 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="alert alert-danger">
                <strong>Notice:</strong> No sales found for the selected period.
            </div>
            <a href="sales_report.php" class="btn btn-default">Back to Report</a>
        </div>
    <?php endif; ?>

    <?php if(isset($db)) { $db->db_disconnect(); } ?>
</body>
</html>