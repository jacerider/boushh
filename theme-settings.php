<?php

function boushh_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  if (isset($form_id)) return;

  $path_boushh = drupal_get_path('theme', 'boushh');
  $sonar_enabled = module_exists('sonar');

  if($sonar_enabled){
    drupal_add_css($path_boushh . '/assets/scss/sections/_theme-admin.scss', array('weight' => 100));
  }

  $form['fett']['boushh'] = array(
    '#type' => 'fieldset',
    '#title' => t('Boushh'),
    '#weight' => -50,
  );

  $form['fett']['boushh']['boushh_dark_form'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Use Dark Forms'),
    '#default_value' => theme_get_setting('boushh_dark_form'),
  );

  $form['fett']['#prefix'] = '<h1>&szlig;oushh <small>F e &#8224; &#8224;</small></h1>';
}
