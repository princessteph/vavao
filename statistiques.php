<?php
include 'function.php';
$resultats = statistiques_emploi();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Statistiques</title>
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
            <i class="bi bi-bar-chart me-2 text-primary"></i>
            Statistiques par emploi
        </h2>

        <div class="card shadow">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-briefcase me-1"></i> Emploi</th>
                            <th class="text-center"><i class="bi bi-gender-male me-1"></i> Hommes</th>
                            <th class="text-center"><i class="bi bi-gender-female me-1"></i> Femmes</th>
                            <th class="text-center"><i class="bi bi-people me-1"></i> Total</th>
                            <th class="text-end"><i class="bi bi-cash me-1"></i> Salaire moyen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultats as $ligne) { ?>
                        <tr>
                            <td class="fw-semibold"><?php echo $ligne['emploi']; ?></td>
                            <td class="text-center"><?php echo $ligne['hommes']; ?></td>
                            <td class="text-center"><?php echo $ligne['femmes']; ?></td>
                            <td class="text-center fw-bold"><?php echo $ligne['total']; ?></td>
                            <td class="text-end text-success fw-bold">
                                <?php echo number_format($ligne['salaire_moyen'], 0, ',', ' '); ?> $
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