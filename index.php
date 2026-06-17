<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include ('function.php');
$departements = ls_depart();
$employes = empl();
$nb_empl= count($employes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Departements</title>
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
                    <input type="text" name="nom" class="form-control form-control-sm search-input" placeholder="Nom / Prénom" aria-label="Nom ou prénom">
                    <input type="text" name="dept" class="form-control form-control-sm search-input" placeholder="Département" aria-label="Département">
                    <input type="number" name="min" class="form-control form-control-sm search-input" placeholder="Âge min" aria-label="Âge minimum" style="min-width: 90px;">
                    <input type="number" name="max" class="form-control form-control-sm search-input" placeholder="Âge max" aria-label="Âge maximum" style="min-width: 90px;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <main class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="statistiques.php" class="btn btn-outline-primary">
                <i class="bi bi-bar-chart me-2"></i> Statistiques
            </a>
        </div>
        <div class="mb-3">
            <p>Nombre d'employés : <?php echo $nb_empl; ?></p>
        </div>
        <div class="tableau">
            <h1 class="text-center mb-4">Liste des departements</h1>
            <table class="table table-hover shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Departement</th>
                        <th class="text-center">Manager</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($departements as $departement) { ?>
                    <tr>
                        <td class="text-center">
                            <a href="employer_ls_depart.php?dept_no=<?php echo $departement['dept_no']; ?>" class="text-decoration-none">
                                <?php echo $departement['dept_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <?php echo manager_dept($departement['dept_no']); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>