=== Stop Referrer Spam ===
Contributors: kwielo
Tags: analytics, referral, spam, referrer, block, blocking, statistics, referer, semalt, buttons-for-website, floating-share-buttons, analytics spam, referer spam, referrer spam, referal spam, referral spam, anti referer, anti referrer, anti referral, block analytics, anti-spam, antispam, spambot, spam-bot, spam bot, bot block, googlespam, google spam, spammers, referer attack, referral attack, google analytics spam, no spam, i hate spam, spam free
Donate link: https://bmc.link/wieloco
Requires at least: 4.0
Tested up to: 6.3.1
Stable tag: 1.3.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

If you see referral spam in your analytics and would like to block it, this plugin is for you.

== Description ==
This plugin blocks referrer spam that you see in your page statistics. This problem is also widely known as "spam referrer attacks".

= The biggest list of spammers =
Plugin uses the biggest public list of URLs that are considered as a spamming services; **over 2200 URLs** right now! List is provided by Matomo, the biggest open source analytics system. You can find it [here](https://github.com/matomo-org/referrer-spam-list); you can also contribute to that list by adding your own urls.

= Custom URLs =
Yep, you can add your own URLs to blacklist! In a flash! So easy...

= No annoying updates! =
This plugin uses service located on our servers to update the list of spammers, hence **you do not have to update the plugin** itself whenever list is updated.

= No need of an account! =
As it is said before, this plugin uses endpoint to get the actual list. That endpoint points to author's server (https://srs.wielo.co), but there is **no need of an account** to use it. And no worries, this plugin **do not** collect any data about the users :)

= Hassle-free! =
You can see the current list of blocked websites in the admin panel, under "Settings/Referral Spam". There is also time of the next update. That is it! No configuration needed! :)

= Free of any charges! =
It is completely free! Enjoy! :)

== Installation ==
= via Admin Panel =
* Go to "Plugins" -> "Add new"
* Search for "Stop Referrer Spam"
* Install the plugin and activate it.

= via FTP/SFTP =
* upload all plugin files to `wp-content/plugins/`
* go to "Plugins" -> "Installed plugins" and activate **Stop Referrer Spam**

== Frequently Asked Questions ==
= Does the plugin block **all** spam traffic? =
Well, no. Unfortunately some of the spam services uses techniques that makes them unrecognisable, but it still blocks nearly all of them :)

= Does the plugin use any of my data? =
No, not at all.

= Do I need an account to use it? =
Nope, no need of an account.

= Can I put my own URLs that I want to block? =
Yes you can! And each URL will be a wildcard. That means, if you put horrible-spam.com on the list, it will block all the trafic from that domain + sub-domains on any level.

== Screenshots ==

1. Stop Referrer Spam admin panel

== Upgrade Notice ==
Major security fixes, please update to the newest version.

== Changelog ==
* 1.3.2 - updated compatible version up to 6.3.1
* 1.3.1 - fixed security concern related to csrf token
* 1.3.0 - updated compatible version, few other bugfixes
* 1.2.9 - added csrf check on config page
* 1.2.8 - parametrised blacklist URL
* 1.2.7 - updated compatible version, made logs more detailed
* 1.2.6 - switched to new secured url with blacklist, few small changes to eliminate php notices
* 1.1.5 - adjusted to new WP version and fixed issue for some php versions
* 1.1.4 - improvements on plugin's admin page
* 1.1.3 - adjusted to new version
* 1.1.2 - copy changes
* 1.1.1 - updated version, and description for wildcards
* 1.1.0 - custom URLs are here! now you can add your own URL to blacklist; other fixes and improvements
* 1.0.5 - added check to ensure that the cron is set up; small changes on plugin's admin page
* 1.0.4 - added "refresh now" option; improved the script that updates the list
* 1.0.3 - now using wp function to get referrer, improved description
* 1.0.2 - changed description, corrected version number
* 1.0.1 - changed blacklist endpoint, removed short tags
* 1.0.0 - official release
