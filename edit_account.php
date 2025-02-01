<?php
$page_title = 'Profile Settings';
require_once('includes/load.php');
page_require_level(3);

// Get current user data
$user = current_user();
if (!$user) {
    $session->msg('d', 'User not found!');
    redirect('index.php');
}

// Handle profile photo update
if(isset($_POST['update_photo'])) {
    $upload_dir = 'uploads/users/';
    
    // Create directory if not exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Validate file
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size = 1 * 1024 * 1024; // 1MB
    $file = $_FILES['profile_photo'];

    try {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $file['error']);
        }

        // Verify file type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, $allowed_types)) {
            throw new Exception('Invalid file type. Only JPG/PNG allowed');
        }

        // Verify file size
        if ($file['size'] > $max_size) {
            throw new Exception('File size exceeds 1MB limit');
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = "user_{$user['id']}_" . time() . ".$ext";
        $target_path = $upload_dir . $new_filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Delete old image if not default
            if ($user['image'] !== 'default.jpg' && file_exists($upload_dir . $user['image'])) {
                unlink($upload_dir . $user['image']);
            }

            // Update database
            $db->query("UPDATE users SET image = '{$db->escape($new_filename)}' WHERE id = '{$user['id']}'");
            
            // Refresh user data
            $user = current_user(true);
            $session->msg('s', 'Profile photo updated successfully');
        } else {
            throw new Exception('Failed to move uploaded file');
        }
    } catch (Exception $e) {
        $session->msg('d', $e->getMessage());
    }
    redirect('edit_account.php');
}
?>
<?php include_once('layouts/header.php'); ?>
<link rel="stylesheet" href="libs/css/security-settings.css">

<div class="security-container">
<!-- Profile Photo Section -->
<div class="profile-photo-card">
    <div class="photo-header">
        <h2><i class="bi bi-person-bounding-box"></i> Profile Photo</h2>
        <p class="photo-info">Recommended size: 500x500 pixels (JPG, PNG, Max 1MB)</p>
    </div>
    
    <div class="profile-image-container">
        <img src="uploads/users/<?= htmlspecialchars($user['image'] ?? 'default.jpg') ?>" 
             alt="Profile Photo"
             class="profile-image img-fluid rounded-circle"
             id="profileImage">
        <div class="upload-overlay">
            <i class="bi bi-camera"></i>
        </div>
    </div>
    
    <form method="post" enctype="multipart/form-data" class="photo-form">
        <div class="upload-group">
            <input type="file" 
                   name="profile_photo" 
                   id="photoInput"
                   accept="image/jpeg, image/png"
                   class="upload-input">
            <label for="photoInput" class="btn btn-upload">
                <i class="bi bi-cloud-arrow-up"></i> Choose New Photo
            </label>
            <button type="submit" name="update_photo" class="btn btn-save">
                <i class="bi bi-save"></i> Save Changes
            </button>
        </div>
        <div id="fileFeedback" class="mt-2"></div>
    </form>
</div>

<!-- Rest of your security settings code -->
</div>
    <div class="security-card">
        <!-- Security Header -->
        <div class="security-header">
            <i class="bi bi-shield-lock"></i>
            <h1>Account Security</h1>
            <p class="last-login">Last login: <?= format_date($user['last_login']) ?></p>
        </div>

        <!-- Password Update Section -->
        <div class="security-section">
            <h2 class="section-title">Password Management</h2>
            
            <form method="post" class="security-form">
                <!-- Current Password -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-lock-fill"></i> Current Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control"
                               name="current_password"
                               required
                               placeholder="••••••••">
                        <span class="input-icon">
                            <i class="bi bi-eye-slash password-toggle"></i>
                        </span>
                    </div>
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-key-fill"></i> New Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control"
                               name="new_password"
                               minlength="8"
                               required
                               placeholder="••••••••"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        <span class="input-icon">
                            <i class="bi bi-eye-slash password-toggle"></i>
                        </span>
                    </div>
                    <div class="password-rules">
                        <p class="rule"><i class="bi bi-check-circle"></i> Minimum 8 characters</p>
                        <p class="rule"><i class="bi bi-check-circle"></i> At least one uppercase letter</p>
                        <p class="rule"><i class="bi bi-check-circle"></i> At least one number</p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="bi bi-key-fill"></i> Confirm Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-control"
                               name="confirm_password"
                               required
                               placeholder="••••••••">
                        <span class="input-icon">
                            <i class="bi bi-eye-slash password-toggle"></i>
                        </span>
                    </div>
                    <div class="password-match-indicator">
                        <span class="match-icon"></span>
                        <span class="match-text"></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-security">
                    <i class="bi bi-shield-check"></i> Update Security Settings
                </button>
            </form>
        </div>

        <!-- Security Status -->
        <div class="security-status">
            <div class="status-item">
                <i class="bi bi-patch-check-fill text-success"></i>
                <span>Two-Factor Authentication: Enabled</span>
            </div>
            <div class="status-item">
                <i class="bi bi-clock-history"></i>
                <span>Password last changed: 3 months ago</span>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced Password Validation
document.addEventListener('DOMContentLoaded', () => {
    const newPassword = document.querySelector('input[name="new_password"]');
    const confirmPassword = document.querySelector('input[name="confirm_password"]');
    const strengthIndicator = document.querySelector('.password-strength');
    
    newPassword.addEventListener('input', updatePasswordStrength);
    confirmPassword.addEventListener('input', checkPasswordMatch);

    function updatePasswordStrength() {
        const strength = calculateStrength(this.value);
        strengthIndicator.style.width = `${strength}%`;
        strengthIndicator.style.backgroundColor = getStrengthColor(strength);
    }

    function checkPasswordMatch() {
        const matchDiv = document.querySelector('.password-match-indicator');
        const icon = matchDiv.querySelector('.match-icon');
        const text = matchDiv.querySelector('.match-text');
        
        if(this.value === newPassword.value && this.value.length > 0) {
            icon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
            text.textContent = 'Passwords match';
        } else {
            icon.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
            text.textContent = 'Passwords do not match';
        }
    }
});

// Real-time Image Preview and Validation
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = this.files[0];
    const feedback = document.getElementById('fileFeedback');
    const imgPreview = document.getElementById('profileImage');
    
    feedback.innerHTML = '';
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            feedback.innerHTML = `<div class="alert alert-danger">Invalid file type. Only JPG/PNG allowed</div>`;
            this.value = '';
            return;
        }

        // Validate file size
        if (file.size > 1048576) { // 1MB
            feedback.innerHTML = `<div class="alert alert-danger">File size exceeds 1MB limit</div>`;
            this.value = '';
            return;
        }

        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            imgPreview.src = e.target.result;
            feedback.innerHTML = `<div class="alert alert-success">Ready to upload (${(file.size/1024).toFixed(1)}KB)</div>`;
        }
        reader.readAsDataURL(file);
    }
});

</script>

<?php include_once('layouts/footer.php'); ?>