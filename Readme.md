# Symfony

test du readme

## pour Pull le repo

**$ composer install ** 
pour installer toutes les dépendances 

**$ bin/console doctrine:schema:update --force **
pour créer la base de donnée par rapport aux entités

## Command Utilisé 

```
symfony console symfony console doctrine:migrations:dump-schema :
```
pour créer la première version de notre bdd dans un fichier php

 ```       
symfony console doctrine:migrations:diff :
```
        pour créer une nouvelle version de notre bdd dans un fichier php

```
symfony console doctrine:migrations:migrate  :
```
        pour créer notre dbb dans le server

```
symfony console doctrine:migrations:execute  :
```
        pareil mais on peut choisir la version de notre bdd

bin/console doctrine:schema:update 
    pour vérifier les changements avant de les implémenter dans la base de données

bin/console doctrine:schema:update --force : 
    pour récupérer les changements dans la base de données quand on est en phase de dev


## AUTHENTICATION

Liste des commande de l'authentication :

``` symfony
symfony console make:user
```


pour créer un user tout bien avec symfony, il crée tout ce qu'il faut
                        et implémente l'user interface

pour créer un user tout bien avec symfony, il crée tout ce qu'il faut et implémente l'user interface

``` symfony
symfony console make:auth
```
pour faire de l'authentification

```

symfony console make:crud
pour créer toute les pages pour une entité

``` symfony
symfony console make:registration-form
```
pour créer un formulaire d'authentification



aller voir dans src Twig pour le filtre