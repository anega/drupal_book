<?php

namespace Drupal\hello_world\Logger;

use Drupal\Core\Logger\RfcLoggerTrait;
use Psr\Log\LoggerInterface;

/**
 * A logger that sends an email when the log type is error.
 *
 * @package Drupal\hello_world\Logger
 */
class MailLogger implements LoggerInterface {

  use RfcLoggerTrait;

  /**
   * Logs with an arbitrary level.
   *
   * @param mixed  $level
   * @param string $message
   * @param array  $context
   *
   * @return void
   */
  public function log($level, $message, array $context = []) {
    // Log out message to our loggin system.
  }
}