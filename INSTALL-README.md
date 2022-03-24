# Quick Laravel Guide

Create or maintain laravel apps with alternative **local development tool [DockerLocal](https://github.com/amurrell/DockerLocal)**.

Here's an example:

```
# Setup
git clone git@github.com:amurrell/quick-laravel-guide.git yourproject
cd yourproject/commands
./install-quick-laravel -l=9.\* -p=3030 -v=8.0 -m=mariadb:10.6

# Add your own repo; remove quick-laravel
git remote rename origin quick-laravel
git remote add origin git@github.com:YOU/your-new-repo.git
git remote remove quick-laravel

# Make all your edits tailored to your project now!
git add -A
git commit -m "Setup project with quick-laravel-guide"
git push origin

# Visit your site - note, nothing else can be running on Port 80!
http://localhost:3030
```


### Ideal for:

- setting up a new or existing laravel apps with an **alternative solution (docker containers) for local development**
- **linux** users who cannot use the mac only tools to spin up laravel projects quick
- support **a team of engineers with local development tooling** - running mac (tested with Catalina) or linux (tested with ubuntu)

---

## Contents

- [Comes with...]()
- [Quickest Install](#quickest-install-new-project)
    - [DockerLocal Reqs](#dockerlocal-requirements)
    - [Existing Laravel Project?](#existing-laravel-project)
    - [Install Command Options](#install-command-options)
    - [Add your own Repo](#add-your-own-repo)
    - [Project Config Requirements:](#project-config-requirements)
    - [App is running, now setup database connection](#app-is-running-run-migrate-scripts)
        - [Setup Database Conn in .env](#db-env-vars)
        - [Run Migrations](#migrate)
        - [Mysql in CLI](#ssh-into-your-db)
        - [Troubleshoot](#troubleshoot-db-connection)
    - [Shutdown & Startup](#shutdown--startup)
- [Reference](REFERENCE.md)
    - [DockerLocal Commands](REFERENCE.md#dockerlocal-commands)
        - [Tinker](REFERENCE.md#tinker)
        - [Artisan](REFERENCE.md#artisan)
    - [IDE Helper](REFERENCE.md#ide-helper-dev)
    - [Manual Guide](GUIDE.md)

---

## Comes with:

### Initializing scripts to setup a new or existing laravel app with DockerLocal

- Installs gitmodule DockerLocal, uses Dockerlocal to install composer, runs composer in Docker web container
- Sets up local environment [with options you give it](#install-command-options) for:
    - laravel version (if new app),
    - PHP version,
    - MariaDB or Mysql docker image & version
- Handles 777 permissions on app/storage and app/bootstrap - and proper chownership of files
- Adds `site-tinker` and `site-artisan` commands to DockerLocal commands

### Local Development via DockerLocal
- Pre-loaded with laravel (8) requirements (exts: OpenSSL, PDO, Mbstring, Tokenizer, XML)
- Fully [customizeable DockerFile](https://github.com/amurrell/DockerLocal#dockerlocaldockerfile-template)
- [Versioning is easily customizable](https://github.com/amurrell/DockerLocal#version-overrides): PHP, Ubuntu, DB image (mysql/mariadb)
- Set PHP env vars, custom nginx file, etc. - [See Documentation](https://github.com/amurrell/DockerLocal#contents).
- [Easy commands](https://github.com/amurrell/DockerLocal#commands) to start, stop, import/export databases, ssh into any container (mysql, web, etc)

[↑](#contents)

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
./install-quick-laravel # wait! see options!

# this is an example
# ./install-quick-laravel -l=9.\* -p=3030 -v=8.0 -m=mariadb:10.6
```

> Skip to [Install Options](#install-command-options)

### Existing Laravel Project

Oh! Okay, that works, too.

First, copy your entire laravel project to a folder called app, like this:

```
this-project
    - app <--- This is your laravel app - the entire laravel folder here.
        - composer.json should be here!
    - commands
    - html
    - README.md
```

> #### Keep in mind
> You will also want to [setup this project under your own git tracking](#add-your-own-repo). This way of setting up a project, where the laravel framework is inside the git repo helps us maintain documentation, local dev, and other configurations in the repository, instead of just the project itself. It is suggested to not track the original quick-laravel-guide project once it is installed!

Then, use the options (ignoring laravel version, since that applied to installs only) to setup your DockerLocal environment for you.

```
./install-quick-laravel # wait! see options!
```

### Install Command Options

You can use any of these options, together, or seperate.

Defaults are: `laravel 8.*; no db; port 3000; php 7.4; mariadb:10.5.8` - note that mariadb works for m1 chips, mysql does not.

```
./install-quick-laravel -l=5.8.\*                                            # install laravel to this version
./install-quick-laravel -c=database_name                                    # setup a db;
./install-quick-laravel -c=database_name -p=3002                            # setup a db; use port 3002
./install-quick-laravel -c=database_name -p=3002 -v=7.3                     # setup a db; use port 3002; use php 7.3
./install-quick-laravel -c=database_name -p=3002 -v=7.3 -m=mysql            # setup a db; use port 3002; use php 7.3; use docker image mariadb at version 10.6
```

> Note: You need to escape `*` chars in commands with a `\`

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
```

Delete quick-laravel?

```
git remote remove quick-laravel
git remote -v #list them all again
```

You may want to remove quick-laravel commit history too

```
# create history-less branch
git checkout --orphan temp_branch

# add all the files
git add -A

# your initial commit message
git commit -am "The initial setup of my project, based on quick-laravel-guide"

# delete original branches
git branch -D master
git branch -D main

# rename your temp_branch
git branch -m main

# if you have an origin main, this will force push, with cleared history
git push -f origin main
```

[↑](#contents)

---

## Project Config Requirements:

- make sure you copy `app/.env-example` to `.env`
- make sure you add a 32 char length random string to `.env` under app_key via `php artisan key:generate`, if it is missing
    - newer versions of laravel do this for you as a post composer command.
- make sure your nginx root path is pointing to the `app/public` folder (the installer will set it in DockerLocal/web-server-root with `/var/www/site/app/public`, where it is relative to the container's path, not your computer)
- make sure that `app/storage` and `app/bootstrap` are `chmod 777` so that laravel can write to them. (The installer does this for you, in the Docker container)

---

## App is running, run migrate scripts

### DB Env Vars
You need to first setup your database connection in `app/.env`.
If you ran the installer, at the end of the script it will have told you the env vars. If you forgot, you can see them here:

```
cd your-project/commands
./show-db-envvars
```

Copy the values into your `app/.env`.


### Migrate

Test your database connection by running the migration scripts (resources/database/migrations) (after editing your app/.env file to db connection info).

```
cd your-repo/DockerLocal/commands
./site-ssh -h=web
cd app
php artisan migrate
```

### SSH into your DB

You can also ssh into your database and run commands there:

```
cd DockerLocal/commands
./site-ssh -h=mysql
show databases;
use yourdb;
```

### Troubleshoot DB Connection

If your DB is constantly restarting (perhaps from trying a bunch of different versions out):

```
cd DockerLocal/commands
./site-down

docker volume ls

# look for one that matches the pattern
# `dockerlocal<PORT>_mysql-data-<PORT>`

docker volume rm dockerlocal3040_mysql-data-3040

./site-up
```

---

## Shutdown & Startup

You can turn this project off with: `./site-down`

Turn the project on again with: `./site-up` (note, [re-run nvm-pm2](https://github.com/amurrell/DockerLocal#dockerlocalecosystemconfigjs) if using that)

In addition, see other [common DockerLocal commands](REFERENCE.md#dockerlocal-commands).

**Troubleshoot**

1. Try `./site-down` before doing `./site-up`

    If you run into issues not being able to ./site-up without errors or containers failing, then run `./site-down` first.

    Sometimes even though it seems like DockerLocal is off (ex: from rebooting your machine), not all containers were properly shutdown (like ones controlling shared volumes and network bridge.) Doing a `./site-down` will ensure that everything got turned off and can then be turned back on.

2. Try `./site-up` twice

    If you have ran `./site-down` and your `./site-up` command fails, try running `./site-up` one more time, after confirming that your ProxyLocal is running.

    This could be needed due to both your ProxyLocal and DockerLocal being shut off. The site-up command will try to bring ProxyLocal back up for you.

    This could create a race condition where DockerLocal is trying to load before ProxyLocal is fully done starting.

[↑](#contents)
