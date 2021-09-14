# Symfony

test du readme
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


## AUTHENTICATION

Liste des commande de l'authentication :

``` symfony
symfony console make:user
```
pour créer un user tout bien avec symfony, il crée tout ce qu'il faut et implémente l'user interface

``` symfony
symfony console make:auth
```
pour faire de l'authentification

``` symfony
symfony console make:registration-form
```
pour créer un formulaire d'authentification
