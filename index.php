<?php
require '../vendor/autoload.php';
require_once "../config/config.php";
require_once "../system/Database.php";
require_once "../config/mail.php";
$phpVersion = phpversion();
$uri = null;
if ($phpVersion <= 7) {
    $uri = isset($_GET['url']) ? $_GET['url'] : 'home';
} else {
    $uri = $_GET['url'] ?? 'home';

}

$title = $uri;

$uri = $uri . '.php';

if (!isset($_SESSION['company_username']) || $_SESSION['is_login'] != true) {
    $_SESSION['error'] = "Please login first";
    redirect_to('index.php');
    exit();
}


$patePath = page_path('@company-admin/pages/' . $uri);


require_once "layouts/header.php";


if (file_exists($patePath) && is_file($patePath)) {
    require_once "layouts/nav.php";
    require_once $patePath;
} else {
    echo "
<div class='right_col' role='main'>
<hr>Sorry Page not found</h1>
</div>
";

}


?>

<?php
require_once "layouts/footer.php";
?>

