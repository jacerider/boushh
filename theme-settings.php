<?php

function boushh_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  if (isset($form_id)) return;

  $path_boushh = drupal_get_path('theme', 'boushh');
  $sonar_enabled = module_exists('sonar');

  if($sonar_enabled){
    drupal_add_css($path_boushh . '/assets/scss/sections/_theme-admin.scss');

  }

  $form['fett']['#prefix'] = '<h1>&szlig;oushh <small>F e &#8224; &#8224;</small></h1>';
}
