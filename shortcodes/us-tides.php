<?php 
/*

    Copyright 2012, 2013 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


/**
  * Code copied and cobbled from http://snippet.me/wordpress/wordpress-plugin-info-api/
  * having referred to http://ckon.wordpress.com/2010/07/20/undocumented-wordpress-org-plugin-api/
  * get XML information using simple xml load file
  *
  * Note There is no error checking here. It can fail for many reasons
  * but it will produce messages when it happens. 
  * The most likely causes of failure are:
  * - $tide_url is not a valid RSS feed - see bw_tideurl_namify()
  * - server is not connected to the internet 
  * - http://www.tidetimes.org.uk is not responding
  */
function us_get_tide_info( $tide_url ) {
  $request_url = urlencode( $tide_url );
  $response_xml = simplexml_load_file($request_url);
  bw_trace2( $response_xml );
  return $response_xml;
}

/**
 * Obtain tide information using the shortcode [us_tides tide_url='tide feed xml url']
 * The format of the feed is expected to be as in the following output from bw_trace
 
 
*/

function us_time_of_day_secs() {
  extract( localtime( time(), true ));
  $secs = ((($tm_hour * 60) + $tm_min) * 60) + $tm_sec;
  bw_trace( $secs, __FUNCTION__, __LINE__, __FILE__, 'secs' );
  return( $secs );
}


/* 
SimpleXMLElement Object
(
    [origin] => NOAA/NOS/CO-OPS
    [disclaimer] => Disclaimer: These data are based upon the latest information available as of the date of your request, and may differ from the published tide tables. 
    [producttype] =>  Annual Tide Prediction 
    [stationname] => Threemile Cut entrance, Darien River
    [state] => GA
    [stationid] => 8675843
    [stationtype] => Subordinate
    [referencedToStationName] => SAVANNAH RIVER ENTRANCE, FORT PULASKI
    [referencedToStationId] => 8675843
    [HeightOffsetLow] => *1.05
    [HeightOffsetHigh] => * 1.03
    [TimeOffsetLow] => 55
    [TimeOffsetHigh] => 44
    [BeginDate] => 20111231 00:00
    [EndDate] => 20121231 23:59
    [dataUnits] => feet(ft) also in centimeters(cm)
    [Timezone] => LST/LDT
    [Datum] => MLLW
    [IntervalType] => High/Low Tide Predictions
    [data] => SimpleXMLElement Object
        (
            [item] => Array
                (
                    [0] => SimpleXMLElement Object
                        (
                            [date] => 2011/12/31
                            [day] => Sat
                            [time] => 01:16 AM
                            [predictions_in_ft] => 6.6
                            [predictions_in_cm] => 201
                            [highlow] => H
                        )

                    [1] => SimpleXMLElement Object
                        (
                            [date] => 2011/12/31
                            [day] => Sat
                            [time] => 07:36 AM
                            [predictions_in_ft] => 1.1
                            [predictions_in_cm] => 34
                            [highlow] => L
                        )

                    [2] => SimpleXMLElement Object
                        (
                            [date] => 2011/12/31
                            [day] => Sat
                            [time] => 01:43 PM
                            [predictions_in_ft] => 6.3
                            [predictions_in_cm] => 192
                            [highlow] => H
                        )

                    [3] => SimpleXMLElement Object
                        (
                            [date] => 2011/12/31
                            [day] => Sat
                            [time] => 08:03 PM
                            [predictions_in_ft] => 0.7
                            [predictions_in_cm] => 21
                            [highlow] => L
                        )
  


function us_get_todays_date( $response ) {

}

/**
 * Form an URL for the given location assuming UK based
 * @param string $station - the station ID
 * @return string URL to use to load the XML file
 
 * 8675843 is Threemile Cut Entrance, Darien River, GA
 * 8423745 is Portsmouth, New Hampshire
 * @link http://tidesandcurrents.noaa.gov/noaatidepredictions/NOAATidesFacade.jsp?Stationid=8423745&datatype=Annual%20XML
 */
function us_tideurl_namify( $station) {
  $newurl = "http://tidesandcurrents.noaa.gov/noaatidepredictions/NOAATidesFacade.jsp?datatype=Annual XML&Stationid=" . $station ;
  return $newurl;
}

function us_load_xml_file( $station="8423745" ) {  
  $file = oik_path( "xml/$station.xml", "us-tides" );
  $load_file = file_exists( $file ); 
  if ( $load_file ) {
    $response = simplexml_load_file( $file );
    // Need to check the year 
    $today = bw_format_date( null, "Ymd h:i" );
      bw_trace2( $response->EndDate, "EndDate" );
      bw_trace2( $today, "TODAY" );
    if ( $response->EndDate <= $today ) {
      $load_file = false;
    }  
    
  } 
  if ( !$load_file ) {
    $tideurl = us_tideurl_namify( $station ); 
    $response = us_get_tide_info( $tideurl );
    if ( $response ) {
    
      //p( $response->EndDate . "from new file" ); 
      $bytes = $response->asXml( $file );
      bw_trace2( $bytes, "$file written", false );
      // p( $bytes );
    }    
  }
  return( $response );  
}  



/**
 * Display information about high and low tides obtained from the NOAA Tides and Currents website
 * 
 * @param array $atts- shortcode parameters
 * @return string Result of shortcode
 * @link http://tidesandcurrents.noaa.gov/noaatidepredictions
 *
 * e.g.
 *   Threemile Cut entrance, Darien River GA
 *   May 18,2012
 *   02:10 AM 0.7 Low Tide
 *   07:50 AM 6.6 High Tide
 *   02:11 PM 0.2 Low Tide
 *   08:07 PM 7.8 High Tide
 * 
 * 
 */                                                                        
function us_tides( $atts=NULL ) {
  $station = bw_array_get( $atts, "station", "8423745" );
  $link = bw_array_get( $atts, "link", "y" );
  $link = bw_validate_torf( $link );
  $date_format = bw_array_get( $atts, "date_format", "M d,Y" );
  $response = us_load_xml_file( $station );
  if ( $response ) {
    $stationname = $response->stationname;   
    $state = $response->state;
    $text = "Tide times and heights for:";
    $text .= "&nbsp;";
    $text .= $stationname;
    $text .= "&nbsp;";
    $text .= $state;
    if ( $link ) { 
      alink( "stationname", "http://tidesandcurrents.noaa.gov/noaatidepredictions/NOAATidesFacade.jsp?Stationid=$station", $text );  
    } else {   
     p( $text, "stationname" );
    }
    p( bw_format_date( null, $date_format ) );
    $today = bw_format_date( null, "Y/m/d" );
    foreach ( $response->data->item as $item ) {
      if ( $item->date == $today ) {
        sp( "item" );
        sepan( "time" , $item->time );
        e( "&nbsp;" );
        sepan( "ft", $item->predictions_in_ft );
        e( "&nbsp;" );
        if ( $item->highlow == 'L' ) {
          sepan( "highlow low", "Low Tide" );
        } else {
          sepan( "highlow high", "High Tide" );
        }    
        ep();
      }  
    }
  }
  return( bw_ret());
}

function us_tides__help( $shortcode='us_tides' ) {
  return( "Display tide times and heights for a US location" );    
}

function us_tides__syntax( $shortcode='us_tides' ) {
  $syntax = array( "station" => bw_skv( "8423745", "<i>StationId</i>", "StationId for tide information" )
                 , "link" => bw_skv( "y", "n", "Include a link to Tides and Currents website")
                 , "date_format" => bw_skv( "M d,Y", "date format", "PHP date format" )
                 );
  return( $syntax );
}           

function us_tides__example( $shortcode='us_tides' ) {    
  $text = "To display tide times and heights for Portsmouth, NH (Station ID: 8423745)" ;
  $example = 'station=8423745';
  bw_invoke_shortcode( $shortcode, $example, $text );
  p( "The information displayed comes from the NOAA Tides and Currents website." );

}
