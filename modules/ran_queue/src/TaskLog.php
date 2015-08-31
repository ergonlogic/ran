<?php

/**
 * @file
 * Definition of Drupal\ran_queue\TaskLog.
 */

namespace Drupal\ran_queue;

use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Component\HttpFoundation\Response;

class TaskLog {

  /**
   * Callback to handle POST requests.
   */
  function post_log() {
    // TODO: figure out how to use the D8 API for this, instead of our function.
    #$params = \Drupal::request()->query->all();
    $params = $this->_urldecode(file_get_contents('php://input'));
    $converter = new AnsiToHtmlConverter();
    $task = array(
      'task_id' => $params['task_id'],
      'task_ref_id' => $params['task_ref_id'],
      'task_sequence' => $params['task_sequence'],
      'timestamp' => $params['timestamp'],
      'task_output_raw' => $params['task_output'],
      'task_output' => $converter->convert($params['task_output']),
    );
    db_insert('ran_queue_task_log')
      ->fields($task)
      ->execute();
    $r = new Response;
    #$r->setStatusCode(418);
    return $r;
  }

  /**
   * Helper function to return an array based on query parameters.
   */
  function _urldecode($query) {
    $params = array();
    foreach (explode('&', $query) as $chunk) {
      $param = explode("=", $chunk);
      if ($param) {
        $params[urldecode($param[0])] = urldecode($param[1]);
      }
    }
    return $params;
  }

}
