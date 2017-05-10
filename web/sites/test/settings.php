<?php

/**
 * @file
 * Includes the settings files appropriate for production environments.
 *
 * @see default.settings.php
 * @see https://api.drupal.org/api/drupal/sites!default!default.settings.php/8
 */

// Always include the "common" settings first.
require $app_root . '/sites/settings.common.php';

// Include production settings next.
require "$app_root/sites/settings.production.php";

// Include staging-specific overrides next.
require "$app_root/sites/settings.staging.php";

// Local settings. These come last so that they can override anything.
if (file_exists("$app_root/$site_path/settings.local.php")) {
  include "$app_root/$site_path/settings.local.php";
}
