
[← README.md](README.md)

---

# GUIDE

## Globally install the laravel installer via composer

- `composer global require "laravel/installer"`

## Edit Path to include composer bin files (like laravel)

### Linux (DockerLocal environment is using Ubuntu)

```
nano ~/.bashrc
# Type the following into the bottom of the file:
export PATH="$HOME/.composer/vendor/bin:$PATH"
# Refresh the file
. ~/.bashrc
```

### Mac OS

```
nano ~/.bash_profile
export PATH="$HOME/.composer/vendor/bin:$PATH"
```

Test is out, type `echo $PATH` in terminal


### Use "Laravel New"

- `cd /var/www/` or vhosts or similar code area in your environment
- `laravel new app` where app is the name of the folder you want to use for your laravel project.
- If using DockerLocal and ssh'd inside the web container, `cd /var/www/site/` and run this command to create the app folder there.

---

### Example 1: Using DockerLocal for local dev (with composer installed) and manual steps

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

[← README.md](README.md#contents)

---

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

[← README.md](README.md#contents)

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
