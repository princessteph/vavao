<?php
include 'function.php';

$emp_no = $_GET['emp_no'];
$dept_no = $_GET['dept_no'];

$employee = fiche_employe($emp_no);
$manager = manager_actuel_info($dept_no);
$erreur = '';

if (isset($_POST['date_debut'])) {
    $date_debut = $_POST['date_debut'];
    $date_manager = $manager['from_date'];
    
    if ($date_debut <= $date_manager) {
        $erreur = "Erreur : la date doit etre apres le " . $date_manager;
    } else {
        ajouter_manager($dept_no, $emp_no, $date_debut);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Devenir Manager</title>
    <style></style>
</head>
<body class="bg-light">

    <header>
        <nav class="navbar navbar-dark bg-dark px-3 px-lg-4 py-2">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <i class="bi bi-people-fill me-2"></i>Employees
            </a>
        </nav>
    </header>

    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-star me-2"></i>Devenir Manager
                    </div>
                    <div class="card-body">
                        
                        <p class="text-muted">
                            Manager actuel : 
                            <strong><?php echo $manager['first_name'] . ' ' . $manager['last_name']; ?></strong>
                            (depuis <?php echo $manager['from_date']; ?>)
                        </p>
                        
                        <?php if ($erreur != '') { ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i><?php echo $erreur; ?>
                            </div>
                        <?php } ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Employe</label>
                                <input type="text" class="form-control" value="<?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date de debut</label>
                                <input type="date" name="date_debut" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check me-1"></i>Valider
                            </button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>