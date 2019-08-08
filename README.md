# Quick Laravel Guide

Just a quick install/config guide to get started with Laravel (using DockerLocal).

Ideal for:

- setting up a new laravel app using docker containers
- **linux** users who cannot use the mac only tools to spin up laravel projects quick
- continuing to use the DockerLocal containers to work on your project

---

### Quickest Install (New Project)

If just want to get a **NEW** Laravel app running with [DockerLocal](https://github.com/amurrell/DockerLocal), do the following:

## DockerLocal Requirements

- Docker (Tested with Docker version 17.03.1-ce, build c6d412e)
- Docker-Compose (Tested with docker-compose version 1.12.0, build b31ff33)
- Bash 4+ (MacOS default 3.2.57, needs [brew install](https://github.com/amurrell/DockerLocal#update-bash-for-macos))

```
git clone git@github.com:amurrell/quick-laravel-guide.git yourproject
cd yourproject/commands
./install-quick-laravel
```

You can run `./install-quick-laravel -c=database_name -p=3002` for a database and port to get created with it. You can use [ProxyLocal](https://github.com/amurrell/ProxyLocal), too. 

Now you can add your own git remote and save this as your own repository for working on this new project "app".

```
git remote add upstream git@github.com:youruser/yourproject.git
git fetch upstream
git push upstream
```

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

Read more about [DockerLocal](https://github.com/amurrell/DockerLocal) to learn:

- how to use a consistent port (other than default 3000)
- use ProxyLocal with the project to have a domain instead of localhost:port locally
- how to use a remote db to get a dump into a local mysql db
- how to tailor the DockerFile, nginx.site.conf, php7-fpm.site.conf, and envvars to your needs

---

### Laravel Requirements

- PHP >= 7.0.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

---

### Manual Steps if not using above methods

#### Globally install the laravel installer via composer

- `composer global require "laravel/installer"`

#### Edit Path to include composer bin files (like laravel)

##### Linux (DockerLocal environment is using Ubuntu)

```
nano ~/.bashrc
# Type the following into the bottom of the file:
export PATH="$HOME/.composer/vendor/bin:$PATH"
# Refresh the file
. ~/.bashrc
```

##### Mac OS

```
nano ~/.bash_profile
export PATH="$HOME/.composer/vendor/bin:$PATH"
```

Test is out, type `echo $PATH` in terminal

#### Use "Laravel New"

- `cd /var/www/` or vhosts or similar code area in your environment
- `laravel new app` where app is the name of the folder you want to use for your laravel project.
- If using DockerLocal and ssh'd inside the web container, `cd /var/www/site/` and run this command to create the app folder there.

---

### Example 1: Using DockerLocal for environment (with composer installed) and manual steps

```
cd code/my-project/DockerLocal/commands && ./site-up && ./site-ssh -h=web
cd /var/www/
composer global require "laravel/installer"
nano ~/.bashrc
# type: export PATH="$HOME/.composer/vendor/bin:$PATH"
# reload bash config
. ~/.bashrc
echo $PATH
cd /var/www/site/
laravel new app
# change nginx.site.conf to point to /var/www/site/app/public && ./site-up
# change permissions on app/storage and app/bootstrap to 777
```

### Example 2: Using DockerLocal ... & install-Laravel-Installer but not install-quick-laravel

```
cd code/my-project/DockerLocal/commands && ./site-up && ./site-ssh -h=web
cd /var/www/site/commands
./install-laravel-installer
```

Now can use laravel command to make new app in `/var/www/site`

``` 
cd /var/www/site/
laravel new app-folder-name
# change nginx.site.conf to point to /var/www/site/app/public && ./site-up
# change permissions on app/storage and app/bootstrap to 777
```

---


## Project Config Requirements:

- make sure you copy app/.env-example to .env
- make sure you add a 32 char length random string to .env under app_key
- make sure your nginx root path is pointing to the app/public folder (DockerLocal is /var/www/site/app/public)
- make sure that app/storage and app/bootstrap are chmod 777 so that laravel can write to them.

---

### App is running, run migrate scripts

Test your database connection by running the migration scripts (resources/database/migrations) (after editing your app/.env file to db connection info).

```
cd your-laravel-project
php artisan migrate
```
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
