<?php


class WSRS_Initializer
{
    /**
     * @var WSRS_BlacklistHandler
     */
    private $blacklistHandler;

    public function __construct()
    {
        $this->blacklistHandler = new WSRS_BlacklistHandler();
        $this->requestHandler = new WSRS_RequestHandler();
        $this->configurationPage = new WSRS_ConfigurationPage();
        $this->cronScheduler = new WSRS_CronScheduler();

        // Filters
        add_filter('request', array($this->requestHandler, 'filterRequest'), 0);
        add_filter('request', array($this->cronScheduler, 'scheduleIfNotScheduled'), 15);

        // Actions
        add_action('admin_menu', array($this, 'adminMenu'));

        // Cron
        register_activation_hook(WSRS_PLUGIN_FILENAME, array($this, 'activateHook'));
        register_deactivation_hook(WSRS_PLUGIN_FILENAME, array($this, 'deactivateHook'));
        add_action(WSRS_Config::WSRS_CRON_HOOK_NAME, array($this->blacklistHandler, 'refreshBlacklist'));
    }

    public function adminMenu()
    {
        add_options_page(
            'Stop Referral Spam',
            'Referral Spam',
            'manage_options',
            'srs-config',
            array($this->configurationPage, 'configurationPage')
        );
    }

    public function activateHook()
    {
        delete_option(WSRS_Config::WSRS_OPTION_BLACKLIST);
        $this->blacklistHandler->refreshBlacklist();
        $this->cronScheduler->scheduleEvent();
    }

    public function deactivateHook()
    {
        delete_option(WSRS_Config::WSRS_OPTION_BLACKLIST);
        wp_clear_scheduled_hook(WSRS_Config::WSRS_CRON_HOOK_NAME);
    }


}
