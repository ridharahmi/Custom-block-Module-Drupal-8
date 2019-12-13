<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\core\Url;

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
        $config = $this->getConfiguration();
        $fid = $config['image'];
        if (!empty($fid)) {
            $file = File::load($fid[0]);
        }
        if (!empty($file)) {
            $url = $file->url();
        }


        return array(
            '#theme' => 'customblock',
            '#title_block' => $config['title'],
            '#body_block' => $config['body'],
            '#position_title' => $config['position'],
            '#image_block' => $url,
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
        $form['position_title'] = array(
            '#title' => $this->t('Position Title'),
            '#description' => $this->t('This is position title'),
            '#type' => 'select',
            '#options' => array(
                1 => $this->t('Left'),
                2 => $this->t('Center'),
                3 => $this->t('Right'),
            ),
            '#default_value' => $this->configuration['position'],
        );

        $form['block_body'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Custom Body'),
            '#description' => $this->t('Who do you want to say Description block to?'),
            '#default_value' => $this->configuration['body']
        ];
        $form['block_image'] = array(
            '#title' => t('Custom Image'),
            '#description' => $this->t('Chossir Image gif png jpg jpeg'),
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
            'image' => '',
            'position' => 1
        ];

    }

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['title'] = $form_state->getValue('block_title');
        $this->configuration['body'] = $form_state->getValue('block_body');
        $this->configuration['image'] = $form_state->getValue('block_image');
        $this->configuration['position'] = $form_state->getValue('position_title');
    }

}