<?php

/**
 * Implements template_preprocess_html().
 */
//function boushh_preprocess_html(&$vars) {
//}


/**
 * Implements template_preprocess_page().
 */
function boushh_preprocess_page(&$vars) {

  // Add icon to page title
  $vars['title'] = drupal_get_title();
  if(function_exists('fawesome_text')){
    $vars['title'] = fawesome_text($vars['title'], FALSE, 'th');
  }
  // Allow markup in titles.
  $vars['title'] = htmlspecialchars_decode($vars['title']);

  // Add Open Sans
  drupal_add_css('@import url(//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:300,400,600,700,300italic,400italic,600italic,700italic);', 'inline');

}


/**
 * Implements template_preprocess_node().
 */
//function boushh_preprocess_node(&$vars) {
//}


/**
 * Implements template_preprocess_asset().
 */
//function boushh_preprocess_asset(&$vars) {
//}

/**
 * Implements hook_theme().
 */
function boushh_theme($existing, $type, $theme, $path) {
  $base = array(
    'render element' => 'form',
    'path' => drupal_get_path('theme', 'boushh') . '/templates/forms',
  );

  return array(
    'inline_entity_form' => $base + array(
      'template' => 'inline-entity-form',
    ),
  );
}

/**
 * Implements theme_node_add_list().
 */
function boushh_node_add_list($vars) {
  return boushh_admin_block_content($vars);
}

/**
 * Returns HTML for an administrative page.
 *
 * @param $vars
 *   An associative array containing:
 *   - blocks: An array of blocks to display. Each array should include a
 *     'title', a 'description', a formatted 'content' and a 'position' which
 *     will control which container it will be in. This is usually 'left' or
 *     'right'.
 *
 * @ingroup themeable
 */
function boushh_admin_page($vars) {
  $blocks = $vars['blocks'];

  $stripe = 0;
  $container = array();

  foreach ($blocks as $block) {
    if ($block_output = theme('admin_block', array('block' => $block))) {
      if (empty($block['position'])) {
        // perform automatic striping.
        $block['position'] = ++$stripe % 2 ? 'left' : 'right';
      }
      if (!isset($container[$block['position']])) {
        $container[$block['position']] = '';
      }
      $container[$block['position']] .= $block_output;
    }
  }

  $output = '<div class="boushh-grid-wrapper clearfix">';
  // $output .= theme('system_compact_link');

  foreach ($container as $id => $data) {
    $output .= '<div class="' . $id . ' boushh-grid-region clearfix">';
    $output .= $data;
    $output .= '</div>';
  }
  $output .= '</div>';
  return $output;
}

/**
 * Returns HTML for an administrative block for display.
 *
 * @param $vars
 *   An associative array containing:
 *   - block: An array containing information about the block:
 *     - show: A Boolean whether to output the block. Defaults to FALSE.
 *     - title: The block's title.
 *     - content: (optional) Formatted content for the block.
 *     - description: (optional) Description of the block. Only output if
 *       'content' is not set.
 *
 * @ingroup themeable
 */
function boushh_admin_block($vars) {
  $block = $vars['block'];
  $output = '';

  // Don't display the block if it has no content to display.
  if (empty($block['show'])) {
    return $output;
  }

  $output .= '<div class="boushh-grid-panel">';
  if (!empty($block['title'])) {
    $output .= '<h3>' . $block['title'] . '</h3>';
  }
  if (!empty($block['content'])) {
    $output .= '<div class="body">' . $block['content'] . '</div>';
  }
  else {
    $output .= '<div class="description">' . $block['description'] . '</div>';
  }
  $output .= '</div>';

  return $output;
}

/**
 * Implements theme_admin_block_content().
 */
function boushh_admin_block_content($vars) {
  fett_foundation_js('equalizer');

  $content = $vars['content'];
  $output = '';

  if (!empty($content)) {
    $class = 'boushh-grid';
    if ($compact = system_admin_compact_mode()) {
      $class .= ' compact';
    }
    $output .= '<ul class="' . $class . '" data-equalizer data-options="equalize_on_stack: true">';
    foreach ($content as $item) {
      $output .= '<li>';
      $markup = '';
      $title = $item['title'];
      $item['localized_options']['html'] = TRUE;
      $item['localized_options']['attributes']['data-equalizer-watch'] = '';
      if(!empty($item['options']['fawesome'])){
        $markup .= '<div class="icon"><i class="fa fa-' . $item['options']['fawesome'] . '"></i></div>';
      }
      elseif(function_exists('fawesome_match') && $icon = fawesome_match($title, 'th')){
        $markup .= '<div class="icon"><i class="fa fa-' . $icon['icon'] . '"></i></div>';
      }
      if (!$compact && !empty($item['description'])) {
        $title = $title . '<div class="description">' . strip_tags(filter_xss_admin($item['description'])) . '</div>';
      }
      $markup .= '<div class="title">' . $title . '</div>';
      $output .= l($markup, $item['href'], $item['localized_options']);
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

/**
 * Returns HTML for the Appearance page.
 *
 * @param $variables
 *   An associative array containing:
 *   - theme_groups: An associative array containing groups of themes.
 *
 * @ingroup themeable
 */
function boushh_system_themes_page($variables) {
  fett_foundation_js('equalizer');
  $theme_groups = $variables['theme_groups'];

  $output = '<div id="system-themes-page">';

  foreach ($variables['theme_group_titles'] as $state => $title) {
    if (!count($theme_groups[$state])) {
      // Skip this group of themes if no theme is there.
      continue;
    }
    // Start new theme group.
    $output .= '<div class="system-themes-list system-themes-list-'. $state .' clearfix" data-equalizer data-options="equalize_on_stack: true"><h2>'. $title .'</h2>';

    foreach ($theme_groups[$state] as $theme) {

      // Theme the screenshot.
      $screenshot = $theme->screenshot ? theme('image', $theme->screenshot) : '<div class="no-screenshot">' . t('no screenshot') . '</div>';

      // Localize the theme description.
      $description = t($theme->info['description']);

      // Style theme info
      $notes = count($theme->notes) ? ' <span class="notes">(' . join(', ', $theme->notes) . ')<span>' : '';
      $theme->classes[] = 'theme-selector';
      $theme->classes[] = 'clearfix';
      $output .= '<div class="'. join(' ', $theme->classes) .'"><div class="inner" data-equalizer-watch><div class="theme-info"><div class="theme-description">' . $description . '</div>';

      // Make sure to provide feedback on compatibility.
      if (!empty($theme->incompatible_core)) {
        $output .= '<div class="incompatible">' . t('This version is not compatible with Drupal !core_version and should be replaced.', array('!core_version' => DRUPAL_CORE_COMPATIBILITY)) . '</div>';
      }
      elseif (!empty($theme->incompatible_php)) {
        if (substr_count($theme->info['php'], '.') < 2) {
          $theme->info['php'] .= '.*';
        }
        $output .= '<div class="incompatible">' . t('This theme requires PHP version @php_required and is incompatible with PHP version !php_version.', array('@php_required' => $theme->info['php'], '!php_version' => phpversion())) . '</div>';
      }
      else {
        foreach($theme->operations as &$op){
          $op['title'] = fett_icon_text($op['title']);
          $op['html'] = TRUE;
        }
        $output .= theme('links', array('links' => $theme->operations, 'attributes' => array('class' => array('operations', 'clearfix'))));
      }
      $output .= $theme->info['name'] . ' ' . (isset($theme->info['version']) ? $theme->info['version'] : '') . $notes . '</div>' . $screenshot . '</div></div>';
    }
    $output .= '</div>';
  }
  $output .= '</div>';

  return $output;
}



/**
 * Implements hook_fawesome_icons().
 */
function boushh_fawesome_icons(){
  $icons = array(
    '^feeds' => 'rss',
    'content' => 'files-o',
    'structure' => 'sitemap',
    'modules' => 'puzzle-piece',
    'views' => 'bolt',
    'blocks' => 'th-large',
    'content types' => 'object-group',
    'menu trail by path' => 'location-arrow',
  );

  return $icons;
}

/**
 * Implements hook_inline_entity_form_entity_form_alter().
 */
function boushh_inline_entity_form_entity_form_alter(&$form, &$form_state){
  if(isset($form['#type']) && in_array($form['#type'], array('fieldset', 'container')) && isset($form['#ief_id'])){

    $ief = $form_state['inline_entity_form'][$form['#ief_id']];
    // Single reference fields should be skipped.
    if($ief['instance']['widget']['type'] == 'inline_entity_form_single'){
      return;
    }

    $form['#prefix'] = isset($form['#prefix']) ? $form['#prefix'] : '';
    $form['#suffix'] = isset($form['#suffix']) ? $form['#suffix'] : '';

    if($form['#type'] == 'fieldset'){
      $form['#prefix'] = $form['#prefix'] . '<div class="ief-form-wrapper theforce-fixed">';
      $form['#suffix'] = '</div>' . $form['#suffix'];
    }
    else{
      $form['#prefix'] = $form['#prefix'] . '<div class="ief-form-wrapper theforce-fixed"><div class="ief-form-inner">';
      $form['#suffix'] = '</div></div>' . $form['#suffix'];
    }

    if(isset($form['actions']['ief_edit_save']['#value'])){
      $form['ief_title'] = array(
        '#markup' => '<div class="ief-form-title">'.$form['actions']['ief_edit_save']['#value'].'</div>',
        '#weight' => -99999,
      );
    }
    elseif(!empty($form['#title'])){
      $form['ief_title'] = array(
        '#markup' => '<div class="ief-form-title">'.$form['#title'].'</div>',
        '#weight' => -99999,
      );
    }
    elseif(isset($form['actions']['ief_add_save']['#value'])){
      $form['ief_title'] = array(
        '#markup' => '<div class="ief-form-title">'.$form['actions']['ief_add_save']['#value'].'</div>',
        '#weight' => -99999,
      );
    }

    $form['ief_prefix'] = array(
      '#markup' => '<div class="ief-form-scroll">',
      '#weight' => -99998,
    );

    $form['ief_suffix'] = array(
      '#markup' => '</div>',
      '#weight' => 99998,
    );

    $form['actions']['#weight'] = 99999;
    $form['actions']['#attributes']['class'][] = 'ief-form-actions';
    if(isset($form['actions']['ief_edit_cancel'])){
      $form['actions']['ief_edit_cancel']['#attributes']['class'][] = 'ief-edit-cancel';
    }
    if(isset($form['actions']['ief_add_cancel'])){
      $form['actions']['ief_add_cancel']['#attributes']['class'][] = 'ief-edit-cancel';
    }
    if(isset($form['actions']['ief_reference_cancel'])){
      $form['actions']['ief_reference_cancel']['#attributes']['class'][] = 'ief-edit-cancel';
    }

    // Node specific tweaks
    if(!empty($form['#entity_type']) && $form['#entity_type'] == 'node'){
      $form['status']['#access'] = FALSE;
      $form['redirect']['#access'] = FALSE;
    }
  }
}

/**
 * Implements hook_inline_entity_form_reference_form_alter().
 */
function boushh_inline_entity_form_reference_form_alter(&$form, &$form_state) {
  if($form['#entity_type'] == 'asset'){
    boushh_inline_entity_form_entity_form_alter($form, $form_state);
  }
}

/**
 * Returns HTML for the overlay crop area of an image.
 *
 * @param $variables
 *   An associative array containing:
 *   - "attributes": An array of attributes.
 *   - "image": An array of variables for the image theming function.
 *
 * @return
 *   HTML for the overlay crop tool.
 *
 * @ingroup themeable
 */
function boushh_manualcrop_croptool_overlay($variables) {
  $variables['attributes']['class'][] = 'page';
  $output = '<div ' . drupal_attributes($variables['attributes']) . '>';
  $output .= '<div class="manualcrop-overlay-bg"></div>';
  $output .= '<div class="manualcrop-image-holder">';
  $output .= theme('image', $variables["image"]);
  $output .= '</div>';
  if ($variables['crop_info']) {
    $output .= '<div class="manualcrop-selection-info hidden">';
    $output .= '<div class="manualcrop-selection-label manualcrop-selection-xy">';
    $output .= '<div class="manualcrop-selection-label-content">';
    $output .= '<span class="manualcrop-selection-x">-</span> x <span class="manualcrop-selection-y">-</span>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div class="manualcrop-selection-label manualcrop-selection-width">';
    $output .= '<div class="manualcrop-selection-label-content">-</div>';
    $output .= '</div>';
    $output .= '<div class="manualcrop-selection-label manualcrop-selection-height">';
    $output .= '<div class="manualcrop-selection-label-content">-</div>';
    $output .= '</div>';
    $output .= '</div>';
  }
  if ($variables['instant_preview']) {
    $output .= '<div class="manualcrop-instantpreview"></div>';
  }
  $output .= '<div class="manualcrop-style-info">';
  $output .= t('Image style') . ': <span class="manualcrop-style-name">&nbsp;</span>';
  $output .= '</div>';
  $output .= '<div class="manualcrop-buttons">';
  $output .= '<a class="button tiny secondary manualcrop-cancel" href="javascript:void(0);" onmousedown="ManualCrop.closeCroptool(true);">' . t('Cancel') . '</a>';
  $output .= '<a class="button tiny secondary manualcrop-maximize" href="javascript:void(0);" onmousedown="ManualCrop.maximizeSelection();">' . t('Maximize selection') . '</a>';
  $output .= '<a class="button tiny secondary manualcrop-clear" href="javascript:void(0);" onmousedown="ManualCrop.clearSelection();">' . t('Remove selection') . '</a>';
  $output .= '<a class="button tiny secondary manualcrop-reset" href="javascript:void(0);" onmousedown="ManualCrop.resetSelection();">' . t('Revert selection') . '</a>';
  $output .= '<a class="button small primary manualcrop-close" href="javascript:void(0);" onmousedown="ManualCrop.closeCroptool();"><i class="fa fa-save"></i> ' . t('Save') . '</a>';
  $output .= '</div>';
  $output .= '</div>';
  return $output;
}

/**
 * Implements theme_button().
 */
function boushh_button($vars) {
  $element = $vars['element'];
  $label = $element['#value'];
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'button';
  $element['#attributes']['class'][] = 'radius';
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  // Fastclick.js fix for ajax form buttons
  if(!empty($element['#ajax'])){
    $element['#attributes']['class'][] = 'needsclick';
  }

  // Prepare input whitelist - added to ensure ajax functions don't break
  $whitelist = _fett_element_whitelist();

  // Upload progress skip.
  if(isset($element['#ajax']['progress']['type']) && $element['#ajax']['progress']['type'] === 'bar'){
    $whitelist[] = $element['#id'];
  }

  if (isset($element['#id']) && in_array($element['#id'], $whitelist)) {
    return '<input' . drupal_attributes($element['#attributes']) . ">\n"; // This line break adds inherent margin between multiple buttons
  }
  else {
    return '<button' . drupal_attributes($element['#attributes']) . '>'. fett_icon_text($label) ."</button>\n"; // This line break adds inherent margin between multiple buttons
  }
}

/**
 * Implements theme_select().
 */
function boushh_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-select'));

  // Fix HTML entities in options.
  foreach($element['#options'] as &$value){
    if (is_string($value)) {
      $value = html_entity_decode($value);
    }
  }

  return '<select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select>';
}
