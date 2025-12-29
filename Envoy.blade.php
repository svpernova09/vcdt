@servers(['prod' => 'vcdt@24.joeferguson.me'])

@task('deploy', ['on' => 'prod'])
cd /home/vcdt/vcdt
/usr/bin/php8.4 artisan down
git pull origin master
/usr/bin/php8.4 /usr/local/bin/composer install --no-dev
/usr/bin/php8.4 artisan migrate --force
/usr/bin/php8.4 artisan up
@endtask
