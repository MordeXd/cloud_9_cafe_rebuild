<?php
session_start();
// Check if user is logged in using cafe_user_id
if (!isset($_SESSION['cafe_user_id'])) {
    header("Location: login.php");
    exit();
}
$title = "Edit Profile - Cloud 9 Cafe";
$active_sidebar = 'profile';
ob_start();
?>
<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }

    .profile-image-preview {
        width: 150px;
        height: 150px;
        border-radius: 3px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="card border-0 shadow-lg mb-4">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold mb-0" style="color: #667eea;">Edit Profile</h2>
            <a href="profile.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>

        <form>
            <!-- Profile Image -->
            <div class="text-center mb-5">
                <div class="position-relative d-inline-block">
                    <img src="../assets/images/profile_pictures/default.png" alt="Profile" class="profile-image-preview"
                        id="profilePreview">
                    <label for="profileImageInput"
                        class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="profileImageInput" hidden accept="image/*">
                </div>
                <p class="text-muted small mt-2">Click the camera icon to change photo</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">First Name</label>
                    <input type="text" class="form-control form-control-lg bg-light border-0" value="John">
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Last Name</label>
                    <input type="text" class="form-control form-control-lg bg-light border-0" value="Doe">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" class="form-control form-control-lg bg-light border-0"
                    value="john.doe@example.com">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="tel" class="form-control form-control-lg bg-light border-0" value="+1 234 567 890">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" class="form-control form-control-lg bg-light border-0" value="1990-01-01">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Gender</label>
                <select class="form-select form-select-lg bg-light border-0">
                    <option value="male" selected>Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Address</label>
                <textarea class="form-control p-3 bg-light border-0" id="address" name="address" rows="3"
                    placeholder="Enter your address">123 Street Name, Apt 4B, New York, NY 10001</textarea>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-gradient btn-lg px-5">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
                <button type="reset" class="btn btn-cancel btn-lg px-5">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview uploaded image
    document.getElementById('profileImageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?php
$dashboard_content = ob_get_clean();
include '../includes/dashboard_layout.php';
?>
