<?php include WPBEL_VIEWS_DIR . "layouts/header.php"; ?>
<div id="wpbel-body">
    <div class="wpbel-tabs wpbel-tabs-main">
        <div class="wpbel-tabs-navigation">
            <nav class="wpbel-tabs-navbar">
                <ul class="wpbel-tabs-list" data-content-id="wpbel-main-tabs-contents">
                    <?php
                    if (!empty($tabs_title)) :
                        $i = 1;
                        foreach ($tabs_title as $tab_key => $tab_label) :
                            $tab_disable = ($tab_key != 'activation' && (!isset($is_active) || $is_active === false)) ? "data-disabled='true'" : "data-disabled='false'";
                    ?>
                            <li>
                                <a class="<?php echo ($i == 1) ? 'wpbel-ml45' : ''; ?>" data-content="<?php echo $tab_key; ?>" data-type="main-tab" href="#" <?php echo sprintf('%s', $tab_disable); ?>>
                                    <?php echo $tab_label; ?>
                                </a>
                            </li>
                    <?php
                            $i++;
                        endforeach;
                    endif;
                    ?>
                </ul>
            </nav>
        </div>
        <div class="wpbel-tabs-contents" id="wpbel-main-tabs-contents">
            <?php if (!empty($tabs_content)) : ?>
                <?php foreach ($tabs_content as $content_key => $content_file) : ?>
                    <div class="wpbel-tab-content-item" data-content="<?php echo $content_key; ?>">
                        <?php
                        if (file_exists($content_file) && ($is_active === true || $content_key == 'activation')) {
                            include $content_file;
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include_once  WPBEL_VIEWS_DIR . "layouts/footer.php"; ?>