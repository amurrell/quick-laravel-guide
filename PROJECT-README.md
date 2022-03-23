# My Project

This is a laravel project that is using DockerLocal (a docker containers project) for local development.

It is encouraged to update this readme!

---

## Contents

- [Setup Project](#setup-project)
    - [DockerLocal Reqs](#dockerlocal-requirements)
    - [Install Command Options](#install-command-options)
    - [Add your own fork](#add-your-own-fork)
- [Reference](REFERENCE.md)
    - [DockerLocal Commands](REFERENCE.md#dockerlocal-commands)
        - [Tinker](REFERENCE.md#tinker)
        - [Artisan](REFERENCE.md#artisan)
    - [IDE Helper](REFERENCE.md#ide-helper-dev)
    - [Quick Laravel Installer](REFERENCE.md#quick-laravel-installer)

---

## Setup Project

To setup this project for local development, do the following:

### DockerLocal Requirements

Ensure you have met these DockerLocal requirements.

- Docker (Tested with Docker version 17.03.1-ce, build c6d412e)
- Docker-Compose (Tested with docker-compose version 1.12.0, build b31ff33) (use `docker-compose disable-v2` in terminal to downgrade to 1.+)
- Bash 4+ (MacOS default 3.2.57, needs [brew install](https://github.com/amurrell/DockerLocal#update-bash-for-macos))

```
git clone [your repo] yourproject
cd yourproject/commands
./install-quick-laravel # see options!
```

### Install Command Options

A project admin should tell you these options or edit this readme with the specific choices made to initalize this project.

However, you can use any of these options, together, or seperate.

Defaults are: `no db; port 3000; php 7.4; mariadb:10.5.8` - note that mariadb works for m1 chips, mysql does not.

```
./install-quick-laravel -c=database_name                                    # setup a db;
./install-quick-laravel -c=database_name -p=3002                            # setup a db; use port 3002
./install-quick-laravel -c=database_name -p=3002 -v=7.3                     # setup a db; use port 3002; use php 7.3
./install-quick-laravel -c=database_name -p=3002 -v=7.3 -m=mysql            # setup a db; use port 3002; use php 7.3; use docker image mariadb at version 10.6
```

For local DNS (to run your sites like docker.mysite.com locally), you can use [ProxyLocal](https://github.com/amurrell/ProxyLocal).

### Add your own fork

Fork the project in your git tool, eg in Github.

You can add your own git remote and save this as your own repository for working on this project "app". Then you can make pull-requests from your fork to origin.

Before you begin - make sure the project is maintained with git tracking, outside of the original installer repo (quick-laravel-guide).

At the root of your project:

```
# List current remotes, noticing origin

git remote -v #list all remotes
```

If you see `quick-laravel-guide.git` - please [follow instructions to add your own git tracking source](INSTALL-README.md#add-your-own-repo) and remove this one!

Next, add yours:

```
git remote add me git@github.com:youruser/theproject.git
git fetch me
git remote -v #list all remotes again to see origin and me
```

[↑](#contents)

---

## Project Config Requirements:

- make sure you copy app/.env-example to .env - ask a project admin for this file, or for missing details.
- make sure you add a 32 char length random string to .env under app_key via `php artisan key:generate`, if it is missing - newer version of laravel do this for you as a post composer command.
- make sure your nginx root path is pointing to the app/public folder (DockerLocal is /var/www/site/app/public)
- make sure that app/storage and app/bootstrap are chmod 777 so that laravel can write to them.

[↑](#contents)

---

### App is running, run migrate scripts

Test your database connection by running the migration scripts (resources/database/migrations) (after editing your app/.env file to db connection info).

```
cd your-repo/DockerLocal/commands
./site-ssh -h=web
cd app
php artisan migrate
```

[↑](#contents)

---

### Shutdown & Startup

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
