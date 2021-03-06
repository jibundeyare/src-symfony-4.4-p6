# Symfony 4.4

Projet blog

## Install

    git clone https://github.com/jibundeyare/src-symfony-4.4-p6
    cd src-symfony-4.4-p6
    # créer un fichier .env.local
    composer install
    php bin/console do:da:cr
    php bin/console do:mi:mi
    npm install
    npm run dev
    # ou si vous utilisez yarn
    # yarn install
    # yarn encore dev
    symfony serve

## Exemple de fichier `.env.local`

    APP_ENV=dev
    DATABASE_URL=mysql://dba:123@127.0.0.1:3306/src_symfony_4_4_p6?serverVersion=mariadb-10.3.22
    DISABLE_HTML5_VALIDATION=false

## Injecter les fixtures dans la BDD

La première fois :

    php bin/console ha:fi:lo

Les fois suivantes, vous êtes obligés de détruire la BDD, de la reconstruire pour de réinjecter les fixtures (si ous voulez que les id soient les mêmes) :

    php bin/console do:da:dr
    php bin/console do:da:cr
    php bin/console do:mi:mi
    php bin/console ha:fi:lo

Si vous trouvez ça long à taper, vous pouvez utiliser un script qui effectues les mêmes opérations :

    bin/hafilo.sh

## Le paramètre `DISABLE_HTML5_VALIDATION`

Ce paramètre permet de désactiver la validation dans tous les formulaires.

Si vous voulez que la validation des formulaires soit désactivée quand vous lancez des tests, créez un fichier `.env.test.local` avec le contenu suivant :

    DISABLE_HTML5_VALIDATION=true

## Tester la connexion à l'API avec authentification par token

Le token de l'utilisateur `api-user@example.com` est `phaath5aip9yee4ooviSoareeSohthies` (voir le fichier des users dans le dossier `fixtures`).

Pour tester l'api, on peut utiliser `curl` :

    curl --insecure --header "X-AUTH-TOKEN: phaath5aip9yee4ooviSoareeSohthies" https://localhost:8000/api/

Ou `httpie` :

    http --verify no https://localhost:8000/api/ X-AUTH-TOKEN:phaath5aip9yee4ooviSoareeSohthies

`httpie` avec les entêtes HTTP de la requête :

    http --verify no --verbose https://localhost:8000/api/ X-AUTH-TOKEN:phaath5aip9yee4ooviSoareeSohthies

## Le déploiement

### Pré-requis

En local :

- l'outil de déploiement `deployer`
- une connexion `ssh` vers un serveur

Sur le serveur :

- le serveur web `apache2`
- le serveur d'application `php7.4-fpm`
- le serveur de données `mariadb`
- le gestionnaire de package back-end `composer`
- le gestionnaire de package front-end `npm`
- le gestionnaire de code source `git`
- un compte utilisateur qui a la permission de recharger des services sans utiliser de mot de passe

### Permission de recharger des services sans utiliser de mot de passe

Pour attribuer la permission à l'utilisateur `foo` :

    sudo visudo -f /etc/sudoers.d/foo

Puis ajouter la ligne suivante dans le fichier et enregistrer :

    foo ALL=(ALL) NOPASSWD: /bin/systemctl reload apache2,/bin/systemctl reload php7.4-fpm

### Création du fichier `.env.test.local` ou `.env.prod.local`

Pour le serveur de test, `.env.test.local` :

    APP_ENV=test
    DISABLE_HTML5_VALIDATION=true
    DATABASE_URL=mysql://dba:123@127.0.0.1:3306/src_symfony_4_4_p6?serverVersion=mariadb-10.3.22

Pour le serveur de prod, `.env.prod.local` :

    APP_ENV=prod
    DATABASE_URL=mysql://dba:123@127.0.0.1:3306/src_symfony_4_4_p6?serverVersion=mariadb-10.3.22

### Définir les identifiants de connexion SSH

#### Linux

    ssh_host=example.com
    ssh_user=foo
    ssh_port=22

#### Windows

    set ssh_host=example.com
    set ssh_user=foo
    set ssh_port=22

### Premier déploiement

    dep deploy:prepare
    dep deploy:env
    dep deploy

### Déploiements suivants

    dep deploy

### Exemple de premier déploiement sur Linux

    ssh_host=example.com
    ssh_user=foo
    ssh_port=22
    dep deploy:prepare
    dep deploy:env
    dep deploy

### Exemple d'autres déploiements sur Linux

    ssh_host=example.com ssh_user=foo ssh_port=22 dep deploy

