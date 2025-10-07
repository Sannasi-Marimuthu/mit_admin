<?php
include_once('connection_db.php');

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ADD ADMISSION
    if (isset($_POST['add_admission'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phno = $_POST['phno'];
        $phno1 = $_POST['phno1'];
        $education = $_POST['education'];
        $address = $_POST['address'];
        $course_or_placement = $_POST['course_or_placement'];
        $placement_detail = $_POST['placement_detail'];
        $aadhar_no = $_POST['aadhar_no'];
        $ref_name = $_POST['ref_name'];
        $ref_phno = $_POST['ref_phno'];

        // Handle file uploads
        $signature = '';
        $photo = '';

        // Upload signature
        if (isset($_FILES['signature']) && $_FILES['signature']['error'] == 0) {
            $signatureDir = __DIR__ . "/assets/img/uploads/signatures/";
            if (!is_dir($signatureDir)) {
                mkdir($signatureDir, 0777, true);
            }
            $signatureName = 'signature_' . time() . '_' . basename($_FILES['signature']['name']);
            $signaturePath = $signatureDir . $signatureName;
            if (move_uploaded_file($_FILES['signature']['tmp_name'], $signaturePath)) {
                $signature = "assets/img/uploads/signatures/" . $signatureName;
            }
        }

        // Upload photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photoDir = __DIR__ . "/assets/img/uploads/photos/";
            if (!is_dir($photoDir)) {
                mkdir($photoDir, 0777, true);
            }
            $photoName = 'photo_' . time() . '_' . basename($_FILES['photo']['name']);
            $photoPath = $photoDir . $photoName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
                $photo = "assets/img/uploads/photos/" . $photoName;
            }
        }

        $sql = "INSERT INTO admission 
                (first_name, last_name, email, dob, phno, phno1, education, address, course_or_placement, placement_detail, aadhar_no, signature, photo, ref_name, ref_phno) 
                VALUES 
                ('$first_name', '$last_name', '$email', '$dob', '$phno', '$phno1', '$education', '$address', '$course_or_placement', '$placement_detail', '$aadhar_no', '$signature', '$photo', '$ref_name', '$ref_phno')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Admission added successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // UPDATE ADMISSION
    if (isset($_POST['update_admission'])) {
        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $phno = $_POST['phno'];
        $phno1 = $_POST['phno1'];
        $education = $_POST['education'];
        $address = $_POST['address'];
        $course_or_placement = $_POST['course_or_placement'];
        $placement_detail = $_POST['placement_detail'];
        $aadhar_no = $_POST['aadhar_no'];
        $ref_name = $_POST['ref_name'];
        $ref_phno = $_POST['ref_phno'];

        // Existing files (hidden input in form)
        $signature = $_POST['existing_signature'];
        $photo = $_POST['existing_photo'];

        // Upload new signature if provided
        if (isset($_FILES['signature']) && $_FILES['signature']['error'] == 0) {
            $signatureDir = __DIR__ . "/assets/img/uploads/signatures/";
            if (!is_dir($signatureDir)) {
                mkdir($signatureDir, 0777, true);
            }
            $signatureName = 'signature_' . time() . '_' . basename($_FILES['signature']['name']);
            $signaturePath = $signatureDir . $signatureName;
            if (move_uploaded_file($_FILES['signature']['tmp_name'], $signaturePath)) {
                $signature = "assets/img/uploads/signatures/" . $signatureName;
            }
        }

        // Upload new photo if provided
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photoDir = __DIR__ . "/assets/img/uploads/photos/";
            if (!is_dir($photoDir)) {
                mkdir($photoDir, 0777, true);
            }
            $photoName = 'photo_' . time() . '_' . basename($_FILES['photo']['name']);
            $photoPath = $photoDir . $photoName;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
                $photo = "assets/img/uploads/photos/" . $photoName;
            }
        }

        $sql = "UPDATE admission SET 
                first_name='$first_name', last_name='$last_name', email='$email', 
                dob='$dob', phno='$phno', phno1='$phno1', education='$education', 
                address='$address', course_or_placement='$course_or_placement', 
                placement_detail='$placement_detail', aadhar_no='$aadhar_no', 
                signature='$signature', photo='$photo', ref_name='$ref_name', ref_phno='$ref_phno' 
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Admission updated successfully!";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM admission WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Admission deleted successfully!";
    } else {
        $error_message = "Error deleting record: " . $conn->error;
    }
}

// Fetch admissions
$sql = "SELECT * FROM admission";
$result = $conn->query($sql);
$admissions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $admissions[] = $row;
    }
}

$edit_admission = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM admission WHERE id=$edit_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $edit_admission = $result->fetch_assoc();
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
    <title>MIT - Admission Management</title>
    
    <meta name="description" content="Admission Management System">
    <meta name="keywords" content="admission, management, system">
    <meta name="author" content="Your Company">
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

    <style>
        .file-upload-preview {
            max-width: 150px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
            margin-top: 5px;
        }
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin-bottom: 15px;
            cursor: pointer;
        }
        .upload-area:hover {
            border-color: #7367f0;
        }
    </style>
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
                        <h2 class="mb-1">Admission</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="ti ti-smart-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">Admission</li>
                                <li class="breadcrumb-item active" aria-current="page">Admission List</li>
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add_admission" class="btn btn-primary d-flex align-items-center">
                                <i class="ti ti-circle-plus me-2"></i>Add Admission
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
                    <!-- Total Admissions -->
                    <div class="col-lg-3 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center overflow-hidden">
                                    <div>
                                        <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                                    </div>
                                    <div class="ms-2 overflow-hidden">
                                        <p class="fs-12 fw-medium mb-1 text-truncate">Total Admissions</p>
                                        <h4><?php echo count($admissions); ?></h4>
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
                    <!-- /Total Admissions -->
                </div>

                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5>Admission List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="admissionTable">
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
                                        <th>Placement Detail</th>
                                        <th>Aadhar No</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($admissions) > 0): ?>
                                        <?php foreach ($admissions as $admission): ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-md">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </td>
                                                <td><?php echo $admission['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($admission['photo'])): ?>
                                                            <img src="<?php echo $admission['photo']; ?>" alt="Photo" class="avatar avatar-md rounded-circle me-2">
                                                        <?php else: ?>
                                                            <div class="avatar avatar-md bg-light rounded-circle me-2">
                                                                <i class="ti ti-user"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="ms-2">
                                                            <p class="text-dark mb-0"><?php echo $admission['first_name'] . ' ' . $admission['last_name']; ?></p>
                                                            <span class="fs-12 text-muted">DOB: <?php echo $admission['dob']; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo $admission['email']; ?></td>
                                                <td><?php echo $admission['phno']; ?></td>
                                                <td><?php echo $admission['education']; ?></td>
                                                <td><?php echo $admission['course_or_placement']; ?></td>
                                                <td><?php echo $admission['placement_detail']; ?></td>
                                                <td><?php echo $admission['aadhar_no']; ?></td>
                                                <td>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="?edit_id=<?php echo $admission['id']; ?>" class="me-2" data-bs-toggle="modal" data-bs-target="#edit_admission_<?php echo $admission['id']; ?>">
                                                            <i class="ti ti-edit"></i>
                                                        </a>
                                                        <a href="?delete_id=<?php echo $admission['id']; ?>" onclick="return confirm('Are you sure you want to delete this admission?')">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4">No admissions found</td>
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
                <p>Admission Management System</p>
            </div>
        </div>
    </div>

    <!-- Add Admission Modal -->
    <div class="modal fade" id="add_admission" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Admission</h4>
                    <button type="button" class="custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
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
                                    <label class="form-label">Phone Number 1</label>
                                    <input type="text" class="form-control" name="phno">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number 2</label>
                                    <input type="text" class="form-control" name="phno1">
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
                                    <label class="form-label">Aadhar Number</label>
                                    <input type="text" class="form-control" name="aadhar_no">
                                </div>									
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"></textarea>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Course/Placement <span class="text-danger">*</span></label>
                                    <select class="form-select" name="course_or_placement" required>
                                        <option value="">Select</option>
                                        <option value="Course">Course</option>
                                        <option value="Placement">Placement</option>
                                        <option value="Both">Both</option>
                                    </select>
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Placement Detail</label>
                                    <select class="form-select" name="placement_detail">
                                        <option value="">Select</option>
                                        <option value="React.js">React.js</option>
                                        <option value="Python">Python</option>
                                        <option value="UI/UX">UI/UX</option>
                                        <option value="SQL/PLSQL">SQL/PLSQL</option>
                                        <option value="DevOps">DevOps</option>
                                        <option value="Digital Marketing">Digital Marketing</option>
                                        <option value="Placement">Placement</option>
                                    </select>
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Signature Upload</label>
                                    <div class="upload-area" onclick="document.getElementById('signature').click()">
                                        <i class="ti ti-upload fs-24 mb-2"></i>
                                        <p class="mb-1">Click to upload signature</p>
                                        <small class="text-muted">JPG, PNG, PDF (Max 2MB)</small>
                                    </div>
                                    <input type="file" class="form-control d-none" id="signature" name="signature" accept="image/*,.pdf">
                                    <div id="signature-preview" class="file-upload-preview"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Photo Upload (Passport Size)</label>
                                    <div class="upload-area" onclick="document.getElementById('photo').click()">
                                        <i class="ti ti-upload fs-24 mb-2"></i>
                                        <p class="mb-1">Click to upload photo</p>
                                        <small class="text-muted">JPG, PNG (Max 2MB)</small>
                                    </div>
                                    <input type="file" class="form-control d-none" id="photo" name="photo" accept="image/*">
                                    <div id="photo-preview" class="file-upload-preview"></div>
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
                        <button type="submit" name="add_admission" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Admission Modals -->
    <?php foreach ($admissions as $admission): ?>
    <div class="modal fade" id="edit_admission_<?php echo $admission['id']; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Admission</h4>
                    <button type="button" class="custom-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $admission['id']; ?>">
                    <input type="hidden" name="existing_signature" value="<?php echo $admission['signature']; ?>">
                    <input type="hidden" name="existing_photo" value="<?php echo $admission['photo']; ?>">
                    <div class="modal-body">	
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo $admission['first_name']; ?>" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo $admission['last_name']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $admission['email']; ?>" required>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" value="<?php echo $admission['dob']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number 1</label>
                                    <input type="text" class="form-control" name="phno" value="<?php echo $admission['phno']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number 2</label>
                                    <input type="text" class="form-control" name="phno1" value="<?php echo $admission['phno1']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Education</label>
                                    <input type="text" class="form-control" name="education" value="<?php echo $admission['education']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Aadhar Number</label>
                                    <input type="text" class="form-control" name="aadhar_no" value="<?php echo $admission['aadhar_no']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?php echo $admission['address']; ?></textarea>
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Course/Placement <span class="text-danger">*</span></label>
                                    <select class="form-select" name="course_or_placement" required>
                                        <option value="">Select</option>
                                        <option value="Course" <?php echo ($admission['course_or_placement'] == 'Course') ? 'selected' : ''; ?>>Course</option>
                                        <option value="Placement" <?php echo ($admission['course_or_placement'] == 'Placement') ? 'selected' : ''; ?>>Placement</option>
                                        <option value="Both" <?php echo ($admission['course_or_placement'] == 'Both') ? 'selected' : ''; ?>>Both</option>
                                    </select>
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Placement Detail</label>
                                    <select class="form-select" name="placement_detail">
                                        <option value="">Select</option>
                                        <option value="React.js" <?php echo ($admission['placement_detail'] == 'React.js') ? 'selected' : ''; ?>>React.js</option>
                                        <option value="Python" <?php echo ($admission['placement_detail'] == 'Python') ? 'selected' : ''; ?>>Python</option>
                                        <option value="UI/UX" <?php echo ($admission['placement_detail'] == 'UI/UX') ? 'selected' : ''; ?>>UI/UX</option>
                                        <option value="SQL/PLSQL" <?php echo ($admission['placement_detail'] == 'SQL/PLSQL') ? 'selected' : ''; ?>>SQL/PLSQL</option>
                                        <option value="DevOps" <?php echo ($admission['placement_detail'] == 'DevOps') ? 'selected' : ''; ?>>DevOps</option>
                                        <option value="Digital Marketing" <?php echo ($admission['placement_detail'] == 'Digital Marketing') ? 'selected' : ''; ?>>Digital Marketing</option>
                                        <option value="Placement" <?php echo ($admission['placement_detail'] == 'Placement') ? 'selected' : ''; ?>>Placement</option>
                                    </select>
                                </div>		
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Signature Upload</label>
                                    <?php if (!empty($admission['signature'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo $admission['signature']; ?>" alt="Current Photo" class="file-upload-preview">
                                        </div>
                                    <?php endif; ?>
                                    <div class="upload-area" onclick="document.getElementById('signature_<?php echo $admission['id']; ?>').click()">
                                        <i class="ti ti-upload fs-24 mb-2"></i>
                                        <p class="mb-1">Click to upload new signature</p>
                                        <small class="text-muted">JPG, PNG, PDF (Max 2MB)</small>
                                    </div>
                                    <input type="file" class="form-control d-none" id="signature_<?php echo $admission['id']; ?>" name="signature" accept="image/*,.pdf">
                                    <div id="signature-preview-<?php echo $admission['id']; ?>" class="file-upload-preview"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Photo Upload (Passport Size)</label>
                                    <?php if (!empty($admission['photo'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo $admission['photo']; ?>" alt="Current Photo" class="file-upload-preview">
                                        </div>
                                    <?php endif; ?>
                                    <div class="upload-area" onclick="document.getElementById('photo_<?php echo $admission['id']; ?>').click()">
                                        <i class="ti ti-upload fs-24 mb-2"></i>
                                        <p class="mb-1">Click to upload new photo</p>
                                        <small class="text-muted">JPG, PNG (Max 2MB)</small>
                                    </div>
                                    <input type="file" class="form-control d-none" id="photo_<?php echo $admission['id']; ?>" name="photo" accept="image/*">
                                    <div id="photo-preview-<?php echo $admission['id']; ?>" class="file-upload-preview"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Name</label>
                                    <input type="text" class="form-control" name="ref_name" value="<?php echo $admission['ref_name']; ?>">
                                </div>									
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Reference Phone</label>
                                    <input type="text" class="form-control" name="ref_phno" value="<?php echo $admission['ref_phno']; ?>">
                                </div>									
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_admission" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- JavaScript Libraries -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#admissionTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });
            
            // File upload preview
            function handleFilePreview(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewId).html('<img src="' + e.target.result + '" class="img-fluid">');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Add modal file previews
            $('#signature').change(function() {
                handleFilePreview(this, 'signature-preview');
            });

            $('#photo').change(function() {
                handleFilePreview(this, 'photo-preview');
            });

            // Edit modal file previews
            <?php foreach ($admissions as $admission): ?>
            $('#signature_<?php echo $admission['id']; ?>').change(function() {
                handleFilePreview(this, 'signature-preview-<?php echo $admission['id']; ?>');
            });

            $('#photo_<?php echo $admission['id']; ?>').change(function() {
                handleFilePreview(this, 'photo-preview-<?php echo $admission['id']; ?>');
            });
            <?php endforeach; ?>

            // Auto-open edit modal if edit_id is present in URL
            <?php if (isset($_GET['edit_id']) && $edit_admission): ?>
                var editModal = new bootstrap.Modal(document.getElementById('edit_admission_<?php echo $_GET['edit_id']; ?>'));
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