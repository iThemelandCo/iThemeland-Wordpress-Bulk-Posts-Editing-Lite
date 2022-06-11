<div class="wpbel-modal" id="wpbel-modal-new-post-taxonomy">
    <div class="wpbel-modal-container">
        <div class="wpbel-modal-box wpbel-modal-box-sm">
            <div class="wpbel-modal-content">
                <div class="wpbel-modal-title">
                    <h2><?php esc_html_e('New Post Taxonomy', WPBEL_NAME); ?> - <span id="wpbel-modal-new-post-taxonomy-post-title" class="wpbel-modal-item-title"></span></h2>
                    <button type="button" class="wpbel-modal-close" data-toggle="modal-close">
                        <i class="lni lni-close"></i>
                    </button>
                </div>
                <div class="wpbel-modal-body">
                    <div class="wpbel-wrap">
                        <div class="wpbel-form-group">
                            <div class="wpbel-new-post-taxonomy-form-group">
                                <label for="wpbel-new-post-taxonomy-name"><?php esc_html_e('Name', WPBEL_NAME); ?></label>
                                <input type="text" id="wpbel-new-post-taxonomy-name" placeholder="<?php esc_html_e('Taxonomy Name ...', WPBEL_NAME); ?>">
                            </div>
                            <div class="wpbel-new-post-taxonomy-form-group">
                                <label for="wpbel-new-post-taxonomy-slug"><?php esc_html_e('Slug', WPBEL_NAME); ?></label>
                                <input type="text" id="wpbel-new-post-taxonomy-slug" placeholder="<?php esc_html_e('Taxonomy Slug ...', WPBEL_NAME); ?>">
                            </div>
                            <div class="wpbel-new-post-taxonomy-form-group">
                                <label for="wpbel-new-post-taxonomy-parent"><?php esc_html_e('Parent', WPBEL_NAME); ?></label>
                                <select id="wpbel-new-post-taxonomy-parent">
                                    <option value="-1"><?php esc_html_e('None', WPBEL_NAME); ?></option>
                                </select>
                            </div>
                            <div class="wpbel-new-post-taxonomy-form-group">
                                <label for="wpbel-new-post-taxonomy-description"><?php esc_html_e('Description', WPBEL_NAME); ?></label>
                                <textarea id="wpbel-new-post-taxonomy-description" rows="8" placeholder="<?php esc_html_e('Description ...', WPBEL_NAME) ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpbel-modal-footer">
                    <button type="button" class="wpbel-button wpbel-button-blue" id="wpbel-create-new-post-taxonomy">
                        <?php esc_html_e('Create', WPBEL_NAME); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>