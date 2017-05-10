# Project Name Here

This document outlines some of the local development process.

## Development

This project uses a [fork](https://github.com/kalamuna/drupal-project/) of the [drupal-project](https://github.com/drupal-composer/drupal-project) repository. To get started, use the README instructions from the upstream repo (repeated below, see [Usage](#user-content-usage)). The main thing to know is that your database settings and any other sensitive (non-VCS) configuration lives in `settings.local.php` instead of `settings.php`.

## Composer usage

First you need to [install
composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer
> installation](https://getcomposer.org/doc/00-intro.md#globally). You might
> need to replace `composer` with `php composer.phar` (or similar) for your
> setup.

Once composer is installed you can setup the project by installing the required dependencies with the following command:

```
composer install
```

Alternatively, you can create a new project:

```
composer create-project drupal-composer/drupal-project:8.x-dev some-dir --stability dev --no-interaction
```

With `composer require ...` you can download new dependencies to your
installation. This is the desired approach to adding Drupal contrib modules to the project:

```
cd some-dir
composer require drupal/devel:~1.0
```


### What does the template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `web`-directory.
* Autoloader is implemented to use the generated composer autoloader in
  `vendor/autoload.php`, instead of the one provided by Drupal
  (`web/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed in
  `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed in
  `web/themes/contrib/`
* Profiles (packages of type `drupal-profile`) will be placed in
  `web/profiles/contrib/`
* Creates `sites/default/files`-directory.
* Latest version of drush is installed locally for use at `vendor/bin/drush`.
* Latest version of DrupalConsole is installed locally for use at
  `vendor/bin/drupal`.

### Updating Drupal Core

This project will attempt to keep all of your Drupal Core files up-to-date; the
project
[drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold)
is used to ensure that your scaffold files are updated every time drupal/core
is updated. If you customize any of the "scaffolding" files (commonly
.htaccess), you may need to merge conflicts if any of your modfied files are
updated in a new release of Drupal core.

Follow the steps below to update your core files.

1. Run `composer update drupal/core --with-dependencies` to update Drupal Core
   and its dependencies.
1. Run `git diff` to determine if any of the scaffolding files have changed.
   Review the files for any changes and restore any customizations to
   `.htaccess` or `robots.txt`.
1. Commit everything all together in a single commit, so `web` will remain in
   sync with the `core` when checking out branches or running `git bisect`.
1. In the event that there are non-trivial conflicts in step 2, you may wish to
   perform these steps on a branch, and use `git merge` to combine the updated
   core files with your customized files. This facilitates the use of a
   [three-way merge tool such as
   kdiff3](http://www.gitshah.com/2010/12/how-to-setup-kdiff-as-diff-tool-for-git.html).
   This setup is not necessary if your changes are simple; keeping all of your
   modifications at the beginning or end of the file is a good strategy to keep
   merges easy.
   
## Local environment(s)

### Docker

1. Install [Docker](https://www.docker.com/) and [Docker
   Composer](https://docs.docker.com/compose/)
2. Run `docker-compose up`
3. Visit [localhost:8000](http://localhost:8000) in your browser
4. Choose "Config Installer" as the Install Profile
5. The database settings are as follows:
   - Database name: `drupal`
   - Database username: `drupal`
   - Database password: `drupal`
   - Host: `mariadb`
6. Complete the installation
7. Move the database changes in web/sites/default/settings.php over to
   web/sites/default/settings.local.php

### Drupal VM

#### The bare minimum
After running `composer install` from the repo root (see [Composer
Usage](#composer-usage) below), run `vagrant up`. When provisioning completes,
the site should be available at [ftusa.dvm](http://ftusa.dvm), with the Drupal
VM dashboard available at [dashboard.ftusa.dvm](http://dashboard.ftusa.dvm).

#### Resources for using Drupal VM
*   The official [quickstart
    guide](https://github.com/geerlingguy/drupal-vm/#quick-start-guide)
*   The official [documentation](http://docs.drupalvm.com/en/latest/) site
*   Kalamuna's detailed [setup
    guide](https://github.com/kalamuna/drupal-vm/wiki), but note that much of
    the documentation doesn't apply to this project. E.g., disregard step 1 on
    the
    [installation](https://github.com/kalamuna/drupal-vm/wiki/1.-Installation)
    page.

#### Version requirements
_Note that as of late 2016, the version requirements are:_
*   Vagrant >1.8.6
*   VirtualBox >5.1.10
*   Ansible 2.2.*  
 
## Front End Development

### KalaStatic

KalaStatic is our front-end tooling platform. You'll find the configuration,
along with some documentation over at [kalastatic.yaml](kalastatic.yaml).

To use Kalastatic and interact with the prototype, you will need to run (Note: Drupal is not required to interact with Kalastatic):

```
npm start
```
Once Kalastatic has been started, you can visit the prototype at: [http://localhost:3000/kalastatic/index.html](http://localhost:3000/kalastatic/index.html)

The KSS pattern library (style guide) can be found at: [http://localhost:3000/kalastatic/styleguide/index.html](http://localhost:3000/kalastatic/styleguide/index.html)

Note: No need to run Drupal to use Kalastatic


## FAQ

### Should I commit the contrib modules I download?

**No**. Here's
[why](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

### What are "scaffolding files?"

The [drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold)
plugin downloads scaffold files (like index.php, update.php, …) to the web/
directory of the project. It runs automatically after every install or update
via the `@drupal-scaffold` post-install and post-update command in
composer.json:

```json
"scripts": {
    "drupal-scaffold": "DrupalComposer\\DrupalScaffold\\Plugin::scaffold",
    "post-install-cmd": [
        "@drupal-scaffold",
        "..."
    ],
    "post-update-cmd": [
        "@drupal-scaffold",
        "..."
    ]
},
```

### How can I apply patches to downloaded modules?

If you need to apply patches (depending on the project being modified, a pull 
request is often a better solution), you can do so with the 
[composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the extra 
section of composer.json:
```json
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL to patch"
        }
    }
}
