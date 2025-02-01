<?php
$page_title = 'Home Page';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-home"></span>
                    <span>Welcome, <?php echo htmlspecialchars($user['name'] ?? 'User'); ?>!</span>
                </strong>
            </div>

            <div class="panel-body">
                <div class="row">
                    <!-- User Quick Overview -->
                    <div class="col-md-4">
                        <div class="card user-profile-card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="uploads/users/<?php echo !empty($user['image']) ? htmlspecialchars($user['image']) : 'default_avatar.png'; ?>"
                                        class="user-avatar img-circle"
                                        alt="User Avatar"
                                        style="width: 100px; height: 100px;">
                                    <h4><?php echo htmlspecialchars($user['name'] ?? 'User'); ?></h4>
                                    <p class="text-muted">
                                        Member since <?php
                                                        echo isset($user['created_at'])
                                                            ? format_date($user['created_at'])
                                                            : 'Unknown date'; ?>
                                    </p>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>