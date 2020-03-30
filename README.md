# Kalamuna composer template for Drupal projects with CircleCI and Pantheon integration

This template is based on the [drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project) template, with additional tools and settings specific to the Kalamuna workflow.

The goal of this repository is to provide a clean installation with just the tools and files that we need for 95% of our Drupal projects. Alternate configurations, with lesser-used packages or frameworks, should be added as separate branches which can be used when needed for particular projects.

## Usage

### Create a new Github repo

Press the `Use this template` button in Github to create a new repository for your project based on this template, or clone this repository manually and remove the unneeded git history.

### Create Pantheon environment

1. Created a new pantheon site at [https://dashboard.pantheon.io/sites/create](https://dashboard.pantheon.io/sites/create), selecting the appropriate Organization.
1. When prompted to select an upstream, choose the Empty (Drupal 8) option, so the hidden framework variable on Pantheon is properly set to Drupal, and we have an empty git upstream.
1. ... If you were unable to select Empty, run `terminus site:upstream:set my-site-name empty` from your command line to remove the unneeded upstream after the site has been initialized, before transfering ownership
1. Add the Kalamuna Commit Bot `kalacommitbot@kalamuna.com` under the `Team` tab for the project (or an alternate account you'd like to use for pushing to pantheon).
1. Copy the location of the pantheon git repo, which is under `Connection info` (but remove everything in the `git clone` command but the actual url).

### Initialize CircleCI integration

1. Log into CircleCI and add your github repo as an active project.
1. Under the `environment variables` tab in the project settings, add the url for the destination repository to the `PANTHEON_REPO` variable.
1. In the project settings, find the place to add an ssh key (varies between old and new interface), and add the public key associated with the pantheon user you added above, using `drush.in` as the domain.

### Install the codebase and deploy

1. Clone the github repository locally and run `composer install` to install Drupal. (You may need to increase your memory limit or execute `php -d memory_limit=3G /path/to/composer install`.)
1. Commit the `composer.lock` file, and files that have been initialized for customization, like `robots.txt` and `settings.php`.
1. Run `npm it` to install the node modules, and commit the `package.lock` file to the repository.
1. Push the changes to github, and check that the CircleCI workflow executes properly and the code is pushed to pantheon.

### Configure Drupal:
1. Install Drupal in the Pantheon dev environment. (Note: If you want to run the Drupal installation process locally, you may need to re-enable some layers of caching in the `/web/sites/default/settings.local.php` file.)
1. Enabled required modules such as `admin_toolbar_tools`, `metatag`, `pantheon_advanced_page_cache`, and `pathauto`.
1. Copy the database to your local environment, and run `drush cex` to export the configuration to the `config/sync` directory, and commit to git.

## What does the original drupal-composer/drupal-project template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `web`-directory.
* Autoloader is implemented to use the generated composer autoloader in `vendor/autoload.php`,
  instead of the one provided by Drupal (`web/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed in `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed in `web/themes/contrib/`
* Profiles (packages of type `drupal-profile`) will be placed in `web/profiles/contrib/`
* Creates default writable versions of `settings.php` and `services.yml`.
* Creates `web/sites/default/files`-directory.
* Creates environment variables based on your .env file. See [.env.example](.env.example).

## What Kalamuna-specific features have been added?
* Added standard configuration for circleci build process and deployment to pantheon.
* Added a `.gitignore-deploy` file that replaces the `.gitignore` file when deploying from circle to pantheon.
* Required the `pantheon-systems/drupal-integrations` package which contains additional scaffolding for pantheon sites.
* The `robots.txt` file is installed initially from drupal scaffold, but any subsequent changes are not overwritten.
* Provide default `development.services.yml` and `settings.local.php` files which will be created in web/sites if they don't already exist.
* Add local settings to keep kint from loading to many objects and crashing drupal.
* Require modules used on all sites, including `admin_toolbar`, `metatag`, `pantheon_advanced_page_cache`, and `pathauto`.
* Provide a package.json file to install npm module.
* Add configuration for the sync directory to be located at `../config/sync`.

## What features have been removed or changed from the original drupal-composer/drupal-project repository?
* Removed unneeded .travis.yml and phpunit.xml.dist files.
* Not using .gitignore files created by Drupal Scaffold.
* Not requiring drush or DrupalConsole, since they are installed globally in Lando and on Pantheon.

## Potential improvements
* Build out the `package.json` file with the configuration for compiling themes with Gulp.
* Have `composer install` call `npm install` automatically.
* Require additional contrib modules we use on most sites, including `google_tag`, `extlink`, `linkit`, and `twig_tweak`.
* Use an install profile to enable the needed modules automatically.
* Don't hardcode the Kalamuna Commit Bot user in the cricleci config.
* Determine standard process for using the `config_split` module.
