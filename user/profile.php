<?php
session_start();
// Check if user is logged in using cafe_user_id
if (!isset($_SESSION['cafe_user_id'])) {
    header("Location: login.php");
    exit();
}
$title = "My Profile - Cloud 9 Cafe";
$active_sidebar = 'profile';
ob_start();
?>
<style>
    .profile-header-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.0));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        border-radius: 20px;
        overflow: hidden;
    }

    .profile-cover {
        height: 200px;
        background: var(--primary-gradient);
        position: relative;
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.8);
        position: absolute;
        bottom: -75px;
        left: 50px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-stats {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
        backdrop-filter: blur(5px);
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8);
    }

    .info-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .edit-btn {
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: #667eea;
        border: none;
        transition: all 0.3s ease;
    }

    .edit-btn:hover {
        background: white;
        transform: scale(1.05);
    }

    .edit-icon {
        width: 40px;
        height: 40px;
        border-radius: 3px;
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-icon:hover {
        background: #667eea;
        color: white;
    }

    .profile-info-row {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .profile-info-row:last-child {
        border-bottom: none;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
</style>

<div class="profile-header-card mb-4">
    <div class="profile-cover">
        <div class="profile-avatar">
            <img src="../assets/images/profile_pictures/default.png" alt="Profile" id="profileImage">
            <div class="edit-icon position-absolute bottom-0 end-0 m-2" onclick="document.getElementById('profileInput').click()">
                <i class="fas fa-camera"></i>
            </div>
            <input type="file" id="profileInput" hidden accept="image/*">
        </div>
    </div>
    <div class="p-4 pt-5">
        <div class="row align-items-end">
            <div class="col-md-6">
                <h3 class="fw-bold mb-1">John Doe</h3>
                <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>john.doe@example.com</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="profile-stats d-inline-flex gap-4">
                    <div class="stat-item">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Orders</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Addresses</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white/50 backdrop-blur">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-user-circle me-2" style="color: #667eea;"></i>Personal Information
                </h5>
                <button class="edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-pen me-2"></i>Edit
                </button>
            </div>

            <div class="profile-info-row">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Full Name</span>
                    <span class="fw-semibold">John Doe</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Email</span>
                    <span class="fw-semibold">john.doe@example.com</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Phone</span>
                    <span class="fw-semibold">+1 234 567 890</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Date of Birth</span>
                    <span class="fw-semibold">Jan 1, 1990</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Gender</span>
                    <span class="fw-semibold">Male</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-4">
                <i class="fas fa-shield-alt me-2" style="color: #667eea;"></i>Account Security
            </h5>

            <div class="d-flex align-items-center p-3 mb-3 rounded-3" style="background: rgba(102, 126, 234, 0.05);">
                <div class="flex-shrink-0">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(102, 126, 234, 0.1);">
                        <i class="fas fa-lock" style="color: #667eea;"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="fw-bold mb-0">Password</h6>
                    <p class="text-muted small mb-0">Last changed 3 months ago</p>
                </div>
                <a href="change_password.php" class="btn btn-outline-primary btn-sm rounded-pill">Change</a>
            </div>

            <div class="d-flex align-items-center p-3 mb-3 rounded-3" style="background: rgba(102, 126, 234, 0.05);">
                <div class="flex-shrink-0">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(102, 126, 234, 0.1);">
                        <i class="fas fa-mobile-alt" style="color: #667eea;"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="fw-bold mb-0">Two-Factor Auth</h6>
                    <p class="text-muted small mb-0">Not enabled</p>
                </div>
                <button class="btn btn-outline-primary btn-sm rounded-pill">Enable</button>
            </div>

            <div class="d-flex align-items-center p-3 rounded-3" style="background: rgba(102, 126, 234, 0.05);">
                <div class="flex-shrink-0">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(102, 126, 234, 0.1);">
                        <i class="fas fa-history" style="color: #667eea;"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="fw-bold mb-0">Login History</h6>
                    <p class="text-muted small mb-0">Last login: Today, 10:30 AM</p>
                </div>
                <button class="btn btn-link text-decoration-none" style="color: #667eea;">View</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editProfileForm">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="../assets/images/profile_pictures/default.png" alt="Profile" class="rounded-circle" style="width: 150px; height: 150px; border: 4px solid #f8f9fa;">
                            <button type="button" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0" style="width: 40px; height: 40px;">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control form-control-lg" value="John Doe">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control form-control-lg" value="john.doe@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="tel" class="form-control form-control-lg" value="+1 234 567 890">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date of Birth</label>
                        <input type="date" class="form-control form-control-lg" value="1990-01-01">
                    </div>
                    <button type="submit" class="btn btn-gradient w-100 btn-lg">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$dashboard_content = ob_get_clean();
include '../includes/dashboard_layout.php';
?>
