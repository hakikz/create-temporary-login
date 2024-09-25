=== WP Bifröst - Instant Passwordless Temporary Login Links ===
Contributors: Hakik
Tags: temporary login, passwordless login, temporary access, login
Requires PHP: 7.4
Requires at least: 6.2
Tested up to: 6.6
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

🔗️ Create passwordless temporary login links. Instantly ⚡️

== Description ==

**WP Bifröst** is a WordPress plugin that helps create instant passwordless login links. Use those links to securely allow people temporary admin access to your WordPress site (dashboard).

As WordPress site owners, we frequently give temporary admin access to people. Among many cases, giving temporary admin access to support engineers to troubleshoot an issue is prominent. In contrast with the default process of creating a user, **WP Bifröst** can instantly create a secure login link.

=== How to Create Passwordless Temporary Login Links for WordPress ===

The following video demonstrates creating a temporary login link for WordPress using **WP Bifröst**.

[youtube https://www.youtube.com/watch?v=jMTwoAtKlUk]

How often do you need to allow someone access to your WordPress site? There are many cases when you need to allow people access to your site, including support engineers. 

Allowing temporary access to your WordPress site was never easier. Create a temporary login URL to give people instant access to your site. You don't need any email address, username or password.


## 🔐️ Feature Highlight of WP Bifröst

🔑️ Instantly create passwordless temporary login links for WP.

🔑️ Remove/delete temporary login links anytime you want.

🔑️ By default, the temporary login links are valid for 7 days.

🔑️ You can increase the validity by 3 days for expired login links.


## How does WP Bifröst work

You can create passwordless temporary login links after successfully installing **WP Bifröst** on your WordPress site. Like most WordPress plugins installation is very straightforward. Moreover, it does not require any additional configuration.

WP Bifröst adds its option as a sub-menu under the WordPress **User** menu. You can also quickly access the menu from the installed plugins section. Under the plugin name, there is a quick link called **Create Login Links**. Click on **Create Login Links** to access plugin settings. You can create temporary login links from here by clicking the Generate button.

By default, temporary login links are valid for 7 days. When the link expires after 7 days, you will find an option to extend the validity. You can extend validity for 3 days (you can keep repeating this process as long as necessary).


## WP Bifröst prioritizes security

🔒️ Though we want to add ease to your workflow, site security is our top priority. As a result, we have coupled ease and security together.

🔒️ First, the temporary login link appends a cryptographically secure random byte stream. As a result, there is no pattern for people to predict/target.

🔒️ Second, the link expires in 7 days. So, even if you don’t remove a link, access to your dashboard will not work.

🔒️ On top of that, people who access your dashboard using the passwordless temporary login links, cannot access the **User** menu. As a result, they cannot create a new user or modify an existing user.


== Installation ==
1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the wp-content/plugins/ directory of your WordPress installation.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.
3. Go to the Temporary Login tab within the Users menu.
4. Click "Generate a link", and you’re all set.

== Frequently Asked Questions ==

= Why should I use WP Bifröst? =
**WP Bifröst** aims to add ease to your workflow by simplifying user creation on your WordPress site. To create a WordPress user, you must perform at least four steps. Those steps include setting a username, email address, password, and the user's role.

WP Bifröst simplifies the process and empowers you to create a passwordless login with a single click.

= What if I forget to revoke access? =
Not to worry. The URL is automatically disabled at the expiration time with no action needed on your part.

= Can I share a feature request? =
Yes, we appreciate your feedback and ideas. Please share your feature request here.

== Screenshots ==

1. Direct link to create the temporary login link.
2. Temporary Login submenu under the Users menu.
3. Click on this 'Generate a link' button to generate a temporary login link.
4. Click on the link to copy the link to the clipboard.
5. Delete icon to remove the temporary login link.
6. Extend the time for the link for 3 days.

== Changelog ==

= 1.0.5 =
* Fix: Disallowed a temporary user to access plugin setting page using a link.

= 1.0.4 =
* Update: Extend time for 3 days is always visible now.

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

