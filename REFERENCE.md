
[← README.md](README.md)

---

# REFERENCE

### DockerLocal Commands

If you want to keep using `DockerLocal` for the project, use:

```
./site-up                               # start up the containers
./site-up -c=yourproject_db             # start up and create a local mysql database
./site-up -l=yourproject_db             # start up and use existing local mysql database
./site-down                             # shut down the containers
./site-ssh -h=web                       # ssh into your web container at /var/www/site/ as www-data
./site-ssh -h=webroot                   # ssh into your web container at /var/www/ as root
./site-ssh -h=web -c='ls /var/www/site' # send command to web container as root
./site-ssh -h=mysql                     # ssh into mysql container, and into the mysql program as root
./site-ssh -h=mysqlroot                 # ssh into mysql container as root
```

#### Docker - Tinker

This repo contains a `commands/site-tinker` that was copied over into DockerLocal/commands.

```
./site-tinker
```

This will allow you to get right into tinker. If you wanted to do it manually, it would be like this

```
cd DockerLocal/commands
./site-ssh -h=webroot
cd site/app
php artisan tinker
```

Remember to "restart" tinker if you have changes to any job queues in your laravel app.

[← README.md](README.md#contents)

## DockerLocal - use Artisan

This repo contains a `commands/site-artisan` that was copied over into DockerLocal/commands.

```
./site-artisan
# You then can type:
php artisan ...
```

This `site-artisan` command is just a shortcut for:

```
./site-ssh -h=web
cd app
```

**Note:** You cannot run `php artisan tinker` from www-data - it will complain. See [`./site-tinker`](#docker---tinker) for shortcut command or manual commands.

[← README.md](README.md#contents)

#### Docker - Artisan

Read more about [DockerLocal](https://github.com/amurrell/DockerLocal) to learn:

- how to use a consistent port (other than default 3000)
- use ProxyLocal with the project to have a domain instead of localhost:port locally
- how to use a remote db to get a dump into a local mysql db
- how to tailor the DockerFile, nginx.site.conf, php7-fpm.site.conf, and envvars to your needs


[← README.md](README.md#contents)

---

### IDE helper (dev)

To get the best IDE doc support, use the IDE helper: https://github.com/barryvdh/laravel-ide-helper

```
#ssh into your DockerLocal project where composer is installed: cd DockerLocal/commands && ./site-ssh -h=web
composer require --dev barryvdh/laravel-ide-helper
```

And register it in non-production environments in `app/Providers/AppServiceProvider.php` in the `register` method:

```
if ($this->app->environment() !== 'production') {
    $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
}
```

Generate Docs:

```
php artisan clear-compiled #clears whats in bootstrap/compiled.php
php artisan ide-helper:generate # generate the docs
php artisan optimize #run after to optimize it
```

[← README.md](README.md#contents)
