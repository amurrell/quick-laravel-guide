# Laravel

Just a quick install/config guide to get started with Laravel (using DockerLocal).

### Quick Install (New Project)

If just want to get a NEW Laravel app running with [DockerLocal](https://github.com/amurrell/DockerLocal), do the following:

```
cd DockerLocal/commands
./site-up
./site-ssh -h=web
cd site/commands
./install-laravel-installer
cd ../
laravel new app
```

Now you can add your own git remote and save this as your own repository for working on this new project "app".

**TIP:** Read the readme in `DockerLocal/` to learn how to use [DockerLocal](https://github.com/amurrell/DockerLocal). to up, down, or ssh into your project.

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
```

### Example 2: Using DockerLocal ... & Install-Laravel-Installer

```
cd code/my-project/DockerLocal/commands && ./site-up && ./site-ssh -h=web
cd /var/www/site/commands
./install-laravel-installer
```

Now can use laravel command to make new app in `/var/www/site`

``` 
cd /var/www/site/
laravel new app-folder-name
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