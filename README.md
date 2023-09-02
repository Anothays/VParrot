# STUDI - ECF fin 2023 - Garage V.Parrot

## Lien vers le site déployé
https://garagevp-97323ab9b838.herokuapp.com/

## Pour se connecter en tant qu'admin
| Email| Mot de passe|
| vincentParrot@VP.com | %7913%!Ya!$cnS7s2 | 

## Pour éxécuter le site en local
- cloner le projet sur votre machine ==> `git clone https://github.com/Anothays/VParrot.git cd Garage_V_Parrot`
- Dans le fichier .env, définir la variable d'environnement DATABASE_URL en fonction de votre système de gestion de base de donnée
- installer les dépendances ==> `composer install`
- Création de la base de données ==> `symfony console doctrine:database:create`
- initialisation de la base de données ==> `symfony console doctrine:migrations:migrate`
- Insertion de données fictives (voitures, comptes utilisateurs, témoignages, messages de contact) et du compte admin ==> `symfony console doctrine:fictures:load` 


## Technologies utilisées
- languages => PHP 8.1 et Javascript
- Framework => Symfony 6.3
- Système de gestion de base de données => Mysql
- ORM => doctrine
- moteur de template HTML => Twig
- Style => Boostrap
- gestionnaires de dépendance => composer & npm
- server web => Apache2
