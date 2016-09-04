<?php

sfPropelBehavior::add('Answer', array (
  'paranoid' => 
  array (
    'column' => 'deleted_at',
  ),
  'sfPropelActAsSignableBehavior' => 
  array (
    'columns' => 
    array (
      'created' => 'systematic_reviews.CREATED_BY',
      'updated' => 'systematic_reviews.UPDATED_BY',
      'deleted' => 'systematic_reviews.DELETED_BY',
    ),
  ),
));
