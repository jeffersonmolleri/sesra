<?php

sfPropelBehavior::add('RslResult', array (
  'paranoid' => 
  array (
    'column' => 'deleted_at',
  ),
  'sfPropelActAsSignableBehavior' => 
  array (
    'columns' => 
    array (
      'created' => 'rsl_results.CREATED_BY',
      'updated' => 'rsl_results.UPDATED_BY',
      'deleted' => 'rsl_results.DELETED_BY',
    ),
  ),
));
