<?php

namespace Drupal\hello_world;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event class to be dispatched from the HelloWorldSalutation service.
 */
class SalutationEvent extends Event {

  const EVENT = 'hello_world.salutation_event';

  /**
   * The salutation message.
   *
   * @var string
   */
  protected $message;

  /**
   * Getter for the SalutationEvent value.
   *
   * @return string
   *   String of the SalutationEvent.
   */
  public function getValue() {
    return $this->message;
  }

  /**
   * Setter for the SalutationEvent value.
   *
   * @param mixed $message
   *   String for the SalutationEvent.
   */
  public function setValue($message) {
    $this->message = $message;
  }

}
