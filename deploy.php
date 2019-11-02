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
    ->user('ec2-user')
    ->port(22)
    ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path', '/var/www/html/bioconsumo.brunosabenca');

// Yarn
set('bin/yarn', function () {
    return run('which yarn');
});
task('yarn:install-and-build', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && {{bin/yarn}}");
    run('cd {{release_path}} && yarn production');
});
after('deploy:update_code', 'yarn:install-and-build');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
