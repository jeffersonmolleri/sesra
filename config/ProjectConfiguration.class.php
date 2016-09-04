<?php
/*
if(PHP_OS == 'WINNT') {
	require_once 'c:\php5\symfony1.4\lib\autoload\sfCoreAutoload.class.php';
} else {
	require_once '/var/www/symfony/lib/autoload/sfCoreAutoload.class.php';
}
*/
require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin','sfPropelActAsSignableBehaviorPlugin','sfPropelActAsSluggableBehaviorPlugin','sfThumbnailPlugin','sfPropelActAsNestedSetBehaviorPlugin','sfAssetsLibraryPlugin','sfPropelParanoidBehaviorPlugin', 'sfGuardPlugin', 'sfPropelActAsTaggableBehaviorPlugin');
  }
}
