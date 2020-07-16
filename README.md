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

## Exemple de fichier `.env.local`

    APP_ENV=dev
    DATABASE_URL=mysql://dba:123@127.0.0.1:3306/src_symfony_4_4_p6?serverVersion=mariadb-10.3.22
    DISABLE_HTML5_VALIDATION=false

## Le paramètre `DISABLE_HTML5_VALIDATION`

Ce paramètre permet de désactiver la validation dans tous les formulaires.

Si vous voulez que la validation des formulaires soit désactivée quand vous lancez des tests, créez un fichier `.env.test.local` avec le contenu suivant :

    DISABLE_HTML5_VALIDATION=true
