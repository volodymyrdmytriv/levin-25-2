=== Social Media Tabs ===
Contributors: remix4
Donate link: http://www.designchemical.com/blog/index.php/wordpress-plugins/wordpress-plugin-social-media-tabs/#form-donate
Tags: social media, facebook, twitter, tweets, google+1, flickr, YouTube, pinterest, rss, profile, tabs, social networks, bookmarks, buttons, animated, jquery, flyout, sliding
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.5.4

Social media tabs allows you to add facebook, google +1, twitter, flickr, pinterest, YouTube subscription and RSS profiles and feeds to any widget area with stylish sliding tabs. Option also to have the tabs slide out from the side of the browsers.

== Description ==

Creates a widget, which adds sliding tabs, each with a social network profile or media feed. The tabs can be added to either a widget area or set to slide out from the side of the browser. Allows you to organise your many social media feeds into one compact, stylish and unique widget. Can handle multiple widgets on each page and the location of the sliding tab can be easily set from the widget control panel.

= Configuration Options =

General configuration can be set via the Wordpress admin menu option Settings --> Social Media Tabs

* Icons - To change the icons used for the social network tabs enter the full URL to your new icon image in the text boxes. The current active icons will show in the right-hand column.
* Default Skin - Check this box to disable the default skin that comes with the plugin.
* Open Links In New Window - Check the box if you wish all links within the media tabs open in a new browser window.
* Cache Results - Enter the number of minutes to cache each tab results. Leave blank to disable caching.
* Google +1 Options - API Key - An API Key is required by google in order to access your google feed. For more details on how to create your own API Key refer to:
[__FAQ -> Create Your Own Google API Key__](http://www.designchemical.com/blog/index.php/faq/create-your-own-google-api-key/)

= Custom Tab =

In addition to the preset social networks the plugin also includes an additional tab which can be used to display custom content. To add a custom widget enter the URL for the custom icon in the settings page.

In the widget control panel enter the shortcode that will generate the content into the "shortcode" field.

= Media Tabs Widget Options =

Each individual form can be customised via the widget control panel:

* Tabs - Select either a "static" or a "Slide Out" tabbed box
* Slider - direction of slider
* Width - Set the width of the tabs
* Height - Set the height of the tabs
* Location (Slide out tabs only) - Select the position of the tabs (Slide Out only).
* Offset (Slide out tabs only) - Position the slide out tabs by offsetting the location from the edge of the browser in pixels
* Animation Speed (Slide out tabs only) - The speed at which the tabbed section will open/close
* Auto-Close (Slide out tabs only) - If checked, the tabs will automatically slide closed when the user clicks anywhere in the browser window (Slide Out only).
* Load Open (for slide out tabs only) - If checked, the social media tabs will be displayed open when the page first loads.
* Tabs - Select the location of each profile type - tabs 1 to 4
* Open Tab - Default tab that will be open when the page first loads.

* Facebook -
** Facebook ID - Enter the profile ID
** Size - Width & Height of Facebook box in pixels
** Connections - Enter the number of connections to be displayed

* Google -
** Google ID - Enter the google profile ID
** Results - Maximum number of buzz results to show

* Twitter
** Widget URL - Enter the widget URL
** Widget ID - For more details on how to create your own Twitter Widget ID refer to:
[__FAQ -> Create Your Twitter Widget ID__](http://www.designchemical.com/blog/index.php/faq/creating-your-twitter-widget-id/)

* RSS
** URL - Enter the RSS Feed URL
** Title - The heading for the RSS feed tab
** Results - The number of feed results to display

* YouTube -
** Username - Enter your YouTube profile username
** Video ID - Enter a YouTube video ID if you wish to include a video in the widget

* Flickr
** User ID - Enter the User ID of the flickr gallery
** Title - The heading for the Flickr feed tab
** Results - The number of thumbnails to display

* Pinterest
** Username - Enter the Username of the pinterest account
** Title - The heading for the pinterest feed tab
** Results - The number of pins to display
** Follow Button - Check the box to include a pinterest follow button for your profile

* Custom
** Title - Title for the custom tab
** Shortcode - Enter the shortcode to create the content for the custom tab

[__More information See Plugin Project Page__](http://www.designchemical.com/blog/index.php/wordpress-plugins/wordpress-plugin-social-media-tabs/)

== Installation ==

1. Upload the plugin through `Plugins > Add New > Upload` interface or upload `social-media-tabs` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the widgets section, select the Social Media Tabs widget and add to one of your widget areas
4. Set the required settings and save your widget

== Frequently Asked Questions ==

[__Check out our social media tabs faq page__](http://www.designchemical.com/blog/index.php/frequently-asked-questions/social-media-tabs/)

== Screenshots ==

1. Social Media Tabs widget in edit mode
2. Example of tabs showing facebook widget

== Changelog ==

= 1.5.4 = 
* Updated: Minor styling

= 1.5.3 = 
* Updated: Remove PHP notices

= 1.5.2 = 
* Updated: Link for pinterest image

= 1.5.1 = 
* Updated: Minor updates to default styling

= 1.5 = 
* Updated: Change Twitter to use embedded widgets (API v1.1)

= 1.4.4 = 
* Edit: Change hook for jquery to wp_enqueue_scripts

= 1.4.3 = 
* Add: Code to reload jquery plugins if overwritten
* Edit: Change plugin path to use plugins_url()

= 1.4.1 =
* Updated: Redeclare class name

= 1.4 =
* Added: Caching option for tab results

= 1.3 = 
* Added: Google Plus feed
* Added: Flickr feed
* Added: Pinterest feed
* Added: Custom tab option

= 1.2.4 = 
* Fixed: Admin js file

= 1.2.3 = 
* Fixed: Twitter layout bug

= 1.2.2 = 
* Fixed: Bug with widget class

= 1.2.1 = 
* Added: Twitter follow button
* Fixed: Error with Magpie get_author

= 1.2 = 
* Added: YouTube subscription tab
* Removed: Google +1 feed

= 1.1 = 
* Fixed: Bug with tweets function

= 1.0 = 
* First release

== Upgrade Notice ==
