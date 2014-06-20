<?php

/**
 * Implements hook_fett_icons_alter().
 */
function boushh_fett_icons_alter(&$icons){
  $icons['add'] = 'plus';
  $icons['apply'] = 'save';
  $icons['preview'] = 'eye';
  $icons['save'] = 'save';
  $icons['cancel'] = 'undo';
  $icons['rearrange'] = 'bars';
  $icons['list'] = 'list';
  $icons['disable'] = 'ban';
  $icons['uninstall'] = 'times';
  $icons['remove'] = 'ban';
  $icons['clone'] = 'copy';
  $icons['export'] = 'external-link';
  $icons['enable'] = 'check-circle-o';
  $icons['enable and set default'] = 'check-circle';
  $icons['set default'] = 'check-circle';
  $icons['manage fields'] = 'tasks';
  $icons['update'] = 'arrow-up';
  $icons['upload'] = 'upload';
  $icons['basic page'] = 'file';
  $icons['reports'] = 'bar-chart-o';
  $icons['people'] = 'users';
  $icons['modules'] = 'building';
  $icons['content'] = 'files-o';
  $icons['configuration'] = 'sliders';
  $icons['context'] = 'magnet';
  $icons['views'] = 'paper-plane';
  $icons['content types'] = 'pencil-square-o';
  $icons['site information'] = 'info-circle';
  $icons['account settings'] = 'user';
  $icons['image styles'] = 'picture-o';
  $icons['image toolkit'] = 'camera';
  $icons['date and time'] = 'calendar';
  $icons['regional settings'] = 'language';
  $icons['url aliases'] = 'link';
  $icons['rss publishing'] = 'rss';
  $icons['logging and errors'] = 'terminal';
  $icons['maintenance mode'] = 'umbrella';
  $icons['sonar'] = 'soundcloud';
  $icons['file system'] = 'file-o';
  $icons['blocks'] = 'puzzle-piece';
  $icons['features'] = 'anchor';
  $icons['appearance'] = 'magic';
  $icons['structure'] = 'institution';
  $icons['text formats'] = 'text-height';
  $icons['google webfont loader settings'] = 'google';
  $icons['assets'] = 'rebel';
  $icons['ip address blocking'] = 'ban';
  $icons['actions'] = 'rocket';
  $icons['jquery update'] = 'arrow-up';
  $icons['performance'] = 'space-shuttle';
  $icons['valet'] = 'car';
  $icons['cron'] = 'history';
  $icons['menu block'] = 'tasks';
  $icons['external links'] = 'external-link';
  $icons['boxes'] = 'th';
  $icons['patterns'] = 'qrcode';
  $icons['page titles'] = 'text-width';
  $icons['url redirects'] = 'mail-forward';
  $icons['clean urls'] = 'random';
  $icons['^save'] = array('icon' => 'save', 'class' => array('primary'));
  $icons['^edit'] = array('icon' => 'edit', 'class' => array('primary'));
  $icons['^list'] = array('icon' => 'list', 'class' => array('primary'));
  $icons['^manage'] = array('icon' => 'list', 'class' => array('primary'));
  $icons['^add'] = array('icon' => 'plus', 'class' => array('primary'));
  $icons['^create'] = array('icon' => 'plus', 'class' => array('primary'));
  $icons['^update'] = array('icon' => 'refresh');
  $icons['update$'] = array('icon' => 'refresh');
  $icons['^reset'] = array('icon' => 'history');
  $icons['^undo'] = array('icon' => 'undo');
  $icons['^refine'] = array('icon' => 'search');
  $icons['^webform'] = array('icon' => 'th-list');
  $icons['^@font-your-face'] = array('icon' => 'font');
  $icons['^exo '] = array('icon' => 'empire');
  $icons['^devel '] = array('icon' => 'bug');
  $icons['^quickbar '] = array('icon' => 'barcode');
  $icons['^delete '] = array('icon' => 'trash-o');
}

/**
 * Implements hook_element_info_alter().
 */
function boushh_element_info_alter(&$type){
  $type['actions']['#process'][] = 'boushh_form_process_actions';
}

/**
 * Processes a form actions container element.
 *
 * @param $element
 *   An associative array containing the properties and children of the
 *   form actions container.
 * @param $form_state
 *   The $form_state array for the form this element belongs to.
 *
 * @return
 *   The processed element.
 */
function boushh_form_process_actions($element, &$form_state) {
  foreach (element_children($element) as $key) {
    $item = &$element[$key];
    if(isset($item['#type']) && in_array($item['#type'], array('submit','button'))){
      $item['#attributes']['class'][] = 'medium';
      if($item['#value'] == 'Save'){
        $item['#attributes']['class'][] = 'primary';
      }
    }
  }
  return $element;
}

/**
 * Implements template_preprocess_html().
 *
 */
function boushh_preprocess_html(&$vars) {
  // Add theme class to body
  $vars['classes_array'][] = 'boushh';

  // Add Open Sans
  drupal_add_css('@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic,700italic,800italic);',$option['type'] = 'inline');
}


/**
 * Implements template_preprocess_page
 *
 */
function boushh_preprocess_page(&$vars) {

  $vars['title'] = drupal_get_title();
  if(!fett_icon($vars['title'])){
    $vars['title'] = '<i class="fa fa-th"></i> ' . drupal_get_title();
  }

  $vars['copyright'] = 'Powered by '.theme('image', array('path' => drupal_get_path('theme','boushh') . '/favicon.ico')).' '.l('August Ash', 'http://augustash.com', array('target'=>'_blank'));

  $vars['ops'] = array();
  $bar = NULL;
  if(!empty($vars['action_links'])){
    $items = $vars['action_links'];
    foreach($items as &$item){
      $item['#theme'] = $item['#theme'] . '__ops';
    }
    $bar['right'] = $items;
    $bar['right']['#prefix'] = '<ul class="right">';
    $bar['right']['#suffix'] = '</ul>';
  }
  $tabs = NULL;
  if(!empty($vars['tabs']['#primary'])){
    $items = $vars['tabs']['#primary'];
    $combined = array();
    foreach($items as &$item){
      $item['#theme'] = $item['#theme'] . '__ops';
      $children = array();
      if(!empty($item['#active'])){
        if(!empty($vars['tabs']['#secondary'])){
          $item['#link']['field_suffix'] = ' <i class="fa fa-caret-right"></i>';
          $secondary_items = $vars['tabs']['#secondary'];
          $last = key( array_slice( $secondary_items, -1, 1, TRUE ) );
          foreach($secondary_items as $key => &$child_item){
            $child_item['#theme'] = $child_item['#theme'] . '__ops';
            $child_item['#link']['attributes']['class'][] = 'secondary';
            // if($key == 0) $item['#link']['prefix'] = '<li class="divider"></li>';
            // if($key == $last) $child_item['#link']['suffix'] = '<li class="divider"></li>';
            // $item['#link']['localized_options']['attributes']['class'][] = 'button';
            $children[] = $child_item;
          }
        }
      }
      $combined[] = $item;
      if(!empty($children)) $combined = array_merge($combined, $children);
    }
    $tabs['primary'] = $combined;
  }
  if(!empty($tabs)){
    $bar['left']['#prefix'] = '<ul class="left">';
    $bar['left']['#suffix'] = '</ul>';
    $bar['left'] += $tabs;
  }
  if(!empty($bar)){

    $vars['ops']['#prefix'] = '<nav class="ops-bar" data-topbar>';
    $vars['ops']['#suffix'] = '</nav>';

    $items = array();
    $vars['ops']['title'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
      '#attributes' => array('class' => array('title-area')),
    );

    $vars['ops']['bar']['#prefix'] = '<section class="ops-bar-section">';
    $vars['ops']['bar']['#suffix'] = '</section>';
    $vars['ops']['bar'] += $bar;
  }
}

/**
 * Implements theme_menu_local_action().
 */
function boushh_menu_local_action($vars) {
  $link = $vars['element']['#link'];

  $output = '<li>';
  if (isset($link['href'])) {
    // Add section tab styling
    // $link['localized_options']['attributes']['class'] = array('tiny', 'button', 'secondary');

    // Add Font Awesome Icon
    fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
    $link_text = $link['title'];

    $output .= l($link_text, $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Implements theme_menu_local_action().
 */
function boushh_menu_local_action__ops($vars) {
  $link = $vars['element']['#link'];

  $output = '<li>';
  if (isset($link['href'])) {
    // Add section tab styling
    // $link['localized_options']['attributes']['class'] = array('button');

    // Add Font Awesome Icon
    fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
    $link_text = $link['title'];

    $output .= l($link_text, $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Implements theme_menu_local_task().
 */
function fett_menu_local_task__ops(&$vars) {
  $link = $vars['element']['#link'];
  $link['attributes'] = !empty($link['attributes']) ? $link['attributes'] : array();
  if(!empty($vars['element']['#active'])){
    $link['attributes']['class'][] = 'active';
  }

  // Add section tab styling
  // $link['localized_options']['attributes']['class'] = array('tiny', 'button', 'secondary');

  // Add Font Awesome Icon
  fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
  $link_text = $link['title'];

  if (!empty($vars['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }

    $link['localized_options']['attributes']['class'][] = 'disabled';
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  $output = '';
  if(!empty($link['prefix'])) $output .= $link['prefix'];
  $output .= '<li' . drupal_attributes($link['attributes']) . '>';
  if(!empty($link['field_prefix'])) $link_text = $link['field_prefix'] . $link_text;
  if(!empty($link['field_suffix'])) $link_text .= $link['field_suffix'];
  $output .= l($link_text, $link['href'], $link['localized_options']);
  $output .= "</li>\n";
  if(!empty($link['suffix'])) $output .= $link['suffix'];
  return  $output;
}

/**
 * Implements theme_links().
 */
function boushh_links($vars) {
  $links = $vars['links'];
  $attributes = $vars['attributes'];
  $heading = $vars['heading'];
  global $language_url;
  $output = '';

  if (count($links) > 0) {
    $output = '';

    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,

          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    // Add Foundation inline-list class if necessary.
    if(boushh_class_exists($attributes, 'inline')){
      $attributes['class'][] = 'inline-list';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page())) && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {// Add Font Awesome Icon
        fett_icon_link($link['title'], $link, TRUE, TRUE);
        $link_text = $link['title'];
        // Pass in $link as $options, they share the same keys.
        $output .= l($link_text, $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

/**
 * Implements theme_links__ctools_dropbutton
 */
function boushh_links__ctools_dropbutton($vars) {
  fett_foundation_add_js('foundation.dropdown.js');

  // Check to see if the number of links is greater than 1;
  // otherwise just treat this like a button.
  if (!empty($vars['links'])) {

    $is_drop_button = (count($vars['links']) > 1);

    // Provide a unique identifier for every button on the page.
    static $id = 0;
    $id++;

    // Add needed files
    if ($is_drop_button) {
      ctools_add_js('dropbutton');
      ctools_add_css('dropbutton');
    }
    ctools_add_css('button');

    // Wrapping div
    $class = 'ctools-no-js';
    $class .= ($is_drop_button) ? ' ctools-dropbutton' : '';
    $class .= ' ctools-button';
    if (!empty($vars['class'])) {
      $class .= ($vars['class']) ? (' ' . implode(' ', $vars['class'])) : '';
    }

    $output = '';

    $output .= '<div class="' . $class . '" id="ctools-button-' . $id . '">';

    // Add a twisty if this is a dropbutton
    if ($is_drop_button) {
      $vars['title'] = ($vars['title'] ? check_plain($vars['title']) : t('open'));

      $output .= '<div class="ctools-link">';
      if ($vars['image']) {
        $output .= '<a href="#" class="ctools-twisty ctools-image">' . $vars['title'] . '</a>';
      }
      else {
        $output .= '<a href="#" class="ctools-twisty ctools-text">' . $vars['title'] . '</a>';
      }
      $output .= '</div>'; // ctools-link
    }

    // The button content
    $output .= '<div class="ctools-content">';

    // Check for attributes. theme_links expects an array().
    $vars['attributes'] = (!empty($vars['attributes'])) ? $vars['attributes'] : array();

    // Remove the inline and links classes from links if they exist.
    // These classes are added and styled by Drupal core and mess up the default
    // styling of any link list.
    if (!empty($vars['attributes']['class'])) {
      $classes = $vars['attributes']['class'];
      foreach ($classes as $key => $class) {
        if ($class === 'inline' || $class === 'links') {
          unset($vars['attributes']['class'][$key]);
        }
      }
    }

    // Call theme_links to render the list of links.
    // $output .= theme_links(array('links' => $vars['links'], 'attributes' => $vars['attributes'], 'heading' => ''));
    $output .= theme('links', array('links' => $vars['links'], 'attributes' => $vars['attributes'], 'heading' => ''));
    $output .= '</div>'; // ctools-content
    $output .= '</div>'; // ctools-dropbutton
    return $output;
  }
  else {
    return '';
  }
}

/**
 * Implements theme_button().
 */
function boushh_button($vars) {
  $element = $vars['element'];
  $label = $element['#value'];
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  if(boushh_class_exists($element['#attributes'], 'button')){
    $element['#attributes']['class'][] = 'button';
  }

  // Prepare input whitelist - added to ensure ajax functions don't break
  $whitelist = _fett_element_whitelist();

  if (isset($element['#id']) && (in_array($element['#id'], $whitelist)) || preg_match('/^edit-displays-/', $element['#id'])) {
    return '<input' . drupal_attributes($element['#attributes']) . ">\n"; // This line break adds inherent margin between multiple buttons
  }
  else {
    // Add Font Awesome Icon
    $temp = array();
    fett_icon_button($label, $element);
    // boushh_icon_button($label, $element);

    if(!boushh_class_exists($element['#attributes'], array('tiny','small','medium','large'))){
      $element['#attributes']['class'][] = 'tiny';
    }

    if(!boushh_class_exists($element['#attributes'], array('primary','secondary','success','alert'))){
      $element['#attributes']['class'][] = 'secondary';
    }

    return '<button' . drupal_attributes($element['#attributes']) . '>'. $label ."</button>\n"; // This line break adds inherent margin between multiple buttons
  }
}

/**
 * Implements theme_form_element().
 */
function boushh_form_element($vars) {
  $element = &$vars['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  if(isset($element['#field_prefix']) || isset($element['#field_suffix'])){
    $attributes['class'][] = 'field-inline';
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $vars);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $vars) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/**
 * Implements theme_node_add_list().
 */
function boushh_node_add_list($vars) {
  fett_foundation_add_js('foundation.equalizer.js');

  $content = $vars['content'];
  $output = '';

  if ($content) {
    $output = '<ul class="node-type-list small-block-grid-2 medium-block-grid-4 large-block-grid-6" data-equalizer data-options="equalize_on_stack: true">';
    foreach ($content as $item) {
      $output .= '<li>';
      // $output .= '<div class="panel">';
      $options = array();
      $title = $item['title'];
      if(!empty($item['description'])){
        $output .= '<a href="'.url($item['href']).'" data-tooltip data-options="disable_for_touch:true" title="'.filter_xss_admin($item['description']).'" data-equalizer-watch>';
      }
      else{
        $output .= '<a href="'.url($item['href']).'" data-equalizer-watch>';
      }
      if($icon = fett_icon_link($title, $options, TRUE)){
        $output .= '<span class="icon">' . $title . '</span>';
      }
      elseif(module_exists('fawesome')){
        $output .= '<span class="icon"><i class="fa fa-file-text"></i></span>';
      }
      $output .= '<span class="title">' . $item['title'] . '</span>';
      // $output .= '<span class="description">' . filter_xss_admin($item['description']) . '</span>';
      $output .= '</a>';
      // $output .= '</div>';
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  else {
    $output = '<p>' . t('You have not created any content types yet. Go to the <a href="@create-content">content type creation page</a> to add a new content type.', array('@create-content' => url('admin/structure/types/add'))) . '</p>';
  }
  return $output;
}

/**
 * Implements theme_admin_block_content().
 */
function boushh_admin_block_content($vars) {
  fett_foundation_add_js('foundation.equalizer.js');

  $content = $vars['content'];
  $output = '';
  $two_cols = arg(1);

  if (!empty($content)) {
    $class = 'admin-list';
    $class .= $two_cols ? ' small-block-grid-1 medium-block-grid-2 large-block-grid-4 cols-2' : ' small-block-grid-2 medium-block-grid-4 large-block-grid-5 xlarge-block-grid-6 cols-1';
    if ($compact = system_admin_compact_mode()) {
      $class .= ' compact';
    }
    $output .= '<ul class="'.$class.'" data-equalizer data-options="equalize_on_stack: true">';
    foreach ($content as $item) {
      $output .= '<li>';
      // $output .= '<div class="panel">';
      if(!empty($item['description']) && !$compact){
        $output .= '<a href="'.url($item['href']).'" data-tooltip data-options="disable_for_touch:true" title="'.htmlspecialchars(strip_tags($item['description'])).'" data-equalizer-watch>';
      }
      else{
        $output .= '<a href="'.url($item['href']).'" data-equalizer-watch>';
      }
      $options = array();
      $title = $item['title'];
      if($icon = fett_icon_link($title, $options, TRUE)){
        $output .= '<span class="icon">' . $title . '</span>';
      }
      elseif(module_exists('fawesome')){
        $output .= '<span class="icon"><i class="fa fa-circle-o"></i></span>';
      }
      $output .= '<span class="title">' . $item['title'] . '</span>';
      // if (!$compact && isset($item['description'])) {
      //   $output .= '<span>' . filter_xss_admin($item['description']) . '</span>';
      // }
      $output .= '</a>';
      // $output .= '</div>';
      $output .= '</li>';
    }
    $output .= '</ul>';
  }
  return $output;
}

////////////////////////////////////////////////////////////////////////////////
// Utilities
////////////////////////////////////////////////////////////////////////////////

/**
 * Check to see if class exists
 */
function boushh_class_exists(&$attributes, $class = array()){  // Check for attributes. theme_links expects an array().
  $attributes = (!empty($attributes)) ? $attributes : array();
  if (!empty($attributes['class'])) {
    $attributes['class'] = is_array($attributes['class']) ? $attributes['class'] : array($attributes['class']);
    foreach($attributes['class'] as $key => $c) {
      // dsm($class);
      $class = !is_array($class) ? array($class) : $class;
      foreach($class as $cc){
        if(preg_match('/'.preg_quote($cc).'/i', $c)){
          return TRUE;
        }
      }
    }
  }
  return FALSE;
}
