<?php


class WSRS_Helper
{
    /**
     * @param bool|false $niceDisplay
     *
     * @return bool|int|string
     */
    public static function getNextUpdateTime($niceDisplay = false)
    {
        if ($niceDisplay) {
            return date('H:i, d/m/y', wp_next_scheduled(WSRS_Config::WSRS_CRON_HOOK_NAME));
        }

        return wp_next_scheduled(WSRS_Config::WSRS_CRON_HOOK_NAME);
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    public static function url($parameters = array())
    {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parsedUrl['query'], $parsedParams);
        $parameters = array_merge($parsedParams, $parameters);
        $url = esc_url(add_query_arg($parameters));

        return $url;
    }

    /**
     * @return string
     */
    public static function plugin_admin_page_url()
    {
        return admin_url('options-general.php?page=srs-config');
    }

    /**
     * @param string $var
     * @param bool $default
     *
     * @return mixed
     */
    public static function get($var, $default = false)
    {
        return isset($_GET[$var]) ? $_GET[$var] : $default;
    }

    /**
     * @return bool
     */
    public static function is_post()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * @return mixed
     */
    public static function get_post()
    {
        return $_POST;
    }

    public static function has_field($name)
    {
        $post = self::get_post();
        return array_key_exists($name, $post);
    }

    public static function get_field($name, $default = null)
    {
        if (!self::is_post() || !self::has_field($name)) {
            return $default;
        }
        $post = self::get_post();
        return $post[$name];
    }

    public static function is_force_refresh()
    {
        return (self::is_post() && self::has_field('force_refresh'));
    }

    public static function is_save_custom_urls()
    {
        return (self::is_post() && self::has_field('custom_urls'));
    }

    public static function get_csrf_token()
    {
        $token = get_option(WSRS_Config::WSRS_CSRF_TOKEN, null);

        return $token;
    }

    public static function check_csrf_token($token)
    {
        return (
            !empty(trim($token))
            && self::has_field('csrf_token')
            && !empty(trim(self::get_field('csrf_token')))
            && self::get_field('csrf_token') === $token
        );
    }

    public static function get_wp_version()
    {
        $versionCheck = get_bloginfo('version');

        return $versionCheck;
    }
}
