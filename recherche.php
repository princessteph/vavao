<?php 
    include("function.php");

    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $dept = isset($_POST['dept']) ? $_POST['dept'] : '';
    $min = isset($_POST['min']) ? $_POST['min'] : '';
    $max = isset($_POST['max']) ? $_POST['max'] : '';
    
    $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;

    $tableau = rechercher($nom, $dept, $min, $max, $offset);
    
    $limit = 20;
    $offset_prec = $offset - $limit;
    $offset_suiv = $offset + $limit;
    
    $has_prev = $offset > 0;
    $has_next = count($tableau) == $limit;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/font/bootstrap-icons.css">
    <title>Recherche</title>
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
                    <input type="text" name="nom" class="form-control form-control-sm search-input" placeholder="Nom / Prenom" value="<?php echo $nom; ?>">
                    <input type="text" name="dept" class="form-control form-control-sm search-input" placeholder="Departement" value="<?php echo $dept; ?>">
                    <input type="number" name="min" class="form-control form-control-sm search-input" placeholder="Âge min" style="min-width: 90px;" value="<?php echo $min; ?>">
                    <input type="number" name="max" class="form-control form-control-sm search-input" placeholder="Âge max" style="min-width: 90px;" value="<?php echo $max; ?>">
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
        <h2 class="mb-4">
            <i class="bi bi-search me-2 text-primary"></i>Resultats de la recherche
        </h2>
        
        <div class="card shadow">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <i class="bi bi-building me-1 text-primary"></i>
                                Departement
                            </th>
                            <th>Nom et Prenom</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tableau as $ligne) { ?>
                        <tr>
                            <td>
                                <a href="employer_ls_depart.php?dept_no=<?php echo $ligne['dept_no']; ?>" class="text-decoration-none fw-semibold">
                                    <?php echo $ligne['departement']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="fiche_empl.php?emp_no=<?php echo $ligne['emp_no']; ?>" class="text-decoration-none">
                                    <?php echo $ligne['nom_personne']; ?> <?php echo $ligne['prenom_personne']; ?>
                                </a>
                            </td>
                            <td><?php echo $ligne['age']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION EN POST -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <?php if ($has_prev) { ?>
                <form action="recherche.php" method="post" style="display:inline;">
                    <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                    <input type="hidden" name="dept" value="<?php echo $dept; ?>">
                    <input type="hidden" name="min" value="<?php echo $min; ?>">
                    <input type="hidden" name="max" value="<?php echo $max; ?>">
                    <input type="hidden" name="offset" value="<?php echo $offset_prec; ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i>Precedent
                    </button>
                </form>
            <?php } else { ?>
                <span></span>
            <?php } ?>


            <?php if ($has_next) { ?>
                <form action="recherche.php" method="post" style="display:inline;">
                    <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                    <input type="hidden" name="dept" value="<?php echo $dept; ?>">
                    <input type="hidden" name="min" value="<?php echo $min; ?>">
                    <input type="hidden" name="max" value="<?php echo $max; ?>">
                    <input type="hidden" name="offset" value="<?php echo $offset_suiv; ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        Suivant<i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            <?php } else { ?>
                <span></span>
            <?php } ?>
        </div>
    </main>

    <footer class="text-center text-muted small">Employees — Resultats de recherche</footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>