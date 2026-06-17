<?php
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_no = $_POST['emp_no'];
    $new_dept_no = $_POST['new_dept'];
    $date_debut = $_POST['date_debut'];
    $date_actuelle = $_POST['date_actuelle'];

    if ($date_debut < $date_actuelle) {
        header("Location: fiche_empl.php?emp_no=" . $emp_no . "&erreur=date_anterieure");
        exit();
    }

    if (!empty($emp_no) && !empty($new_dept_no) && !empty($date_debut)) {
        modif_depart_employe($emp_no, $new_dept_no, $date_debut);
    }

    header("Location: fiche_empl.php?emp_no=" . $emp_no);
    exit();
}
?>