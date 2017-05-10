<?php

/**
 * @file
 * Production-specific configuration settings.
 *
 * @see default.settings.php
 * @see https://api.drupal.org/api/drupal/sites!default!default.settings.php/8
 */

$settings['trusted_host_patterns'] = array(
  '^stage-y77w3ti-njk673pjbftas\.us\.platform\.sh$',
  '^test-t6dnbai-njk673pjbftas.\.us\.platform\.sh$',
);

// Set the Stage File Proxy origin URL for pulling images, files, etc.
$config['stage_file_proxy.settings']['origin'] = 'http://FTUSA:redesign@prod.redesign.fairtradeusa.org.771elwb01.blackmesh.com';
