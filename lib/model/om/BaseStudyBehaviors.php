<?php

sfPropelBehavior::add('Study', array (
  'paranoid' => 
  array (
    'column' => 'deleted_at',
  ),
  'sfPropelActAsSignableBehavior' => 
  array (
    'columns' => 
    array (
      'created' => 'studies.CREATED_BY',
      'updated' => 'studies.UPDATED_BY',
      'deleted' => 'studies.DELETED_BY',
    ),
  ),
));
