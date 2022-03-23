
[← README.md](README.md)

---

# GUIDE

This manual guide was provided as part of the original repo, and it is left here in case anyone wants to know how to manually do what is automated in the installer. *(This means this guide is old and not maintained!).*

Use it as inspiration for your own endeavors, perhaps.

---

## Contents

First, do these steps:

- [Global Install with Laravel Installer via Composer](#globally-install-the-laravel-installer-via-composer)
- [Edit your PATH to include composer bin files (like laravel)](#edit-path-to-include-composer-bin-files-like-laravel)

Then, see these examples:

- Example 1: [Using DockerLocal for local dev (with composer installed) and manual steps](#example-1-using-dockerlocal-for-local-dev-with-composer-installed-and-manual-steps)
- Example 2: [Using DockerLocal ... & install-Laravel-Installer but not install-quick-laravel](#example-2-using-dockerlocal---install-laravel-installer-but-not-install-quick-laravel)

Reference these post-install steps:

- [Project Config Requirements](#project-config-requirements)
- [Migrations](#app-is-running-run-migrate-scripts)


[← README.md](README.md)

---

## Globally install the laravel installer via composer

- `composer global require "laravel/installer"`

[↑](#contents)

---

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

[↑](#contents)

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

[↑](#contents)

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

[↑](#contents)

---


## Project Config Requirements:

- make sure you copy `app/.env-example` to `.env`
- make sure you add a 32 char length random string to `.env` under app_key via `php artisan key:generate`, if it is missing
    - newer versions of laravel do this for you as a post composer command.
- make sure your nginx root path is pointing to the `app/public` folder (the installer will set it in DockerLocal/web-server-root with `/var/www/site/app/public`, where it is relative to the container's path, not your computer)
- make sure that `app/storage` and `app/bootstrap` are `chmod 777` so that laravel can write to them. (The installer does this for you, in the Docker container)

[↑](#contents)

---

### App is running, run migrate scripts

Test your database connection by running the migration scripts (resources/database/migrations) (after editing your app/.env file to db connection info).

Using DockerLocal,

```
cd your-repo/DockerLocal/commands
./site-ssh -h=web
cd app
php artisan migrate
```

[↑](#contents)
