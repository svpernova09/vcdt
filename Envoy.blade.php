@servers(['web' => ['joeferguson@jameson.joeferguson.me']])

@task('deploy', ['on' => 'web'])
cd /home/joeferguson/domains/vcdt.joeferguson.me/vcdt
git pull origin master
composer install --no-dev
php artisan migrate --force
@endtask
