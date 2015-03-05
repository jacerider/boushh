<?php

function boushh_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  if (isset($form_id)) return;

  $path_boushh = drupal_get_path('theme', 'boushh');
  $sonar_enabled = module_exists('sonar');

  drupal_add_js($path_boushh . '/assets/js/theme-admin.js');
  if($sonar_enabled){
    drupal_add_css($path_boushh . '/assets/scss/sections/_theme-admin.scss', array('weight' => 100));
  }

  $form['fett']['boushh'] = array(
    '#type' => 'fieldset',
    '#title' => t('Boushh'),
    '#weight' => -50,
  );

  $bg = theme_get_setting('boushh_bg') ? theme_get_setting('boushh_bg') : '#2e383e';
  $primary = theme_get_setting('boushh_primary') ? theme_get_setting('boushh_primary') : '#0997c3';
  $secondary = theme_get_setting('boushh_secondary') ? theme_get_setting('boushh_secondary') : '#f0c495';

  $themes = $items = array();
  $themes[] = array('Cobalt', array('#2e383e','#0997c3','#f0c495'));
  $themes[] = array('Midnight', array('#363636','#0997c3','#f0c495'));
  $themes[] = array('Sandstorm', array('#322721','#C5A57F','#cfc1ad'));
  $themes[] = array('Solarized', array('#586E75','#d8a300','#CB4B16'));
  $themes[] = array('Thoughts', array('#8b1c2e','#f8664a','#ECD078'));
  $themes[] = array('Sugar', array('#490A3D','#8A9B0F','#F8CA00'));
  $themes[] = array('Pancackes', array('#594F4F','#45ADA8','#E5FCC2'));
  $themes[] = array('Terra', array('#f3f1ec','#036564','#033649'));
  foreach($themes as $theme){
    $item_class = $theme[1][0] == $bg && $theme[1][1] == $primary && $theme[1][2] == $secondary ? 'active' : '';
    $item = '<a data-bg="' . $theme[1][0] . '" data-primary="' . $theme[1][1] . '" data-secondary="' . $theme[1][2] . '" class="' . $item_class . '">';
    $item .= '<i class="fa fa-square" style="color:'.$theme[1][0].'"></i> ';
    $item .= '<i class="fa fa-square" style="color:'.$theme[1][1].'"></i> ';
    $item .= '<i class="fa fa-square" style="color:'.$theme[1][2].'"></i> ';
    $item .= $theme[0];
    $item .= '</a>';
    $items[] = $item;
  }
  $form['fett']['boushh']['themes'] = array(
    '#theme' => 'item_list',
    '#items' => $items,
    '#attributes' => array('id' => 'boushh-theme-select'),
  );

  $form['fett']['boushh']['boushh_bg'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Base Color'),
    '#field_prefix'  => 'Hex or Color Name <i class="fa fa-square" style="color:'.$bg.';"></i>',
    '#default_value' => $bg,
  );

  $form['fett']['boushh']['boushh_primary'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Primary Color'),
    '#field_prefix'  => 'Hex or Color Name <i class="fa fa-square" style="color:'.$primary.';"></i>',
    '#default_value' => $primary,
  );

  $form['fett']['boushh']['boushh_secondary'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Secondary Color'),
    '#field_prefix'  => 'Hex or Color Name <i class="fa fa-square" style="color:'.$secondary.';"></i>',
    '#default_value' => $secondary,
  );

  $form['fett']['#prefix'] = '<h1>&szlig;oushh <small>F e &#8224; &#8224;</small></h1>';
}
