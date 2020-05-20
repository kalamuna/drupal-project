/**
 * Append the config directory settings to the default settings.php provided by the pantheon scaffold.
 */
$settings['config_sync_directory'] = '../config/sync';

/**
 * Append Config Split Settings & Environment Indicator Settings.
 */

// Disable all config splits by default.
// $config['config_split.config_split.local']['status'] = FALSE;
// $config['config_split.config_split.stage']['status'] = FALSE;
// $config['config_split.config_split.prod']['status'] = FALSE;
// $config['config_split.config_split.dev']['status'] = FALSE;
// Set environment indicator - foreground colour.
$config['environment_indicator.indicator']['fg_color'] = '#FFFFFF';

// Dev.
if (
  (isset($_ENV['AH_SITE_ENVIRONMENT']) && $_ENV['AH_SITE_ENVIRONMENT'] == 'dev') ||
  (isset($_ENV['PANTHEON_ENVIRONMENT']) && $_ENV['PANTHEON_ENVIRONMENT'] == 'dev') ||
  (getenv('ENVIRONMENT') == 'DEV')
) {
  //$config['config_split.config_split.dev']['status'] = TRUE;
  $config['environment_indicator.indicator']['bg_color'] = '#007FAD';
  $config['environment_indicator.indicator']['name'] = 'DEV';
}
// Stage / Test.
else if (
  (isset($_ENV['AH_SITE_ENVIRONMENT']) && $_ENV['AH_SITE_ENVIRONMENT'] == 'test') ||
  (isset($_ENV['PANTHEON_ENVIRONMENT']) && $_ENV['PANTHEON_ENVIRONMENT'] == 'test') ||
  (getenv('ENVIRONMENT') == 'STAGE')
) {
  //$config['config_split.config_split.stage']['status'] = TRUE;
  $config['environment_indicator.indicator']['bg_color'] = '#CA4B02';
  $config['environment_indicator.indicator']['name'] = 'STAGE';
}
// Prod.
else if (
  (isset($_ENV['AH_SITE_ENVIRONMENT']) && $_ENV['AH_SITE_ENVIRONMENT'] == 'prod') ||
  (isset($_ENV['PANTHEON_ENVIRONMENT']) && $_ENV['PANTHEON_ENVIRONMENT'] == 'prod') ||
  (getenv('ENVIRONMENT') == 'PROD')
) {
  //$config['config_split.config_split.prod']['status'] = TRUE;
  $config['environment_indicator.indicator']['bg_color'] = '#EC0914';
  $config['environment_indicator.indicator']['name'] = 'PROD';
}
// Local.
else {
  //$config['config_split.config_split.local']['status'] = TRUE;
  $config['environment_indicator.indicator']['bg_color'] = '#007A5A';
  $config['environment_indicator.indicator']['name'] = 'LOCAL';
}
