<?php

/**
 * Implements hook_views_data().
 */
function ran_queue_views_data() {
  $data = array();
  // Table
  $data['ran_queue_task_log'] = array(
    'table' => array(
      'group' => t('Rán Tasks'),
      'provider' => 'ran',
      'base' => array(
        'field' => 'task_id',
        'title' => t('Tasks'),
        'help' => t('Output captured from Rán tasks.'),
        #'weight' => -10,
      ),
    ),
  );
  // Fields
  $data['ran_queue_task_log']['task_id'] = array(
    'title' => t('Task ID'),
    'help' => t('The unique identifier for the task.'),
    // ID of field handler plugin to use.
    'field' => array('id' => 'standard'),
    // ID of sort handler plugin to use.
    'sort' => array('id' => 'standard'),
    // ID of filter handler plugin to use.
    'filter' => array('id' => 'string'),
    // ID of argument handler plugin to use.
    'argument' => array('id' => 'string'),
  );
  $data['ran_queue_task_log']['task_ref_id'] = array(
    'title' => t('Referring ID'),
    'help' => t("The unique identifier for the task's entity."),
    'field' => array('id' => 'standard'),
    'sort' => array('id' => 'standard'),
    'filter' => array('id' => 'string'),
    'argument' => array('id' => 'string'),
  );
  $data['ran_queue_task_log']['task_output'] = array(
    'title' => t('Task output'),
    'help' => t('Output from a task.'),
    'field' => array('id' => 'ansi-color'),
    #'field' => array('id' => 'standard'),
    'sort' => array('id' => 'standard'),
    'filter' => array('id' => 'string'),
    'argument' => array('id' => 'string'),
  );
  $data['ran_queue_task_log']['task_output_raw'] = array(
    'title' => t('Task output (raw)'),
    'help' => t('Unprocessed output from a task.'),
    'field' => array('id' => 'standard'),
    'sort' => array('id' => 'standard'),
    'filter' => array('id' => 'string'),
    'argument' => array('id' => 'string'),
  );
  $data['ran_queue_task_log']['task_sequence'] = array(
    'title' => t('Sequence'),
    'help' => t('The sequence that output was generated.'),
    'field' => array( 'id' => 'numeric',),
    'sort' => array( 'id' => 'standard',),
    'filter' => array( 'id' => 'numeric',),
    'argument' => array( 'id' => 'numeric',),
  );

  // Integer timestamp field, exposed as a field, sort, and filter.
  $data['ran_queue_task_log']['timestamp'] = array(
    'title' => t('Timestamp field'),
    'help' => t('Just a timestamp field.'),
    'field' => array( 'id' => 'date',),
    'sort' => array( 'id' => 'date',),
    'filter' => array( 'id' => 'date',),
  );
  return $data;
}
