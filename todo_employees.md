# Todo List : EMPLOYEES

## index.php
### affichage :
- departements[]
  - dept_no [ok]
  - dept_name (link employer_ls_depart.php?dept_no) [ok]
  - manager_name [ok]
- bouton("Statistiques") [ok]
- formulaire_recherche [ok]
  - input(nom) [ok]
  - input(departement) [ok]
  - input(age_min) [ok]
  - input(age_max) [ok]
  - btn(rechercher) [ok]
### code dynamique :
- include('function.php') [ok]
- ls_depart() [ok]
- foreach(departements[]) [ok]
- manager_dept(dept_no) [ok]
- formulaire POST → recherche.php [ok]
- link(statistiques.php) [ok]
### fonctions :
- ls_depart() (SELECT * FROM departments) [ok]
- manager_dept(dept_no) (JOIN dept_manager + employees WHERE to_date='9999-01-01') [ok]


## employer_ls_depart.php
### affichage :
- titre_page("Liste employes — [nom_departement]") [ok]
- employes[]
  - first_name [ok]
  - last_name (link fiche_empl.php?emp_no) [ok]
  - emp_no [ok]
- nombre_employes [ok]
- bouton_retour [ok]
- formulaire_recherche [ok]
### code dynamique :
- GET(dept_no) [ok]
- ls_employes_dept(dept_no) [ok]
- depart(dept_no) [ok]
- count(employes) [ok]
- foreach(employes[]) [ok]
- link(fiche_empl.php?emp_no) [ok]
### fonctions :
- ls_employes_dept(dept_no) (JOIN dept_emp + departments + employees) [ok]
- depart(dept_no) (SELECT dept_name FROM departments) [ok]


## fiche_empl.php
### affichage :
- employee[]
  - first_name [ok]
  - last_name [ok]
  - birth_date [ok]
  - gender (icon male/female) [ok]
  - hire_date [ok]
- dept_employe [ok]
  - dept_name [ok]
  - from_date ("A partir : [date]") [ok]
- emploi_le_plus_long [ok]
  - title [ok]
  - duree_texte [ok]
- emploi_actuel (title) [ok]
- btn("Devenir Manager") (link devenir_manager.php?emp_no&dept_no) [ok]
- formulaire_changer_departement [ok]
  - dept_actuel_info [ok]
  - select(new_dept) [ok]
    - option(departements[]) [ok]
    - exclude(dept_actuel) [ok]
  - input(date_debut) [ok]
  - btn("Valider") [ok]
- message_erreur_date [ok]
- historique_salaires[] [ok]
  - salary [ok]
  - from_date [ok]
  - to_date [ok]
- formulaire_recherche [ok]
- bouton_retour [ok]
### code dynamique :
- GET(emp_no) [ok]
- fiche_employe(emp_no) [ok]
- historique_salaire(emp_no) [ok]
- dept_employe(emp_no) [ok]
- dept_no_employe(emp_no) [ok]
- ls_depart() [ok]
- emploi_plus_long(emp_no) [ok]
- POST(formulaire) → changer_dept.php [ok]
- GET(erreur) [ok]
- display(erreur_date_anterieure) [ok]
- foreach(salaries[]) [ok]
- foreach(tous_les_depts[]) [ok]
- IF(dept_no !== d.dept_no) [ok]
### fonctions :
- fiche_employe(emp_no) (JOIN employees + titles WHERE to_date='9999-01-01') [ok]
- historique_salaire(emp_no) (SELECT * FROM salaries ORDER BY from_date DESC) [ok]
- dept_employe(emp_no) (JOIN dept_emp + departments WHERE to_date='9999-01-01') [ok]
- dept_no_employe(emp_no) (SELECT dept_no FROM dept_emp WHERE to_date='9999-01-01') [ok]
- emploi_plus_long(emp_no) (SELECT titles + calcul duree) [ok]
- ls_depart() [ok]


## recherche.php
### affichage :
- resultats[]
  - departement (link employer_ls_depart.php?dept_no) [ok]
  - nom_personne [ok]
  - prenom_personne [ok]
  - age [ok]
- pagination [ok]
  - btn("Precedent") [ok]
  - btn("Suivant") [ok]
- formulaire_recherche (avec valeurs conservees) [ok]
- bouton_retour [ok]
### code dynamique :
- POST(nom, dept, min, max) [ok]
- POST(offset) [ok]
- rechercher(nom, dept, min, max, offset) [ok]
- limit = 20 [ok]
- calcul offset_prec / offset_suiv [ok]
- has_prev / has_next [ok]
- foreach(tableau[]) [ok]
- link(employer_ls_depart.php?dept_no) [ok]
- link(fiche_empl.php?emp_no) [ok]
- pagination POST (hidden inputs) [ok]
### fonctions :
- rechercher(nom, dept, min, max, offset) (JOIN dept_emp + departments + employees + LIMIT) [ok]


## statistiques.php
### affichage :
- resultats[]
  - emploi [ok]
  - hommes [ok]
  - femmes [ok]
  - total [ok]
  - salaire_moyen [ok]
- tableau_bootstrap [ok]
- bouton_retour [ok]
- formulaire_recherche [ok]
### code dynamique :
- statistiques_emploi() [ok]
- foreach(resultats[]) [ok]
- number_format(salaire_moyen) [ok]
### fonctions :
- statistiques_emploi() (COUNT hommes/femmes + AVG salary par title) [ok]


## devenir_manager.php
### affichage :
- titre("Devenir Manager") [ok]
- manager_actuel [ok]
  - first_name [ok]
  - last_name [ok]
  - from_date [ok]
- employee_name [ok]
- input(date_debut) [ok]
- btn("Valider") [ok]
- message_erreur_date [ok]
- navbar [ok]
### code dynamique :
- GET(emp_no, dept_no) [ok]
- fiche_employe(emp_no) [ok]
- manager_actuel_info(dept_no) [ok]
- POST(date_debut) [ok]
- IF(date_debut <= date_manager) [ok]
- ELSE ajouter_manager(dept_no, emp_no, date_debut) [ok]
- redirect index.php [ok]
### fonctions :
- manager_actuel_info(dept_no) (JOIN dept_manager + employees WHERE to_date='9999-01-01') [ok]
- ajouter_manager(dept_no, emp_no, from_date) (UPDATE ancien + INSERT nouveau) [ok]
- fiche_employe(emp_no) [ok]


## changer_dept.php
### affichage :
- tsy misy (traitement uniquement)
### code dynamique :
- POST(emp_no, new_dept, date_debut, date_actuelle) [ok]
- IF(date_debut < date_actuelle) [ok]
  - redirect fiche_empl.php?erreur=date_anterieure [ok]
- ELSE [ok]
  - modif_depart_employe(emp_no, new_dept, date_debut) [ok]
  - redirect fiche_empl.php?emp_no [ok]
- exit() [ok]
### fonctions :
- modif_depart_employe(emp_no, new_dept_no, from_date) (UPDATE ancien + INSERT nouveau) [ok]


## function.php
### affichage :
- tsy misy
### code dynamique :
- dbconnect() [ok]
- static $connect [ok]
- mysqli_connect(localhost, root, '', employees) [ok]
- mysqli_set_charset(utf8mb4) [ok]
- return $connect [ok]
### fonctions :
- dbconnect() [ok]
- ls_depart() [ok]
- depart(dept_no) [ok]
- manager_dept(dept_no) [ok]
- ls_employes_dept(dept_no) [ok]
- fiche_employe(emp_no) [ok]
- dept_employe(emp_no) [ok]
- dept_no_employe(emp_no) [ok]
- historique_salaire(emp_no) [ok]
- rechercher(nom, dept, min, max, offset) [ok]
- statistiques_emploi() [ok]
- emploi_plus_long(emp_no) [ok]
- manager_actuel_info(dept_no) [ok]
- ajouter_manager(dept_no, emp_no, from_date) [ok]
- modif_depart_employe(emp_no, new_dept_no, from_date) [ok]



## VERSIONS DU PROJET


### Version 1 — Liste des departements
- [x] 1.1 Page qui affiche la liste des departements
- [x] 1.2 Colonne qui affiche le nom du manager en cours
- [x] 1.3 Lien sur chaque ligne pour afficher la liste des employes du departement

### Version 2 — Fiche employe & Recherche
- [x] 2.1 Au clic sur un employe, afficher sa fiche
- [x] 2.2 Historique du salaire dans la fiche
- [x] 2.3 Historique de l'emploi occupe dans la fiche
- [x] 2.4 Formulaire de recherche (departement, nom employe, age min et max)
- [x] 2.5 Afficher seulement 20 lignes (LIMIT en SQL)
- [x] 2.6 Lien "Suivant" pour afficher les 20 prochaines lignes
- [x] 2.7 Lien "Precedent" pour afficher les 20 lignes precedentes

### Version 3 — Stats & Emploi le plus long
- [ ] 3.1 Ajouter une colonne nombre employe sur la liste des departements [MANQUE]
- [x] 3.2 Page stats : nombre employes (homme et femme) par emploi
- [x] 3.3 Page stats : salaire moyen pour chaque emploi
- [x] 3.4 Dans la fiche employe, mettre l'emploi le plus long (en terme de date)

### Version 4 — Changement de departement & Manager
- [x] 4.1 Bouton "Changer de departement" dans la fiche employe
  - [x] 4.1a Formulaire (choix departement, date de debut)
  - [x] 4.1b Verifier que le nouveau departement s'affiche bien apres l'ajout
  - [x] 4.1c Departement actuel + date de debut en haut du formulaire
  - [x] 4.1d Ne pas mettre le departement actuel dans la zone de liste
  - [x] 4.1e Message d'erreur si date de debut antérieure a la date actuelle
- [x] 4.2 Bouton "Devenir Manager" dans la fiche employe
  - [x] 4.2a Formulaire (Date de debut)
  - [x] 4.2b Verifier dans la liste des departements qu'il est bien le nouveau manager
  - [x] 4.2c Nom du manager en cours en haut du formulaire
  - [x] 4.2d Message d'erreur si date de debut antérieure a la date du manager actuel

