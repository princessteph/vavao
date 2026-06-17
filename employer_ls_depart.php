<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include 'function.php';

$dept = $_GET['dept_no'];
$employers = ls_employes_dept($dept);
$nb_employer= count($employers);
?>

<!DOCTYPE html>
<html lang="fr">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Departement</title>
    <style></style>
</head>
<body class="bg-light">

    <header>
        <nav class="navbar navbar-dark bg-dark px-3 px-lg-4 py-2">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <i class="bi bi-people-fill me-2"></i>Employees
            </a>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <form class="d-flex align-items-center gap-2" action="recherche.php" method="post">
                    <input type="text" name="nom" class="form-control form-control-sm search-input" placeholder="Nom / Prenom" aria-label="Nom ou prenom">
                    <input type="text" name="dept" class="form-control form-control-sm search-input" placeholder="Departement" aria-label="Departement">
                    <input type="number" name="min" class="form-control form-control-sm search-input" placeholder="Âge min" aria-label="Âge minimum" style="min-width: 90px;">
                    <input type="number" name="max" class="form-control form-control-sm search-input" placeholder="Âge max" aria-label="Âge maximum" style="min-width: 90px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <a href="index.php" class="btn btn-outline-light btn-sm ms-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h2 class="mb-4 text-center">
            <i class="bi bi-building me-2 text-primary"></i>
            Liste des employes — <?php echo depart($dept)['dept_name']; ?>
        </h2>
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-people me-2"></i>
                <?php echo $nb_employer; ?> employes
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">
                                <i class="bi bi-person me-1 text-primary"></i>
                                Employe
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employers as $employer) { ?>
                        <tr>
                            <td class="text-center">
                                <a href="fiche_empl.php?emp_no=<?php echo $employer['emp_no']; ?>" class="text-decoration-none fw-semibold">
                                    <?php echo $employer['first_name'] . ' ' . $employer['last_name']; ?>
                                </a>
                            </td> 
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>