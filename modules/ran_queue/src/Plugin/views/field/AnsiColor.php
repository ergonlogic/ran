<?php

/**
 * @file
 * Definition of Drupal\ran_queue\Plugin\views\field\AnsiColor.
 */

namespace Drupal\ran_queue\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Form\FormStateInterface;

/**
 * Default implementation of the base field plugin.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("ansi-color")
 */
class AnsiColor extends FieldPluginBase {
  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $value = $this->getValue($values);
    // We need to allow the processed ANSI HTML through.
    // TODO: figure out what level of sanitizing makes sense here.
    #return $this->sanitizeValue($value);
    return $value;
  }

}
