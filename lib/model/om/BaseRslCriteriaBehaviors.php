<?php

sfPropelBehavior::add('RslCriteria', array (
  'paranoid' => 
  array (
    'column' => 'deleted_at',
  ),
  'sfPropelActAsSignableBehavior' => 
  array (
    'columns' => 
    array (
      'created' => 'protocols.CREATED_BY',
      'updated' => 'protocols.UPDATED_BY',
      'deleted' => 'protocols.DELETED_BY',
    ),
  ),
));
