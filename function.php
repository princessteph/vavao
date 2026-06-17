<?php
function dbconnect() {
    static $connect = null;
    
    if ($connect === null) {
        $connect = mysqli_connect('localhost', 'root', '', 'employees');
        
        if (!$connect) {
            die('Erreur de connexion a la base de donnees : ' . mysqli_connect_error());
        }
        
        mysqli_set_charset($connect, 'utf8mb4');
    }
    
    return $connect;
}

function ls_depart() {
    $sql = "SELECT * FROM departments order by dept_no";
    $req = mysqli_query(dbconnect(), $sql);
    $result = array();
    
    while ($user = mysqli_fetch_assoc($req)) {
        $result[] = $user;
    }
    
    mysqli_free_result($req);
    return $result;
}

function depart($dept_no) {
    $sql = "SELECT dept_name FROM departments where dept_no = '$dept_no'";
    $req = mysqli_query(dbconnect(), $sql);
    $result = mysqli_fetch_assoc($req);
    mysqli_free_result($req);
    return $result;
}

function manager_dept($dept_no) {
    $sql = "
        SELECT employees.first_name, employees.last_name 
        FROM dept_manager, employees
        WHERE dept_manager.emp_no = employees.emp_no
        AND dept_manager.dept_no = '$dept_no'
        AND dept_manager.to_date = '9999-01-01'
    ";
    
    $res = mysqli_query(dbconnect(), $sql);
    
    if ($res && $row = mysqli_fetch_assoc($res)) {
        mysqli_free_result($res);
        return $row['first_name'] . ' ' . $row['last_name']; 
    }
    
    return 'Aucun manager'; 
}

function ls_employes_dept($dept_no) {
    $sql ="SELECT first_name, last_name, employees.emp_no from dept_emp
            JOIN departments on dept_emp.dept_no = departments.dept_no
            JOIN employees on dept_emp.emp_no = employees.emp_no
            where departments.dept_no = '$dept_no' ";
    
    $req = mysqli_query(dbconnect(), $sql);
    $result = array();
    
    while ($user = mysqli_fetch_assoc($req)) {
        $result[] = $user;
    }
    
    mysqli_free_result($req);
    return $result; 
}

function fiche_employe($emp_no) {
    $sql = "SELECT employees.*, titles.title 
            FROM employees 
            JOIN titles ON employees.emp_no = titles.emp_no 
            WHERE employees.emp_no = '$emp_no'
            AND titles.to_date = '9999-01-01'";
    
    $req = mysqli_query(dbconnect(), $sql);
    $result = mysqli_fetch_assoc($req);
    mysqli_free_result($req);
    return $result;
}   

function dept_employe($emp_no) {
    $sql = "SELECT departments.dept_name 
            FROM dept_emp 
            JOIN departments ON dept_emp.dept_no = departments.dept_no 
            WHERE dept_emp.emp_no = '$emp_no' 
            AND dept_emp.to_date = '9999-01-01'";
    
    $res = mysqli_query(dbconnect(), $sql);
    
    if ($res && $row = mysqli_fetch_assoc($res)) {
        mysqli_free_result($res);
        return $row['dept_name'];
    }
    
    return 'Non assigne';
}

function historique_salaire($emp_no) {
    $sql = "SELECT * FROM salaries WHERE emp_no='$emp_no' ORDER BY from_date DESC";
    $req = mysqli_query(dbconnect(), $sql);
    $result = array();
    
    while ($row = mysqli_fetch_assoc($req)) {
        $result[] = $row;
    }
    
    mysqli_free_result($req);
    return $result;
}

function rechercher($nom, $dept, $min, $max, $offset = 0){
    $conditions = array();
    $limit = 20;
    
    $sql = "SELECT first_name, last_name, (2026-YEAR(birth_date)) as age, 
                   departments.dept_name as depart,
                   departments.dept_no,
                   employees.emp_no
            FROM dept_emp 
            JOIN departments ON dept_emp.dept_no = departments.dept_no 
            JOIN employees ON dept_emp.emp_no = employees.emp_no";
    
    if (!empty($dept)) {
        $conditions[] = "departments.dept_name LIKE '%$dept%'";
    }
    
    if (!empty($nom)) {
        $conditions[] = "(first_name LIKE '%$nom%' OR last_name LIKE '%$nom%')";
    }
    
    if (!empty($min)) {
        $conditions[] = "(2026-YEAR(birth_date)) >= $min";
    }
    
    if (!empty($max)) {
        $conditions[] = "(2026-YEAR(birth_date)) <= $max";
    }
    
    if (count($conditions) > 0) {
        $where = "";
        for ($i = 0; $i < count($conditions); $i++) {
            $where = $where . $conditions[$i];
            if ($i < count($conditions) - 1) {
                $where = $where . " AND ";
            }
        }
        $sql = $sql . " WHERE " . $where;
    }
    
    if (!is_numeric($offset)) {
        $offset = 0;
    }
    
    $sql = $sql . " LIMIT " . $offset . ", " . $limit;
    
    $news_req = mysqli_query(dbconnect(), $sql);
    $result = array();
    $i = 0;
    
    while ($news = mysqli_fetch_assoc($news_req)) {
        $result[$i]["dept_no"] = $news["dept_no"];
        $result[$i]["emp_no"] = $news["emp_no"];
        $result[$i]["departement"] = $news["depart"];
        $result[$i]["nom_personne"] = $news["first_name"];
        $result[$i]["prenom_personne"] = $news["last_name"];
        $result[$i]["age"] = $news["age"];
        $i++;
    }
    
    mysqli_free_result($news_req);
    return $result;
}

function statistiques_emploi() {
    $sql = "SELECT 
                titles.title as emploi,
                SUM(CASE WHEN employees.gender = 'M' THEN 1 ELSE 0 END) as hommes,
                SUM(CASE WHEN employees.gender = 'F' THEN 1 ELSE 0 END) as femmes,
                COUNT(*) as total,
                ROUND(AVG(salaries.salary), 2) as salaire_moyen
            FROM titles
            JOIN employees ON titles.emp_no = employees.emp_no
            JOIN salaries ON titles.emp_no = salaries.emp_no
            WHERE titles.to_date = '9999-01-01'
            AND salaries.to_date = '9999-01-01'
            GROUP BY titles.title
            ORDER BY total DESC";
    
    $req = mysqli_query(dbconnect(), $sql);
    $result = array();
    
    while ($ligne = mysqli_fetch_assoc($req)) {
        $result[] = $ligne;
    }
    
    mysqli_free_result($req);
    return $result;
}