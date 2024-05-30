=== WP Bifröst - Create Passwordless Temporary Login Links ===
Contributors: Hakik
Tags: temporary login, passwordless login, temporary access, login
Requires PHP: 7.4
Requires at least: 6.2
Tested up to: 6.5
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create passwordless temporary login links to easily give access to your site's dashboard.

== Description ==

WP Bifröst helps you create secure passwordless links that allow instant access to your WordPress dashboard.

=== How to Create Passwordless Temporary Login Links? ===

[youtube https://www.youtube.com/watch?v=jMTwoAtKlUk]

How often do you need to allow someone access to your WordPress site? There are many cases when you need to allow people access to your site, including support engineers. 

Allowing temporary access to your WordPress site was never easier. Create a temporary login URL to give people instant access to your site. You don't need any email address, username or password.


## Features HIghlights:

* Create passwordless instant login links for your WordPress site
* Delete a login link when there is no use for it
* Login links are valid for 7 days
* You can increase the validity for 3 days

== Installation ==
1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the wp-content/plugins/ directory of your WordPress installation.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Go to the Temporary Login tab within the Users menu.
4. Click "Generate a link", and you’re all set.

== Frequently Asked Questions ==

= What if I forget to revoke access? =
Not to worry. The URL is automatically disabled at the expiration time with no action needed on your part.

== Screenshots ==

1. Direct link to create the temporary login link.
2. Temporary Login submenu under the Users menu.
3. Click on this 'Generate a link' button to generate a temporary login link.
4. Click on the link to copy the link to the clipboard.
5. Delete icon to remove the temporary login link.
6. Extend the time for the link for 3 days.

== Changelog ==

= 1.0.3 =
* Security: Temporary users are not allowed to access the User/Profile menu.
* Tweak: `admin_init` was changed with `wp_dashboard_setup` to control capabilities and admin menu.
* Appearance: Fixed the outline style of the delete button and added a tooltip for clear instruction.

= 1.0.2 =
* Add: Disallow the temporary user to delete an user of the site.
* Add: POT file added.
* Fix: Text domain for a method.
* Fix: Headers already sent warning after deleting a link.

= 1.0.1 =
* Fix: Plugin file header, sanitize for wp_nonce, prefix related issue, internationalization issues.

= 1.0.0 =
* Initial release

