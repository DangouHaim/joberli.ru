<div id="loginBox" class="lightbox-wrapper">
    <div class="lightbox-content">
        <div class="lightbox-area">
            <div class="lightbox">
                <div class="boxed">
                    <div class="lightbox-close">
                        <div class="close-btn">
                            <span class="close-icon">
                                <i class="demo-icon icon-cancel"></i>
                            </span>
                        </div>
                    </div>
                    <div class="boxed-body signin-area">
                        <div class="lightbox-title"><?php esc_html_e('Войти','olam'); ?></div>
                        <form id="olam-login">
                            <!-- additional fields start -  -->
                            <p class="olam-msg-status"></p>
                            <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
                            <!-- additional fields end -  -->
                            <div class="field-holder">
                                <label><i class="demo-icon icon-user"></i> <?php esc_html_e('Имя','olam'); ?></label>
                                <input id="username" name="name" type="text">
                            </div>
                            <div class="field-holder">
                                <label><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e('Пароль','olam'); ?></label>
                                <input id="password" type="password">
                            </div>
                            <div class="btn-pro-frame">
                            <input id="olam-pop-login-submit" type="submit" value="<?php esc_attr_e('Войти','olam'); ?> " class="btn btn-md btn-white">
                            <span class="btn-pro"><img src="<?php echo get_template_directory_uri(); ?>/img/reload.gif"></span>
                            </div>
                        </form>
                        <p class="edd-lost-password">
                    <a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_html_e( 'Забыли пароль', 'olam' ); ?>">
                        <?php esc_html_e( 'Забыли пароль?', 'olam' ); ?>
                    </a>
                </p>
                        <div class="social"><?php if(shortcode_exists('edd_social_login')){ echo do_shortcode('[edd_social_login]'); } ?></div>
                    </div>
                    <div class="boxed-head toggle-signup">
                        <div class="lightbox-subtitle"><?php esc_html_e("У вас нет аккаунта?","olam"); ?> </div>
                        <div class="lightbox-title"><?php esc_html_e("Зарегистрироваться","olam"); ?></div>
                        <div class="signup-icon"><span><i class="demo-icon icon-rocket"></i></span></div>
                    </div>
                    <div class="boxed-body signup-area">
                        <form id="olam-register">
                            <p class="status"></p>
                            <!-- additional fields start -  -->
                            <p class="olam-msg-status"></p>
                            <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>   
                            <!-- additional fields end -  -->  
                            <div class="field-holder">
                                <label><i class="demo-icon icon-user"></i> <?php esc_html_e('Имя','olam'); ?></label>
                                <input id="reg-username" name="username" type="text">
                            </div>
                            <div class="field-holder">
                                <label><i class="demo-icon icon-mail-alt"></i> <?php esc_html_e('Email','olam'); ?></label>
                                <input name="email" id="reg-email" type="text">
                            </div>
                            <div class="field-holder">
                                <label><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e('Пароль','olam'); ?></label>
                                <input name="password" id="reg-password" type="password">
                            </div>
                            <div class="field-holder">
                                <label><i class="demo-icon icon-lock-filled"></i> <?php esc_html_e('Подтвердите пароль','olam'); ?></label>
                                <input id="reg-password2" name="password2" type="password">
                            </div>
                            <div class="btn-pro-frame">
                                <input type="submit" value="<?php esc_attr_e('Зарегистрировиться','olam'); ?>" class="btn btn-md btn-white">
                                <span class="btn-pro"><img src="<?php echo get_template_directory_uri(); ?>/img/reload.gif"></span>
                            </div>
                        </form>
                        <div class="social"><?php if(shortcode_exists('edd_social_login')){ echo do_shortcode('[edd_social_login]'); } ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lightbox-overlay"></div>
</div>