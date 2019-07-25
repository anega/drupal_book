<?php

namespace Drupal\hello_world\Plugin\Mail;

use Drupal\Core\Mail\MailFormatHelper;
use Drupal\Core\Mail\MailInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the Hello World mail backend.
 *
 * @Mail(
 *   id = "hello_world_mail",
 *   label = @Translation("Hello World mailer"),
 *   description = @Translation("Sends an email using an external API specific
 *   to our Hello World module.")
 * )
 */
class HelloWorldMail implements MailInterface, ContainerFactoryPluginInterface {

  /**
   * Creates an instance of the plugin.
   *
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static();
  }

  /**
   * Formats a message prior to sending.
   *
   * Allows to preprocess, format, and postprocess a mail message before it is
   * passed to the sending system. By default, all messages may contain HTML and
   * are converted to plain-text by the Drupal\Core\Mail\Plugin\Mail\PhpMail
   * implementation. For example, an alternative implementation could override
   * the default implementation and also sanitize the HTML for usage in a MIME-
   * encoded email, but still invoking the Drupal\Core\Mail\Plugin\Mail\PhpMail
   * implementation to generate an alternate plain-text version for sending.
   *
   * @param array $message
   *   A message array, as described in hook_mail_alter().
   *
   * @return array
   *   The formatted $message.
   *
   * @see \Drupal\Core\Mail\MailManagerInterface
   */
  public function format(array $message) {
    // Join the body array into one string.
    $message['body'] = implode('\n\n', $message['body']);

    // Convert any HTML to plain-text.
    $message['body'] = MailFormatHelper::htmlToText($message['body']);
    // Wrap the mail body for sending.
    $message['body'] = MailFormatHelper::wrapMail($message['body']);

    return $message;
  }

  /**
   * Sends a message composed by
   * \Drupal\Core\Mail\MailManagerInterface->mail().
   *
   * @param array $message
   *     Message array with at least the following elements:
   *     - id: A unique identifier of the email type. Examples:
   *     'contact_user_copy',
   *     'user_password_reset'.
   *     - to: The mail address or addresses where the message will be sent to.
   *     The formatting of this string will be validated with the
   *
   * @return bool
   *   TRUE if the mail was successfully accepted for delivery, otherwise
   *   FALSE.
   * @link http://php.net/manual/filter.filters.validate.php PHP email
   *       validation filter. @endlink Some examples:
   *       - user@example.com
   *       - user@example.com, anotheruser@example.com
   *       - User <user@example.com>
   *       - User <user@example.com>, Another User <anotheruser@example.com>
   *       - subject: Subject of the email to be sent. This must not contain
   *       any
   *       newline characters, or the mail may not be sent properly. The
   *       subject
   *       is converted to plain text by the mail plugin manager.
   *       - body: Message to be sent. Accepts both CRLF and LF line-endings.
   *       Email bodies must be wrapped. For smart plain text wrapping you can
   *       use
   *       \Drupal\Core\Mail\MailFormatHelper::wrapMail() .
   *       - headers: Associative array containing all additional mail headers
   *       not defined by one of the other parameters.  PHP's mail() looks for
   *       Cc and Bcc headers and sends the mail to addresses in these headers
   *       too.
   *
   */
  public function mail(array $message) {
    // Use the external API to send the email based on the $message array
    // constructed via the `hook_mail()` implementation.
  }

}

