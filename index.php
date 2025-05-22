<?php 
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Allowed pages to prevent invalid page access
$allowed_pages = ['home', 'class_list', 'student_list', 'attendance', 'attendance_report'];
$page = $_GET['page'] ?? 'home';
$page = in_array($page, $allowed_pages) ? $page : 'home';

$page_title = ucwords(str_replace("_", " ", $page));

require_once('classes/actions.class.php');
$actionClass = new Actions();
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once('inc/header.php'); ?>
<body>
<?php include_once('inc/navigation.php'); ?>
    <div class="container-md py-3">
        <?php if(isset($_SESSION['flashdata']) && !empty($_SESSION['flashdata'])): ?>
            <div class="flashdata flashdata-<?= $_SESSION['flashdata']['type'] ?? 'default' ?> mb-3">
                <div class="d-flex w-100 align-items-center flex-wrap">
                    <div class="col-11"><?= $_SESSION['flashdata']['msg'] ?? '' ?></div>
                    <div class="col-1 text-center">
                        <a href="javascript:void(0)" onclick="this.closest('.flashdata').remove()" class="flashdata-close"><i class="far fa-times-circle"></i></a>
                    </div>
                </div>
            </div>
        <?php unset($_SESSION['flashdata']); ?>
        <?php endif; ?>
        <div class="main-wrapper">
            <?php 
            // Check if the page exists before including
            if (file_exists("pages/{$page}.php")) {
                include_once("pages/{$page}.php");
            } else {
                // Include 404 page if the requested page doesn't exist
                include_once("pages/404.php");
            }
            ?>
        </div>
    </div>
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
