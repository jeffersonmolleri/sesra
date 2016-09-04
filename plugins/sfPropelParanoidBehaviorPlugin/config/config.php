<?php

sfPropelBehavior::registerMethods('paranoid', array(
  array('sfPropelParanoidBehavior', 'forceDelete'),
));

sfPropelBehavior::registerHooks('paranoid', array(
  ':delete:pre'                => array('sfPropelParanoidBehavior', 'preDelete'),
  'Peer:doSelectRS'            => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoin'          => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoinAll'       => array('sfPropelParanoidBehavior', 'doSelectRS'),
  'Peer:doSelectJoinAllExcept' => array('sfPropelParanoidBehavior', 'doSelectRS'),
));
