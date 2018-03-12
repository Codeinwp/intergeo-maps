=== Google Maps Plugin by Intergeo ===
Contributors: codeinwp,intergeomaps,hardeepasrani,themeisle,Madalin_ThemeIsle,uriahs-victor,rozroz
Tags:  directions, easy map, google, google map, google map plugin, google maps, latitude, location, longitude, map, map directions, map markers, map plugin, map widget, maps, marker, polygons, polylines, routes, store locator, streetview, wp google map, wp google maps, wp maps,plugin,admin,widget,shortcode,google maps, maps, map, map markers, google, google map, maps api, wp maps, wp google maps, easy map, embed, marker, placemark, icon, geocode, shortcode, custom post type, multisite, marker clustering
Requires at least: 3.5
Tested up to: 4.9
Stable tag: trunk
License: GPL v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php

A simple, easy and quite powerful Google Maps tool to create, manage and embed custom Google Maps & markers into your WordPress posts and pages.

== Description ==

The Intergeo Google Maps WordPress plugin is the best tool for handling Google Maps in your website. This simple WordPress map plugin allow users to create new custom maps by using powerful UI map builder. Created maps could be easily edited and saved with new settings. To increase the speed of creation process the plugin has ability to clone a map with all it's settings. Finally the plugin has attractive library which allows users to browse all maps in the system and delete unnecessary maps.
We've also built some fantastic <a href="http://themeisle.com/wordpress-themes/business/" rel="nofollow" target="_blank">business themes</a> that integrate with Intergeo Google Maps perfectly, check them out.

The powerful UI builder allows users to:

* Setup initial position and zooming level of a map;
* Adjust controls settings and positioning; 
* Add multiple locations
* WordPress location custom map 
* Setup map color styles by using predefined color schemes or by using custom color settings;
* Add markers;

> **Time-saving features available in the FULL version:**
>
> * Add overlays like  rectangles, circles, polylines and polygons using the build or the drawing tools;
> * Create directions routes from A address to B address;
> * Integrate AdSense service into your maps and earn money by displaying ads on maps.
> * Import/Export Markers
> * Custom Layers
> * Support and updates for 12 months
>
> **[Learn more about Intergeo Maps Pro version]( https://themeisle.com/plugins/intergeo-maps/ )**


### Create Google maps with shortcode ###

To create new WordPress maps you just can input simple shortcode into your post, page, text widget or taxonomy description:

`[intergeo]Your address[/intergeo]`

This shortcode will be displayed as Google Maps centered at specific address. The shortcode could be extended with custom attributes like height, width, zoom, etc. These attributes will setup special settings for a map. 


The following table describes all possible attributes, which users can use with shortcodes:

**Width**
Sets width of the map container. Accepts all valid CSS values as css width property accepts. For example, the value could be set in pixels like 500px, or in percentage like 75%. Default value is 100%.

**Height**
Sets width of the map container. Accepts all valid CSS values as css height property accepts. For example, the value could be set in pixels like 700px. Default value is 300px.

**Style**
This attribute allows users to set extra styles for Google map's container element. It accepts all valid css properties and will echo it in the style attribute of the container element. Default value is empty.

**Zoom**
Sets the initial zoom level of the map. This attribute accepts integer value from 0 to 19, where 0 is the biggest distance and 19 is the lowest distance to the ground. The default value is 5.

**Hook**
This attribute allows users to setup their own filter, which will be used to filter settings of a map before using it to render a map. Hooks for the filter will receive one parameter which will be array of options and they have to return it modified or not.

So your shortcode could looks like this one:

`[intergeo zoom="12" width="50%" height="400px" style="border: 3px solid red; margin: 0 auto;"]Central Park, NY[/intergeo]`

Check-out the <a href="http://themeisle.com/plugins/intergeo-maps-lite/" rel="nofollow">#1 free Google Maps plugin</a>

### Create map with UI builder ###

Another way to create map is to use UI builder. This is more recommended way to build a Google map as this way provides much more features and wide range of settings to customize. To create a map with UI builder, pass following steps:

1. Create a new post or a page, or just edit existing one;
1. Place the mouse cursor into the content editor, at the place you want to embed a map and click on **Add Media** button above editor toolbar;
1. When media popup appears, find **Intergeo Maps** link in the left sidebar of popup window, click on the link;
1. Now you have to see Intergeo UI builder which allows you to customize your map;
1. Use all tools from right sidebar of the builder to create a map you need;
1. After finishing maps configuration click on **Insert into post**  button at the footer of the builder;
1. After doing it a map has to be saved in background, popup has to be closed and new appropriate shortcode has to be inserted into the place, where your cursor was.

### Using maps library ###

All maps which have been created with UI builder are stored in WordPress database. The plugin allows to browse and manage these Google maps in the maps library. To see it go to the **Media** » **Intergeo Maps** page to see all maps which have been created in your website.

The library shows you maps preview as you will see it at front end pages. Here users can copy shortcode of a Google map, edit or clone maps, and delete unnecessary or deprecated maps. 

Also users can create a Google map from library page. To do it just click on **Add New** button next to the page title and UI builder popup immediately appears. The builder interacts in the same way as it does at edit posts page, except that popup doesn't insert shortcode into somewhere, popup just save a map into database for future reuse.

**About us:**

We are a young team of WordPress enthusiasts who enjoy developing <a href="http://themeisle.com/wordpress-plugins/" rel="nofollow" target="_blank">free WordPress plugins</a> and <a href="http://themeisle.com/wordpress-themes/" rel="nofollow" target="_blank">themes</a> for small businesses and startups. Check them out and let us know what you think, our goal is to build fully fledged products that will solve your needs.

We also love to blog at CodeinWP and help our users finding the <a href="http://www.codeinwp.com/blog/best-wordpress-shared-hosting-providers/" rel="nofollow">best hosting</a> or <a href="http://justfreethemes.com/" rel="nofollow">themes</a>.

**More from us**

- <a href="http://justfreethemes.com/" rel="nofollow" target="_blank">JustFreeThemes</a> - Find the best free WordPress Themes
- <a href="http://www.codeinwp.com/" rel="nofollow" target="_blank">CodeinWP</a> - Turn your PSD file into a WordPress Theme
- <a href="http://revive.social/" rel="nofollow" target="_blank">Revive.Social</a> - WordPress plugins for Social Media marketers

Check-out the <a href="http://www.codeinwp.com/blog/intergeo-maps-plugin-review/" target="_blank" rel="nofollow">Intergeo review</a> and find out some of the <a href="http://www.codeinwp.com/blog/top-non-obvious-wordpress-plugins/" target="_blank" rel="nofollow">best WordPress plugins</a>.

== Installation ==

1. Upload the files to the `/wp-content/plugins/intergeo/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.


== Frequently Asked Questions ==

= How to override Google map settings =

To override Google map settings you can use your own hook. Just add **hook** attribute to your shortcode like this:

`[intergeo hook="my_custom_intergeo_hook" ...]...[/intergeo]`

And add a function to hook that filter:

`add_filter( 'my_custom_intergeo_hook', 'filter_intergeo_map_settings' ) {
function filter_intergeo_map_settings( $options ) {
    // update options
    $options[...] = ...;
    ...

    // return updated options
    return $options;
}`

== Changelog ==
= 2.2.3 - 2018-03-12  = 

* Improves copy maps workflow. 
* Update ThemeIsle SDK.


= 2.2.2 - 2018-01-05  = 

* Improves compatibility with latest WordPress version.
* Sync ThemeIsle SDK.


= 2.2.1 - 2017-11-13  = 

* Fix minor issue with markers.


= 2.2.0 - 2017-09-25  = 

* Improved compatibility with the pro version.
* Fixed various small bugs and ui issues.




= 2.1.2 =

* Fixed issue when editing maps and reached the limit.

= 2.0.0 =

* Major code refactor
* Improved compatibility with the pro version


= 1.1.6 =

* Removed freemius support

= 1.1.5 =

* Fixed compatibility with old version of PHP ( < 5.2 )
* Fixed issue with marker text using rich editor
* Fixed issue with https websites which were loading content over http


= 1.1.0 =

* Updated instructions for adding Google Maps Api key
* Added feedback mechanism
* Fixed conflict with Uber Menu
* Improved settings page
* Fixed issue with long and lat addresses


= 1.0.5 =

* Added information for map new installs
* Fix issue for non-admins in freemius


= 1.0.6 =

* improved the usability of the builder, markers are added now in a more intuitive way.

= 1.0.4 =

* Added uninstall feedback
* Added support for pro version

= 1.0.3 =

* Fixed issue with warning error when including some templates

= 1.0.2 =

* Fixed minZoom and maxZoom settings.

= 1.0.1 =

* Fixed compatibility with Wordpress 4.3 versions

