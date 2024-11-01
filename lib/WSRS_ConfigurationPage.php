<?php


class WSRS_ConfigurationPage
{
    /**
     * @var WSRS_BlacklistHandler
     */
    private $blacklistHandler;

    /**
     * @var array
     */
    private $data = array();

    /**
     * @var string
     */
    private static $noticeTpl = '<div class="updated notice"><p>%s</p></div>';

    /**
     * @var string
     */
    private static $errorTpl = '<div class="updated error"><p>%s</p></div>';

    public function __construct()
    {
        $this->blacklistHandler = new WSRS_BlacklistHandler();
    }

    public function configurationPage()
    {
        $this->processParameters();
        $data = $this->data;
        $data['blacklist'] = $this->blacklistHandler->getBlacklistArray();
        $data['custom_urls'] = get_option(WSRS_Config::WSRS_OPTION_CUSTOM_URLS, '');
        $data['csrf_token'] = $this->generateCsrfToken();

        include_once(WSRS_ROOT_DIR."/views/config-page.php");
    }

    public function processParameters()
    {
        $token = WSRS_Helper::get_csrf_token();
        if (
            WSRS_Helper::is_post() 
            && !WSRS_Helper::check_csrf_token($token)
        ) {
            $this->data['invalid_csrf'] = $this->displayInvalidCsrfToken();
            return;
        }

        if (WSRS_Helper::is_force_refresh()) {
            $this->blacklistHandler->refreshBlacklist();
            $this->data['refresh_message'] = $this->displayUpdateNotice();
            return;
        } else if (WSRS_Helper::is_save_custom_urls()) {
            if ($this->saveCustomUrls()) {
                $this->data['save_message'] = $this->displaySaveNotice();
            }
            return;
        }
    }

    public function generateCsrfToken()
    {
        $token = sha1(uniqid(mt_rand(), true));
        update_option(WSRS_Config::WSRS_CSRF_TOKEN, $token);

        return $token;
    }

    /**
     * @return bool
     */
    public function saveCustomUrls()
    {
        $postData = WSRS_Helper::get_post();
        $customUrls = trim($postData['custom_urls']);
        $customUrlsArray = explode("\n", $customUrls);
        $customUrlsArray = array_filter(array_map(array($this, 'cleanUrlsBeforeSave'), $customUrlsArray));
        update_option(WSRS_Config::WSRS_OPTION_CUSTOM_URLS, implode("\n", $customUrlsArray), true);
        
        return true;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function cleanUrlsBeforeSave($url) {
        $url = trim($url);
        return strpos($url, 'http') === 0 ? parse_url($url, PHP_URL_HOST) : $url;
    }

    /**
     * @return string
     */
    public function displayUpdateNotice()
    {
        $message = "Blacklist is now up to date 👾";
        return sprintf(self::$noticeTpl, $message);
    }

    /**
     * @return string
     */
    public function displaySaveNotice()
    {
        $message = "Custom URLs have been saved 🎉";
        return sprintf(self::$noticeTpl, $message);
    }

    /**
     * @return string
     */
    public function displayInvalidCsrfToken()
    {
        $message = "Ooops! Security! Call the Security! 👮‍♂️ Wrong CSRF token provided.";
        return sprintf(self::$errorTpl, $message);
    }
}
