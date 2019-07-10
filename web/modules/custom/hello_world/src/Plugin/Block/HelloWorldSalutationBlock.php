<?php


namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class HelloWorldSalutationBlock.
 *
 * @Block(
 *   id = "hello_world_salutation_block",
 *   admin_label = @Translation("Hello world salutation"),
 * )
 * @package Drupal\hello_world\Plugin\Block
 */
class HelloWorldSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\hello_world\HelloWorldSalutation definition.
   *
   * @var \Drupal\hello_world\HelloWorldSalutation
   */
  protected $salutation;

  /**
   * HelloWorldSalutationBlock constructor.
   *
   * @param array $configuration
   * @param       $plugin_id
   * @param       $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $salutation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->salutation = $salutation;
  }


  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * If a block should not be rendered because it has no content, then this
   * method must also ensure to return no content: it must then only return an
   * empty array, or an empty array with #cache set (with cacheability metadata
   * indicating the circumstances for it being empty).
   *
   * @return array
   *   A renderable array representing the content of the block.
   *
   * @see \Drupal\block\BlockViewBuilder
   */
  public function build() {
    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

  /**
   * Creates an instance of the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container to pull out services used in the plugin.
   * @param array                                                     $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string                                                    $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed                                                     $plugin_definition
   *   The plugin implementation definition.
   *
   * @return static
   *   Returns an instance of this plugin.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('hello_world.salutation')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function defaultConfiguration() {
    return [
      'enabled' => 1,
    ];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form = [
      '#type'          => 'checkbox',
      '#title'         => t('Enabled'),
      '#description'   => t('Check this box if you want to enable this feature.'),
      '#default_value' => $config['enabled'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = $form_state->getValue('enabled');
  }


}