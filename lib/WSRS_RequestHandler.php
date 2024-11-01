<?php

class WSRS_RequestHandler
{
    /**
     * @var WP_Query
     */
    private $wpQuery;

    /**
     * @var WSRS_BlacklistHandler
     */
    private $blacklist;

    public function __construct()
    {
        global $wp_query;

        $this->wpQuery = $wp_query;
        $this->blacklist = new WSRS_BlacklistHandler();
    }

    /**
     * @param mixed $request
     *
     * @return mixed
     */
    public function filterRequest($request)
    {
        if ($this->checkIfReferrerHostIsBlacklisted()) {
            $this->display404();
        }

        return $request;
    }

    /**
     * @return boolean
     */
    public function checkIfReferrerHostIsBlacklisted()
    {
        if (null === ($referrerHost = $this->getReferrerHost())) {
            return false;
        }
        $blacklist = $this->blacklist->getBlacklistArray();
        foreach ($blacklist as $blacklistedDomain) {
            if (false !== stripos($referrerHost, $blacklistedDomain)) {
                return true;
            }
        }

        return false;
    }

    public function display404($noTemplate = true)
    {
        status_header(404);
        if (!$noTemplate) {
            $this->wpQuery->set_404();
            get_template_part(404);
        }
        exit();
    }

    /**
     * @return string
     */
    private function getReferrerHost()
    {
        $referrer = $this->getReferrer();
        if (null === $referrer) {
            return null;
        }

        return parse_url($referrer, PHP_URL_HOST);
    }

    /**
     * @return string|null
     */
    private function getReferrer()
    {
        $ref = $this->getRawReferrer();
        if (
            false !== $ref
            && $ref !== wp_unslash($_SERVER['REQUEST_URI'])
            && $ref !== home_url() . wp_unslash($_SERVER['REQUEST_URI'])
        ) {
            if (function_exists( 'wp_validate_redirect')) {
                return wp_validate_redirect($ref, null);
            }
            return $ref;
        }

        return null;
    }

    /**
     * Ported and improved from wordpress function: wp_get_raw_referer
     *
     * @return array|bool|string
     */
    private function getRawReferrer()
    {
        if (array_key_exists('_wp_http_referer', $_REQUEST) && !empty($_REQUEST['_wp_http_referer'])) {
            return wp_unslash($_REQUEST['_wp_http_referer']);
        }
        if (array_key_exists('HTTP_REFERER', $_SERVER) && !empty($_SERVER['HTTP_REFERER'])) {
            return wp_unslash($_SERVER['HTTP_REFERER']);
        }

        return false;
    }

}
