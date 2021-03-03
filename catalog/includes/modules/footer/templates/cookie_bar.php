<div class="alert alert-light mh-100 overflow-auto fixed-bottom m-0 rounded-0 border shadow-lg fade show">
  <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
  <div class="container">
    <h5 class="alert-heading"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_TITLE; ?></h5>
    <p><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_DESCRIPTION; ?></p>
    <p class="text-center">
      <button type="button" class="btn btn-link" data-bs-toggle="collapse" data-cookie-groups="<?php echo implode (', ', $cookie_groups); ?>" href="#cookie-bar" role="button" aria-expanded="false" aria-controls="cookie-bar"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_COOKIES_SETTING; ?></button>
      <button type="button" id="cookies-disable-all" class="btn btn-primary" data-bs-dismiss="alert" aria-label="Close"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_DISABLE_ALL; ?></button>
      <button type="button" id="cookies-allow-all" class="btn btn-primary" data-bs-dismiss="alert" aria-label="Close"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_ALLOW_ALL; ?></button>
    </p>
    <div class="collapse" id="cookie-bar">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_USES_COOKIES; ?></h5>
          <div class="card-text">
            <p><?php echo sprintf(MODULE_FOOTER_COOKIE_BAR_TEXT_COOKIES_DESCRIPTION, tep_href_link('information.php', 'pages_id=5'), tep_href_link('information.php', 'pages_id=2')); ?></p>

            <div class="mb-3">
              <?php echo tep_draw_checkbox_field('necessary', '', true, 'class="form-check-input" id="cookies-necessary"  disabled'); ?>
              <label class="form-check-label fw-bold" for="cookies-necessary" style="opacity: 1;">
                <?php echo MODULE_FOOTER_COOKIE_BAR_COOKIE_GROUP_NECESSARY; ?>
              </label>
            </div>
            <p><?php echo MODULE_FOOTER_COOKIE_BAR_COOKIE_GROUP_NECESSARY_DESCRIPTION; ?></p>

            <?php
            foreach ($cookie_groups as $cookie_group) {
              ?>

              <div class="mb-3">
                <?php echo tep_draw_checkbox_field($cookie_group, '', false, 'class="form-check-input" id="cookies-' . $cookie_group . '"'); ?>
                <label class="form-check-label fw-bold" for="cookies-<?php echo $cookie_group; ?>">
                  <?php echo constant('MODULE_FOOTER_COOKIE_BAR_COOKIE_GROUP_' . strtoupper($cookie_group)); ?>
                </label>
              </div>
              <p><?php echo constant('MODULE_FOOTER_COOKIE_BAR_COOKIE_GROUP_' . strtoupper($cookie_group) . '_DESCRIPTION'); ?></p>

              <?php
            }
            ?>

            <div class="text-center">
              <button type="button" class="btn" data-bs-toggle="collapse" data-bs-target="#cookie-bar" role="button" aria-expanded="false" aria-controls="cookie-bar"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_HIDE; ?></button>
              <button type="button" class="btn btn-primary" data-bs-dismiss="alert" aria-label="Close"><?php echo MODULE_FOOTER_COOKIE_BAR_TEXT_SAVE_CHANGES; ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
