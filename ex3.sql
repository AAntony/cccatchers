SET lc_time_names = 'fr_FR';
SELECT t2.wd as jour, AVG(t2.c) as moyenne
FROM (
    SELECT DATE_FORMAT(created_at, "%W") as wd, COUNT(*) as c
    FROM calls
    WHERE 1
    AND MONTH(created_at) = 5
    AND YEAR(created_at) = 2015
    GROUP BY created_at
) as t2
GROUP BY t2.wd;

/*
Pour le procédé, il fallait une moyenne du nombre d'appels par jour, 
chose qu'il n'y avait pas dans la table. Il fallait donc faire une sous-requête, 
qui renverrait le nombre d'appels par jours (en gardant la distinction des jours de la semaine). 
C'est la sous-requête t2 qui est dans le FROM. 
À partir de cette sous-requête t2, il ne restait plus qu'à regrouper par jour de la semaine et calculer la moyenne du nombre d'appels.
*/

/* TEMPS DE TRAVAIL ESTIMÉ : +/- 40 min */
