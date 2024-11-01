<?php


class WSRS_Config
{
    const WSRS_VERSION = '1.3.2';
    const WSRS_BLACKLIST_SOURCE_WEBSITE = 'https://github.com/matomo-org/referrer-spam-list';
    const WSRS_BLACKLIST_SOURCE = 'https://srs.wielo.co/blacklist-v2.json';
    const WSRS_CRON_HOOK_NAME = 'wsrs_update_blacklist_twicedaily';
    const WSRS_OPTION_BLACKLIST = 'WSRS_spam_blacklist';
    const WSRS_OPTION_CUSTOM_URLS = 'WSRS_spam_custom_urls';
    const WSRS_CSRF_TOKEN = 'WSRS_csrf_token';
}
