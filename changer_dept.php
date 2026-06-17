<?php
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_no = $_POST['emp_no'];
    $new_dept_no = $_POST['new_dept'];

    if (!empty($emp_no) && !empty($new_dept_no)) {
        modif_depart_employe($emp_no, $new_dept_no);
    }

    header("Location: fiche_empl.php?emp_no=" . $emp_no);
    exit();
}
?>