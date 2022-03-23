# Quick Laravel Guide

Just a quick install/config guide to create a laravel app wih alternative local development tool DockerLocal.

Ideal for:

- setting up a new laravel app using an alternative solution (docker containers) for local development
- **linux** users who cannot use the mac only tools to spin up laravel projects quick
- continuing to use the DockerLocal containers to work on your project, potentially with a small team of engineers using mac or ubuntu

Comes with:

- Initializing scripts to setup a new laravel app with DockerLocal
    - Installs gitmodule DockerLocal, uses Dockerlocal to install composer, runs composer in Docker web container
    - Changes permissions on app/storage and app/bootstrap
    - Local Development via DockerLocal -
        - Pre-loaded with laravel (8) requirements (exts: OpenSSL, PDO, Mbstring, Tokenizer, XML)
        - Fully [customizeable DockerFile](https://github.com/amurrell/DockerLocal#dockerlocaldockerfile-template)
        - Defaulted, but easily customizable:
            - [Ubuntu 20.04]()
            - PHP7.4
            - MariaDb 10.5.8
        - Easy scripts to start, stop, import/export databases, ssh into any container (mysql, web, etc)


---

## Contents

- [Quickest Install](#quickest-install-new-project)
    - [DockerLocal Reqs](#dockerlocal-requirements)
    - [Install Command Options](#install-command-options)
    - [Add your own Repo](#add-your-own-repo)
- [Guide](GUIDE.md)
- [Reference](REFERENCE.md)
    - [DockerLocal Commands](#dockerlocal-commands)
        - [Tinker](REFERENCE.md#tinker)
        - [Artisan](REFERENCE.md#artisan)
    - [IDE Helper](REFERENCE.md#ide-helper-dev)

---

## Quickest Install (New Project)

If you just want to get a **NEW** Laravel app running with [DockerLocal](https://github.com/amurrell/DockerLocal), do the following:

### DockerLocal Requirements

- Docker (Tested with Docker version 17.03.1-ce, build c6d412e)
- Docker-Compose (Tested with docker-compose version 1.12.0, build b31ff33) (use `docker-compose disable-v2` in terminal to downgrade to 1.+)
- Bash 4+ (MacOS default 3.2.57, needs [brew install](https://github.com/amurrell/DockerLocal#update-bash-for-macos))

```
git clone git@github.com:amurrell/quick-laravel-guide.git yourproject
cd yourproject/commands
./install-quick-laravel # see options!
```

### Install Command Options

You can use any of these options, together, or seperate.

Defaults are: `no db; port 3000; php 7.4; mariadb:10.5.8` - note that mariadb works for m1 chips, mysql does not.

```
./install-quick-laravel -c=database_name                                    # setup a db;
./install-quick-laravel -c=database_name -p=3002                            # setup a db; use port 3002
./install-quick-laravel -c=database_name -p=3002 -v=7.3                     # setup a db; use port 3002; use php 7.3
./install-quick-laravel -c=database_name -p=3002 -v=7.3 -m=mysql            # setup a db; use port 3002; use php 7.3; use docker image mariadb at version 10.6
```

For local DNS (to run your sites like docker.mysite.com locally), you can use [ProxyLocal](https://github.com/amurrell/ProxyLocal).

### Add your own repo

You can add your own git remote and save this as your own repository for working on this new project "app".

At the root of your project:

```
# List remotes, rename current to quick-laravel

git remote -v #list all remotes
git remote rename origin quick-laravel
git remote -v
```

Next, add yours & push:

```
git remote add origin git@github.com:youruser/yourproject.git
git fetch origin
git push origin
```

[↑](#contents)

---

## Project Config Requirements:

- make sure you copy app/.env-example to .env
- make sure you add a 32 char length random string to .env under app_key via `php artisan key:generate`
- make sure your nginx root path is pointing to the app/public folder (DockerLocal is /var/www/site/app/public)
- make sure that app/storage and app/bootstrap are chmod 777 so that laravel can write to them.

---

### App is running, run migrate scripts

Test your database connection by running the migration scripts (resources/database/migrations) (after editing your app/.env file to db connection info).

```
cd your-repo/DockerLocal/commands
./site-ssh -h=web
cd app
php artisan migrate
```
