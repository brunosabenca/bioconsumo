<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'BioConsumo');

// Project repository
set('repository', 'git@github.com:brunosabenca/bioconsumo.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('ec2-18-224-22-153.us-east-2.compute.amazonaws.com')
    ->set('deploy_path', '/var/www/html/bioconsumo.brunosabenca');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
