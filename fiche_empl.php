<?php 
include 'function.php';

$emp_no = $_GET['emp_no'];
$employee = fiche_employe($emp_no);
$salaries = historique_salaire($emp_no);
$dept = dept_employe($emp_no);
$tous_les_depts = ls_depart();
$dept_no = dept_no_employe($emp_no);

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
                                        <?php echo $dept['dept_name']; ?>  
                                        <?php if (!empty($dept['from_date'])) { ?>
                                           <span class="text-muted small ms-2">(A partir : <?php echo $dept['from_date']; ?>)</span>
                                        <?php } ?>
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
                                <tr>
                                    <th>Action</th>
                                    <td>
                                        <a href="devenir_manager.php?emp_no=<?php echo $emp_no; ?>&dept_no=<?php echo $dept_no; ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-star me-1"></i>Devenir Manager
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Changer de département</th>
                                    <td>
                                        <form action="changer_dept.php" method="post" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="emp_no" value="<?php echo $emp_no; ?>">
                                            <input type="hidden" name="date_actuelle" value="<?php echo $dept['from_date']; ?>">
                                            
                                            <select name="new_dept" class="form-select form-select-sm" style="max-width: 200px;" required>
                                                <option value="">Choisir un département</option>
                                                <?php foreach ($tous_les_depts as $d) { ?>
                                                    <?php if ($d['dept_no'] !== $dept['dept_no']) { ?>
                                                        <option value="<?php echo $d['dept_no']; ?>">
                                                            <?php echo $d['dept_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>

                                            <input type="date" name="date_debut" class="form-control form-control-sm" style="max-width: 140px;" value="<?php echo date('Y-m-d'); ?>" required>
                                            
                                            <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                                <i class="bi bi-check-lg"></i>
                                                <span>Valider</span>
                                            </button>
                                        </form>

                                        <?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'date_anterieure') { ?>
                                            <div class="text-danger small fw-bold mt-1">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                La date ne peut pas être antérieure au <?php echo $dept['from_date']; ?>.
                                            </div>
                                        <?php } ?>
                                    </td>
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