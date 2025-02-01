<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
  
?>

<style>
.login-page {
    background: linear-gradient(135deg,rgb(233, 241, 255) 0%,rgb(235, 235, 235) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    transform: translateY(-20px);
    animation: slideUp 0.5s ease forwards;
}

@keyframes slideUp {
    to { transform: translateY(0); opacity: 1; }
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-header h1 {
    color: #1a1a1a;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.login-header p {
    color: #666;
    font-size: 0.95rem;
}

.form-group {
    margin-bottom: 1.8rem;
    position: relative;
}

.form-control {
    width: 100%;
    padding: 14px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #1e3c72;
    box-shadow: 0 0 8px rgba(30, 60, 114, 0.1);
}

.form-control::placeholder {
    color: #999;
}

.btn-login {
    width: 100%;
    padding: 14px;
    background: #1e3c72;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-login:hover {
    background: #2a5298;
    transform: translateY(-2px);
}

.input-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

.alert {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    font-size: 0.9rem;
}

@media (max-width: 480px) {
    .login-container {
        padding: 1.5rem;
    }
    
    .login-header h1 {
        font-size: 1.75rem;
    }
}
</style>

<div class="login-page">
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome To WMS </h1>
            <p>Administrator Access Only</p>
            <?php echo display_msg($msg); ?>
        </div>

        <form method="post" action="auth_v2.php" class="clearfix">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <i class="fa fa-user-circle input-icon"></i>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <i class="fa fa-lock input-icon"></i>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-login">Access System</button>
            </div>
        </form>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>