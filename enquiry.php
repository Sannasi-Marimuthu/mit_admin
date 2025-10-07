<?php

include_once('connection_db.php');

// Handle form submissions (same as before)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_enquiry'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phno = $_POST['phno'];
        $education = $_POST['education'];
        $course_or_placement = $_POST['course_or_placement'];
        $joining_date = $_POST['joining_date'];
        $ref_name = $_POST['ref_name'];
        $ref_phno = $_POST['ref_phno'];

        $sql = "INSERT INTO enquiries (first_name, last_name, email, dob, phno, education, course_or_placement, joining_date, ref_name, ref_phno) 
                VALUES ('$first_name', '$last_name', '$email', '$dob', '$phno', '$education', '$course_or_placement', '$joining_date', '$ref_name', '$ref_phno')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Enquiry added successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if (isset($_POST['update_enquiry'])) {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phno = $_POST['phno'];
        $education = $_POST['education'];
        $course_or_placement = $_POST['course_or_placement'];
        $joining_date = $_POST['joining_date'];
        $ref_name = $_POST['ref_name'];
        $ref_phno = $_POST['ref_phno'];

        $sql = "UPDATE enquiries SET 
                first_name='$first_name', last_name='$last_name', email='$email', 
                dob='$dob', phno='$phno', education='$education', 
                course_or_placement='$course_or_placement', joining_date='$joining_date', 
                ref_name='$ref_name', ref_phno='$ref_phno' 
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Enquiry updated successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM enquiries WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Enquiry deleted successfully!";
    } else {
        $error_message = "Error deleting record: " . $conn->error;
    }
}

// Fetch enquiries (same as before)
$sql = "SELECT * FROM enquiries";
$result = $conn->query($sql);
$enquiries = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $enquiries[] = $row;
    }
}

$edit_enquiry = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM enquiries WHERE id=$edit_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $edit_enquiry = $result->fetch_assoc();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MIT</title>
	
	<meta name="description" content="SmartHR - An advanced Bootstrap 5 admin dashboard template for HRM and CRM. Ideal for managing employee records, payroll, attendance, recruitment, and team performance with an intuitive and responsive design. Perfect for HR teams and business managers looking to streamline workforce management.">
	<meta name="keywords" content="HR dashboard template, HRM admin template, Bootstrap 5 HR dashboard, workforce management dashboard, employee management system, payroll dashboard, HR analytics, admin dashboard, CRM admin template, human resources management, HR admin template, team management dashboard, recruitment dashboard, employee attendance system, performance management, HR CRM, HR dashboard HTML, Bootstrap HR template, employee engagement, HR software, project management dashboard">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Favicon -->
	<link rel="icon" href="assets/img/favicon.png" type="image/x-icon">
	<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

	<!-- Theme Script js -->
	<script src="assets/js/theme-script.js"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="assets/plugins/icons/feather/feather.css">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Bootstrap Tagsinput CSS -->
	<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="assets/plugins/summernote/summernote-lite.min.css">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="assets/plugins/flatpickr/flatpickr.min.css">
	<link rel="stylesheet" href="assets/plugins/%40simonwep/pickr/themes/nano.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div id="global-loader" style="display: none;">
        <div class="page-loader"></div>
    </div>

    <div class="main-wrapper">
        <?php 
        include_once('header.php'); 
        include_once('sidebar.php');
        ?>
        <div class="page-wrapper">
            <div class="content">
                <!-- Breadcrumb -->
                <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
                    <div class="my-auto mb-2">
                        <h2 class="mb-1">Enquiry</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="ti ti-smart-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">Enquiry</li>
                                <li class="breadcrumb-item active" aria-current="page">Enquiry List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
                        <div class="me-2 mb-2">
                            <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                                <a href="javascript:void(0)" class="btn btn-icon btn-sm active bg-primary text-white me-1">
                                    <i class="ti ti-list-tree"></i>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-icon btn-sm">
                                    <i class="ti ti-layout-grid"></i>
                                </a>
                            </div>
                        </div>
                        <div class="me-2 mb-2">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="ti ti-file-export me-1"></i>Export
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-pdf me-1"></i>Export as PDF</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1"><i class="ti ti-file-type-xls me-1"></i>Export as Excel</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_enquiry" class="btn btn-primary d-flex align-items-center">
                                <i class="ti ti-circle-plus me-2"></i>Add Enquiry
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Breadcrumb -->

                <!-- Success/Error Messages -->
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Total Enquiries -->
                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <div>
                                        <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                                    </div>
                                    <div class="ms-2 overflow-hidden">
                                        <p class="fs-12 fw-medium mb-1 text-truncate">Total Enquiries</p>
                                        <h4><?php echo count($enquiries); ?></h4>
                                    </div>
                                </div>
                                <div>                                    
                                    <span class="badge badge-soft-purple badge-sm fw-normal">
                                        <i class="ti ti-arrow-wave-right-down"></i>
                                        +19.01%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Total Enquiries -->
                </div>

                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5>Enquiry List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="enquiryTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            <div class="form-check form-check-md">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Education</th>
                                        <th>Course/Placement</th>
                                        <th>Joining Date</th>
                                        <th>Reference</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($enquiries) > 0): ?>
                                        <?php foreach ($enquiries as $enquiry): ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-md">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </td>
                                                <td><?php echo $enquiry['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="text-dark mb-0"><?php echo $enquiry['first_name'] . ' ' . $enquiry['last_name']; ?></p>
                                                            <span class="fs-12 text-muted">DOB: <?php echo $enquiry['dob']; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $enquiry['email']; ?></td>
                                                <td><?php echo $enquiry['phno']; ?></td>
                                                <td><?php echo $enquiry['education']; ?></td>
                                                <td><?php echo $enquiry['course_or_placement']; ?></td>
                                                <td><?php echo $enquiry['joining_date']; ?></td>
                                                <td>
                                                    <div>
                                                        <p class="mb-0"><?php echo $enquiry['ref_name']; ?></p>
                                                        <span class="fs-12 text-muted"><?php echo $enquiry['ref_phno']; ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="?edit_id=<?php echo $enquiry['id']; ?>" class="me-2" data-bs-toggle="modal" data-bs-target="#edit_enquiry_<?php echo $enquiry['id']; ?>">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <a href="?delete_id=<?php echo $enquiry['id']; ?>" onclick="return confirm('Are you sure you want to delete this enquiry?')">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4">No enquiries found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
                <p class="mb-0">2014 - 2025 &copy; Your Company.</p>
                <p>Enquiry Management System</p>
            </div>
        </div>
    </div>

    <!-- Add Enquiry Modal -->
    <div class="modal fade" id="add_enquiry" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Enquiry</h4>
                    <button type="button" class="custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phno">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Course/Placement</label>
                                    <input type="text" class="form-control" name="course_or_placement" placeholder="Enter course or placement details">
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" name="joining_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Name</label>
                                    <input type="text" class="form-control" name="ref_name">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Phone</label>
                                    <input type="text" class="form-control" name="ref_phno">
                                </div>									
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_enquiry" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Enquiry Modals -->
    <?php foreach ($enquiries as $enquiry): ?>
    <div class="modal fade" id="edit_enquiry_<?php echo $enquiry['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Enquiry</h4>
                    <button type="button" class="custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $enquiry['id']; ?>">
                    <div class="modal-body">	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo $enquiry['first_name']; ?>" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo $enquiry['last_name']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $enquiry['email']; ?>" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="<?php echo $enquiry['dob']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phno" value="<?php echo $enquiry['phno']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" value="<?php echo $enquiry['education']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Course/Placement</label>
                                    <input type="text" class="form-control" name="course_or_placement" value="<?php echo $enquiry['course_or_placement']; ?>" placeholder="Enter course or placement details">
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" name="joining_date" value="<?php echo $enquiry['joining_date']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Name</label>
                                    <input type="text" class="form-control" name="ref_name" value="<?php echo $enquiry['ref_name']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Phone</label>
                                    <input type="text" class="form-control" name="ref_phno" value="<?php echo $enquiry['ref_phno']; ?>">
                                </div>									
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_enquiry" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.7.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<!-- Feather Icon JS -->
	<script src="assets/js/feather.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js"></script>

	<!-- Chart JS -->
	<script src="assets/plugins/apexchart/apexcharts.min.js"></script>
	<script src="assets/plugins/apexchart/chart-data.js"></script>

	<!-- Chart JS -->
	<script src="assets/plugins/chartjs/chart.min.js"></script>
	<script src="assets/plugins/chartjs/chart-data.js"></script>

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

	<!-- Daterangepikcer JS -->
	<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>

	<!-- Summernote JS -->
	<script src="assets/plugins/summernote/summernote-lite.min.js"></script>

	<!-- Bootstrap Tagsinput JS -->
	<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

	<!-- Select2 JS -->
	<script src="assets/plugins/select2/js/select2.min.js"></script>

	<!-- Color Picker JS -->
	<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/todo.js"></script>
	<script src="assets/js/theme-colorpicker.js"></script>
	<script src="assets/js/script.js"></script>
    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#enquiryTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });
            
            // Initialize Select2
            $('.select').select2();
            
            // Initialize date pickers
            flatpickr(".datetimepicker", {
                dateFormat: "Y-m-d",
            });
            
            // Auto-open edit modal if edit_id is present in URL
            <?php if (isset($_GET['edit_id']) && $edit_enquiry): ?>
                var editModal = new bootstrap.Modal(document.getElementById('edit_enquiry_<?php echo $_GET['edit_id']; ?>'));
                editModal.show();
            <?php endif; ?>
        });
        
        // Select all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
</body>
</html>