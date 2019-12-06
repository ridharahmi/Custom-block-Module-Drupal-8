<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "custom_block_drupal_8",
 *   admin_label = @Translation("Custom Block Drupal 8"),
 *   category = @Translation("Custom Block Drupal 8"),
 * )
 */
class CustomBlock extends BlockBase
{

    /**
     * {@inheritdoc}
     */
    public function build()
    {
//        return [
//            '#markup' => 'Hello ' . $this->configuration['title'] . ' !'
//        ];
        $config = $this->getConfiguration();
        return array(

            '#theme' => 'customblock',
            '#title_block' => $config['title'],
            '#body_block' => $config['body'],
        );

    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {

        $form['block_title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Custom Title'),
            '#description' => $this->t('Who do you want to say title block to?'),
            '#default_value' => $this->configuration['title']
        ];

        $form['block_body'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Custom Body'),
            '#description' => $this->t('Who do you want to say Description block to?'),
            '#default_value' => $this->configuration['body']
        ];
        $form['block_image'] = array(
            '#title' => t('Custom Image'),
            '#description' => t('This is custom image block drupal 8'),
            '#type' => 'managed_file',
            '#upload_location' => 'public://custom-image-block/',
            '#upload_validators' => array(
                'file_validate_extensions' => array('gif png jpg jpeg'),
            ),
            '#default_value' => $this->configuration['image']
        );


        return $form;
    }

    public function defaultConfiguration()
    {
        return [
            'title' => 'Title',
            'body' => 'description block',
            'image' => ''
        ];

    }

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['title'] = $form_state->getValue('block_title');
        $this->configuration['body'] = $form_state->getValue('block_body');
        $this->configuration['image'] = $form_state->getValue('block_image');
    }

}