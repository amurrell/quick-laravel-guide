# Laravel

For now just a quite install/config guide to get started with Laravel.

### Requirements

- PHP >= 7.0.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

---

## New Project

You only need to setup the laravel installer if you are making a NEW laravel project.

Make sure your environment has composer and then run the following to use the **Laravel Installer**.

- If using DockerLocal, `cd DockerLocal/commands && ./site-ssh -h=web` to ssh into your web container, which has composer.

- If your project has `commands/install-laravel-installer`, use that to automatically do the following steps.

**TIP:** Read the readme in `DockerLocal/`

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