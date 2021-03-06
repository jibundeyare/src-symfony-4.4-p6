<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/symfony4.php';

option('all-fixtures', 'a', InputOption::VALUE_NONE, 'Load all fixtures');

set('repository', 'https://github.com/jibundeyare/src-symfony-4.4-p6.git');

// hosts

host(getenv('ssh_host'))
    ->stage('prod')
    ->port(getenv('ssh_port'))
    ->user(getenv('ssh_user'))
    // user the web server runs as. If this parameter is not configured, deployer try to detect it from the process list.
    ->set('http_user', getenv('ssh_user'))
    // projects directory
    ->set('projects_dir', 'projects')
    // projects name
    ->set('application', 'src-symfony-4.4-p6')
    ->set('deploy_path', '~/{{projects_dir}}/{{application}}');

// set default stage
set('default_stage', 'prod');

// [optional] allocate tty for git clone. Default value is false.
set('git_tty', true);

// shared files / dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// writable mode
//
// - acl (default) use setfacl for changing ACL of dirs.
// - chmod use unix chmod command,
// - chown use unix chown command,
// - chgrp use unix chgrp command,
set('writable_mode', 'chmod');

// whether to use sudo with writable command. Default to false.
set('writable_use_sudo', false);

// tasks

desc('Test deployer');
task('test:hello', function () {
    writeln('Hello world');
});

desc('Get server hostname');
task('test:hostname', function () {
    $result = run('cat /etc/hostname');
    writeln("$result");
});

desc('Copy .env.{{stage}}.local as .env.local');
task('deploy:env', function () {
    upload('.env.{{stage}}.local', '~/{{projects_dir}}/{{application}}/shared/.env.local');
});

desc('Load fixtures');
task('fixtures:load', function () {
    $allFixtures = null;

    if (input()->hasOption('all-fixtures')) {
        $allFixtures = input()->getOption('all-fixtures');
    }

    if ($allFixtures) {
        if (get('stage') == 'prod') {
            writeln("Loading all fixtures");
            $result = run('{{bin/console}} doctrine:fixtures:load --no-interaction --append');
            writeln("$result");
        } else { // get('stage') != 'prod'
            writeln("Loading all fixtures");
            $result = run('{{bin/console}} doctrine:fixtures:load --no-interaction --purge-with-truncate');
            writeln("$result");
        }
    } else {
        if (get('stage') == 'prod') {
            writeln("Loading required fixtures");
            $result = run('{{bin/console}} doctrine:fixtures:load --no-interaction --group=required --append');
            writeln("$result");
        } else { // get('stage') != 'prod'
            writeln("Loading test fixtures");
            $result = run('{{bin/console}} doctrine:fixtures:load --no-interaction --group=test --purge-with-truncate');
            writeln("$result");
        }
    }
});

desc('Rollback database');
task('database:rollback', function () {
    $options = '--allow-no-migration';
    if (get('migrations_config') !== '') {
        $options = sprintf('%s --configuration={{release_path}}/{{migrations_config}}', $options);
    }
    run(sprintf('{{bin/console}} doctrine:migrations:migrate prev %s', $options));
});

// install and build front end dependencies
task('deploy:npm', function() {
    run('cd {{release_path}} && npm install 2>&1');
    run('cd {{release_path}} && npm run build 2>&1');
});

// reload services
// @warning requires a user with permission to reload services without using a password
task('reload:services', function() {
    run('sudo /bin/systemctl reload apache2');
    run('sudo /bin/systemctl reload php7.4-fpm');
});

// triggers

before('deploy:symlink', 'database:migrate');
before('deploy:symlink', 'deploy:npm');

after('deploy:symlink', 'reload:services');
// [optional] if deploy fails, unlock automatically
after('deploy:failed', 'deploy:unlock');

