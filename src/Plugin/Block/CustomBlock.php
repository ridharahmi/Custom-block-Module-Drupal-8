<?php

namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;




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

        // url custom image block
        $fid = $config['image'];
        if (!empty($fid)) {
            $file = File::load($fid[0]);
        }
        if (!empty($file)) {
            $url = $file->url();
        }

        // position custom title block
        if ($config['position'] == 1) {
            $text_align = 'left';
        } elseif ($config['position'] == 2) {
            $text_align = 'center';
        } else {
            $text_align = 'right';
        }


        return array(
            '#theme' => 'customblock',
            '#title_block' => $config['title'],
            '#body_block' => $config['body'],
            '#position_title' => $text_align,
            '#image_block' => $url,
            '#color_title' => $config['color'],
            '#link_block' => $config['link'],
            '#description' => $config['description']['value']
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
        $form['color_title'] = array(
            '#type' => 'color',
            '#title' => $this->t('Color Title'),
            '#description' => $this->t('Color Title Custom Block default #000000'),
            '#default_value' => $this->configuration['color'],
        );

        $form['block_body'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Custom Body'),
            '#description' => $this->t('Who do you want to say Description block to?'),
            '#default_value' => $this->configuration['body']
        ];

        $form['block_text'] = [
            '#type' => 'text_format',
            '#title' => $this->t('Custom description'),
            '#format' => 'full_html',
            '#description' => $this->t('Who do you want to say Description block to?'),
            '#rows' => 50,
            '#default_value' => $this->configuration['description']['value']
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
        $form['block_link'] = array(
            '#type' => 'url',
            '#title' => t('Type card link. Example: /erp_cloud'),
            '#size' => 60,
            '#default_value' => $this->configuration['link'],
        );





        return $form;
    }

    public function defaultConfiguration()
    {
        return [
            'title' => 'Title',
            'body' => 'description block',
            'image' => '',
            'position' => 1,
            'color' => '#000000',
            'link' => '',
            'description'=> ''
        ];

    }

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['title'] = $form_state->getValue('block_title');
        $this->configuration['body'] = $form_state->getValue('block_body');
        $this->configuration['image'] = $form_state->getValue('block_image');
        $this->configuration['position'] = $form_state->getValue('position_title');
        $this->configuration['color'] = $form_state->getValue('color_title');
        $this->configuration['link'] = $form_state->getValue('block_link');
        $this->configuration['description'] = $form_state->getValue('block_text');
    }

}