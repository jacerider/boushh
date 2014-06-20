<!--.page -->
<div role="document" class="page">

  <!--.l-header -->
  <header role="banner" class="l-header">

    <?php if ($top_bar): ?>
      <!--.top-bar -->
      <?php print render($top_bar); ?>
      <!--/.top-bar -->
    <?php endif; ?>

    <!-- Title, slogan and menu -->
    <?php if ($alt_header && FALSE): ?>
      <section class="row <?php print $alt_header_classes; ?>">
        <div class="large-12 columns">

          <?php if ($linked_logo): print $linked_logo; endif; ?>

          <?php if ($site_name): ?>
            <?php if ($title): ?>
              <div id="site-name" class="element-invisible">
                <strong>
                  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                </strong>
              </div>
            <?php else: /* Use h1 when the content title is empty */ ?>
              <h1 id="site-name">
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
              </h1>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($site_slogan): ?>
            <h2 title="<?php print $site_slogan; ?>" class="site-slogan"><?php print $site_slogan; ?></h2>
          <?php endif; ?>

          <?php if ($alt_main_menu): ?>
            <nav id="main-menu" class="navigation" role="navigation">
              <?php print ($alt_main_menu); ?>
            </nav> <!-- /#main-menu -->
          <?php endif; ?>

          <?php if ($alt_secondary_menu): ?>
            <nav id="secondary-menu" class="navigation" role="navigation">
              <?php print $alt_secondary_menu; ?>
            </nav> <!-- /#secondary-menu -->
          <?php endif; ?>

        </div>
      </section>
    <?php endif; ?>

    <?php if (!empty($page['page_header'])): ?>
      <!--.l-header-region -->
      <section class="l-header-region row">
        <div class="large-12 columns">
          <?php print render($page['page_header']); ?>
        </div>
      </section>
      <!--/.l-header-region -->
    <?php endif; ?>

  </header>
  <!--/.l-header -->

  <?php if ($breadcrumb): ?>
    <!--.l-breadcrumb -->
    <section class="l-breadcrumb row">
      <div class="large-12 columns">
        <?php print $breadcrumb; ?>
      </div>
    </section>
    <!--/.l-breadcrumb -->
  <?php endif; ?>

  <?php if ($messages && !$fett_messages_modal): ?>
    <!--.l-messages -->
    <section class="l-messages row">
      <div class="large-12 columns">
        <?php if ($messages): print $messages; endif; ?>
      </div>
    </section>
    <!--/.l-messages -->
  <?php endif; ?>

  <?php if (!empty($page['help'])): ?>
    <!--.l-help -->
    <section class="l-help row">
      <div class="large-12 columns">
        <?php print render($page['help']); ?>
      </div>
    </section>
    <!--/.l-help -->
  <?php endif; ?>

  <!--.l-main-->
  <main role="main" class="row l-main">
    <div class="<?php print $main_grid; ?> main columns">
      <div class="main-inner">

        <a id="main-content"></a>

        <?php if ($title && !$is_front): ?>
          <?php print render($title_prefix); ?>
          <h1 id="page-title" class="title"><?php print $title; ?></h1>
          <?php print render($title_suffix); ?>
        <?php endif; ?>

        <div class="main-content">

          <?php if (!empty($tabs) && FALSE): ?>
            <?php print render($tabs); ?>
            <?php if (!empty($tabs2)): print render($tabs2); endif; ?>
          <?php endif; ?>

          <?php if ($action_links && FALSE): ?>
            <nav class="top-bar" data-topbar>
              <ul class="title-area">
                <li class="name">
                  <h1><a href="#"><?php print t('Actions'); ?></a></h1>
                </li>
                 <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
              </ul>
              <section class="top-bar-section">
                <ul class="left">
                  <?php print render($action_links); ?>
                </ul>
              </section>
            </nav>
          <?php endif; ?>

          <?php if ($ops): ?>
            <?php print render($ops); ?>
          <?php endif;?>

          <?php print render($page['content']); ?>

        </div>

      </div>
    </div>
    <!--/.l-main region -->

    <?php if (!empty($page['boushh_sidebar_first'])): ?>
      <aside role="complementary" class="<?php print $sidebar_first_grid; ?> l-sidebar-first columns sidebar">
        <?php print render($page['boushh_sidebar_first']); ?>
      </aside>
    <?php endif; ?>

    <?php if (!empty($page['boushh_sidebar_second'])): ?>
      <aside role="complementary" class="<?php print $sidebar_sec_grid; ?> l-sidebar-second columns sidebar">
        <?php print render($page['boushh_sidebar_second']); ?>
      </aside>
    <?php endif; ?>
  </main>
  <!--/.l-main-->

  <?php if (!empty($page['page_footer'])): ?>
    <!--.l-footer-->
    <footer class="l-footer panel row" role="contentinfo">
      <div id="footer" class="large-12 columns">
        <?php print render($page['page_footer']); ?>
      </div>
    </footer>
    <!--/.footer-->
  <?php endif; ?>

  <div class="l-copyright row">
    <div id="copyright" class="large-12 columns">
      <small><?php print $copyright; ?></small>
    </div>
  </div>

  <?php if ($messages && $fett_messages_modal): print $messages; endif; ?>
</div>
<!--/.page -->
