<?php
session_start();
// Check if user is logged in using cafe_user_id
if (!isset($_SESSION['cafe_user_id'])) {
    header("Location: login.php");
    exit();
}
$title = "Saved Addresses - Cloud 9 Cafe";
$active_sidebar = 'addresses';
ob_start();
?>
<style>
    .address-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .address-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="card border-0 shadow-lg mb-4">
    <div class="card-body p-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="fw-bold mb-0" style="color: #667eea;">Saved Addresses</h2>
            <button class="btn btn-gradient rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                <i class="fas fa-plus me-2"></i>Add New Address
            </button>
        </div>

        <div class="row g-4">
            <!-- Address 1 -->
            <div class="col-md-6">
                <div class="card h-100 border shadow-sm address-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Home</span>
                                <h5 class="fw-bold mb-1">John Doe</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal"><i class="fas fa-edit me-2"></i>Edit</a>
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class="fas fa-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted mb-2">123 Street Name, Apt 4B</p>
                        <p class="text-muted mb-2">New York, NY 10001</p>
                        <p class="text-muted mb-3">United States</p>
                        <p class="mb-0"><i class="fas fa-phone me-2 text-muted"></i>+1 234 567 890</p>
                    </div>
                </div>
            </div>

            <!-- Address 2 -->
            <div class="col-md-6">
                <div class="card h-100 border shadow-sm address-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">Work</span>
                                <h5 class="fw-bold mb-1">John Doe</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal"><i class="fas fa-edit me-2"></i>Edit</a>
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class="fas fa-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted mb-2">456 Office Plaza, Suite 200</p>
                        <p class="text-muted mb-2">New York, NY 10002</p>
                        <p class="text-muted mb-3">United States</p>
                        <p class="mb-0"><i class="fas fa-phone me-2 text-muted"></i>+1 234 567 891</p>
                    </div>
                </div>
            </div>

            <!-- Address 3 -->
            <div class="col-md-6">
                <div class="card h-100 border shadow-sm address-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-warning bg-opacity-10 text-warning mb-2">Other</span>
                                <h5 class="fw-bold mb-1">John Doe</h5>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#editAddressModal"><i class="fas fa-edit me-2"></i>Edit</a>
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                class="fas fa-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="text-muted mb-2">789 Beach Road, Villa 5</p>
                        <p class="text-muted mb-2">Miami, FL 33101</p>
                        <p class="text-muted mb-3">United States</p>
                        <p class="mb-0"><i class="fas fa-phone me-2 text-muted"></i>+1 234 567 892</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter full name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" placeholder="Enter phone number">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 1</label>
                        <input type="text" class="form-control" placeholder="Street address, P.O. box">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 2</label>
                        <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc.">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control" placeholder="City">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control" placeholder="State">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">ZIP Code</label>
                            <input type="text" class="form-control" placeholder="ZIP">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Type</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="addressType" id="homeType"
                                    checked>
                                <label class="form-check-label" for="homeType">Home</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="addressType" id="workType">
                                <label class="form-check-label" for="workType">Work</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="addressType" id="otherType">
                                <label class="form-check-label" for="otherType">Other</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100">Save Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Edit Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" value="+1 234 567 890">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 1</label>
                        <input type="text" class="form-control" value="123 Street Name, Apt 4B">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 2</label>
                        <input type="text" class="form-control" value="">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" class="form-control" value="New York">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" class="form-control" value="NY">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">ZIP Code</label>
                            <input type="text" class="form-control" value="10001">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Type</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="editAddressType" id="editHomeType"
                                    checked>
                                <label class="form-check-label" for="editHomeType">Home</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="editAddressType" id="editWorkType">
                                <label class="form-check-label" for="editWorkType">Work</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="editAddressType"
                                    id="editOtherType">
                                <label class="form-check-label" for="editOtherType">Other</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100">Update Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$dashboard_content = ob_get_clean();
include '../includes/dashboard_layout.php';
?>
