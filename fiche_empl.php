<?php 
include 'function.php';

$emp_no = $_GET['emp_no'];
$employee = fiche_employe($emp_no);
$salaries = historique_salaire($emp_no);
$dept = dept_employe($emp_no);

// AJOUTE CETTE LIGNE
$emploi_long = emploi_plus_long($emp_no);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Fiche employe</title>
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

                <a href="javascript:history.back()" class="btn btn-outline-light btn-sm ms-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h2 class="mb-4 text-center">
            <i class="bi bi-person-badge me-2 text-primary"></i>
            Fiche de l'employe
        </h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-person me-2"></i>
                        <?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr>
                                    <th class="w-25">Nom</th>
                                    <td><?php echo $employee['first_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Prenom</th>
                                    <td><?php echo $employee['last_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Departement</th>
                                    <td>
                                        <i class="bi bi-building me-1 text-primary"></i>
                                        <?php echo $dept; ?>
                                    </td>
                                </tr>                                
                                <tr>
                                    <th>Emploi le plus long</th>
                                    <td>
                                        <?php echo $emploi_long['title']; ?> 
                                        <span class="text-muted">(<?php echo $emploi_long['duree_texte']; ?>)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date de naissance</th>
                                    <td><?php echo $employee['birth_date']; ?></td>
                                </tr>
                                <tr>
                                    <th>Sexe</th>
                                    <td>
                                        <?php if ($employee['gender'] === 'M') { ?>
                                            <i class="bi bi-gender-male text-primary"></i>
                                        <?php } else { ?>
                                            <i class="bi bi-gender-female text-danger"></i>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Engager le</th>
                                    <td><?php echo $employee['hire_date']; ?></td>
                                </tr>
                                <tr>
                                    <th>Emploi actuel</th>
                                    <td><?php echo $employee['title']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <i class="bi bi-cash-stack me-2"></i>Historique des salaires
                    </div>
                    <div class="card-body">
                        <?php foreach ($salaries as $salaire) { ?>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-bold text-success"><?php echo number_format($salaire['salary'], 0, ',', ' '); ?> $</span>
                                <span class="text-muted small">
                                    du <?php echo $salaire['from_date']; ?> au <?php echo $salaire['to_date']; ?>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>