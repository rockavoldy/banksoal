<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'banksoal API');

// Project repository
set('repository', 'git@github.com:rockavoldy/banksoal.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('dev.akhmad.id')
    ->set('user', 'deploy')
    ->port(2244)
    ->set('deploy_path', '~/data/wwwroot/dev.akhmad.id/ujian');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

task('reload:php-fpm', function () {
    run('sudo /usr/bin/systemctl reload php-fpm');
});

after('deploy', 'reload:php-fpm');
