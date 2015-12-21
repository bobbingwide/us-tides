=== us-tides ===
Contributors: bobbingwide
Donate link: http://www.oik-plugins.com/oik/oik-donate/
Tags: shortcode, tides, US, heights and times, [us_tides]
Requires: 3.0.4
Tested up to: 3.5
Stable tag: 0.2.0120

Tide heights and times for US tidal stations

== Description ==
us-tides displays saltwater tide times and heights for a particular location in the US. 
The information that is displayed is obtained from the [NOAA Tides and Currents](http://tidesandcurrents.noaa.gov) website
You find the station id for your nearest station and use this in the [us_tides] shortcode.

So for, Threemile Cut entrance, Darien River, GA the StationId is 8675843

`[us_tides station=8675843]`

The shortcode will display the tide times and heights for the current date.

[us_tides] with no parameters will display the tide times and heights for Portsmouth, New Hampshire (station id: 8423745 )
 

== Installation ==
1. Upload the contents of the us-tides plugin to the `/wp-content/plugins/us-tides' directory
1. Activate the us-tides plugin through the 'Plugins' menu in WordPress
1. Whenever you want to produce some 'us-tides'ed text use the [us-tides] shortcode.

Note: us-tides is dependent upon the oik plugin. You can activate it but it will not work unless oik is also activated.
Download oik from 
[oik download](http://wordpress.org/extend/plugins/oik/0

== Frequently Asked Questions ==
= What is the shortcode syntax? =
`[us_tides
station="8423745|StationId - StationId for tide information"
link="y|n - Include a link to Tides and Currents website"
date_format="M d,Y|date format - PHP date format"]`

= How do I find the value for station? =
Visit the [NOAA Tides and Currents website](http://tidesandcurrents.noaa.gov/tide_predictions.shtml) and drill down.

= What is the default station? =
The default is for Portsmouth, New Hampshire... because the author comes from Portsmouth, Hampshire, UK

= What if I don't live in the US? =
If you live in the UK then you can use the [uk-tides WordPress plugin](http://wordpress.org/extend/plugins/uk-tides/) 
If you can point us to a resource for other locations then it should be possible to develop a very similar solution.

= How does it work? =

1. The plugin will look for an XML file with the station id in the name
2. If not present, or it's out of date it downloads a new Annual XML file
3. It loads the XML file and finds the matching records - high and low times and heights

= How big is each XML file? =
Between 250 and 300K

= Can I use the shortcode more than once in a page? =
Yes. Just use a different station ID parameter.

= Can I theme the output? =
Yes. Each field is wrapped in XHTML tags

== Screenshots ==
1. sample output for Portsmouth, New Hampshire

== Upgrade Notice ==
= 0.2.0120 = 
* Dependent upon oik v1.17

= 0.2 =
* Initial version. Requires oik v1.13 or higher

== Changelog ==
= 0.2.0120 =
* Changed: Includes default XML file for Portsmouth, NH for 2013
* Added: Dependency logic on oik

= 0.2 =
* initial version. Works with oik version 1.13


== Further reading ==
If you want to read more about the oik plugins then please visit the
[oik plugin](http://www.oik-plugins.com/oik) 
**"the oik plugin - for often included key-information"**






