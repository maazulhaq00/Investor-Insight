<!DOCTYPE html>
<html>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" || 1) {
    // collect value of input field
    print_r($_REQUEST['fname']);
    print_r($_GET['fname']);
    print_r($_POST['fname']);
}
?>

</body>
</html>