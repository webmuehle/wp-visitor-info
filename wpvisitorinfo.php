<?php
/*
Plugin Name: Wordpress Visitor Info
Plugin URI: https://www.wpvisitor.info
Description: Access & Show Site Visitor Information With Short Codes
Version: 1.0.1
Author: Webmühle e.U
Author URI: https://www.webmuehle.at
License: GPL2
*/
/*  Copyright 2021 Webmühle e.U  (email : office@webmuehle.at)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Integration Freemius SKD
if ( ! function_exists( 'wpv_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wpv_fs() {
        global $wpv_fs;

        if ( ! isset( $wpv_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $wpv_fs = fs_dynamic_init( array(
                'id'                  => '8852',
                'slug'                => 'wpvisitorinfo',
                'premium_slug'        => 'wpv-premium',
                'type'                => 'plugin',
                'public_key'          => 'pk_4ed8051b6979f481350dc645e56bb',
                'is_premium'          => true,
                'premium_suffix'      => 'Premium',
                // If your plugin is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'first-path'     => 'plugins.php',
                    'support'        => false,
                ),
                // Set the SDK to work in a sandbox mode (for development & testing).
                // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                'secret_key'          => 'sk_tnJ#64SKv:%k-pz^(kemjpL9dY*+A',
            ) );
        }

        return $wpv_fs;
    }

    // Init Freemius.
    wpv_fs();
    // Signal that SDK was initiated.
    do_action( 'wpv_fs_loaded' );
}
global $wpdb;

wp_enqueue_script('checkout-script', plugin_dir_url( __FILE__ ).'js/checkout.min.js', array('jquery'), null, false);

add_action('admin_menu', 'wpvisitorinfopro_top_menu');

function wpvisitorinfopro_top_menu() {
add_menu_page('WPVisitorInfo', 'WPVisitorInfo', 'read', 'wpvisitorinfopro_slug', 'wpvisitorinfopro_mainpage');
}

function wpvisitorinfopro_mainpage() {
global $wpdb;
?>


<?php

?>

    <?php if (!wpv_fs()->can_use_premium_code()) { ?>

  	<div class="notice notice-success is-dismissible"> 
	    <p><strong>
	    <?php
	    $s_upgrade = 'Thx a lot for using WordPress Visitor Info. Do you know our Premium-Plan? With <a href="%s">WordPress Visitor Info Premium</a> you can get even more Shortscodes and Queries for your Shortcodes!';
	    $url = admin_url('admin.php?page=wpvisitorinfopro_slug&tab=1');
	    $link = sprintf( wp_kses( __( $s_upgrade, 'wpvisitorinfopro_slug' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) ); 
	    echo $link;
	    ?>
	    </strong></p>
	    <button type="button" class="notice-dismiss">
	      <span class="screen-reader-text"><?php echo __( 'Dismiss this notice.', 'wpvisitorinfopro_slug' ); ?></span>
	    </button>
	 </div>

    <?php } ?>

    <div class="wrap">
		<h1 class="wp-heading-inline">WordPress Visitor Info</h1>
		<hr class="wp-header-end">

		<div class="cr-tabs-wrap">
			<div class="item1">
				<div class="cr-widget-right">
				     <?php if (!wpv_fs()->can_use_premium_code()) { ?>

					    <div class="cr-widget-head nav-tab-wrapper">
					        <span class="nav-tab">Upgrade to WordPress Visitor Info Premium</span>
					    </div>
					    <div class="cr-widget-item">+ MORE SHORTCODES</div>
					    <div class="cr-widget-item">+ QUERIES IN SHORTCODES</div>
					    <div class="cr-widget-item">+ 24/7 E-MAIL-SUPPORT</div>
					    <div class="cr-widget-item">
					        <button id="purchase-visitorinfo" class="button">Upgrade to Premium</button>
					    </div>

					<script>
					    var handler = FS.Checkout.configure({
					        plugin_id:  '8852',
					        plan_id:    '14852',
					        public_key: 'pk_4ed8051b6979f481350dc645e56bb',
					        image:      'https://your-plugin-site.com/logo-100x100.png'
					    });


					    jQuery('#purchase-visitorinfo').on('click', function (e) {
					        handler.open({
					            name     : 'Wordpress Visitor Info',
					            licenses : 1,
					            // You can consume the response for after purchase logic.
					            purchaseCompleted  : function (response) {
					                // The logic here will be executed immediately after the purchase confirmation.                                // alert(response.user.email);
					            },
					            success  : function (response) {
					                // The logic here will be executed after the customer closes the checkout, after a successful purchase.                                // alert(response.user.email);
					            }
					        });

					        e.preventDefault();
					    });
					</script>

				     <?php } ?>
				</div>
			</div>


<?php if (!wpv_fs()->can_use_premium_code()) { ?>

            <div  class="item2">
                <h2 class="nav-tab-wrapper wp-clearfix">
		    <a href="<?php admin_url(); ?>admin.php?page=wpvisitorinfopro_slug&tab=0" class="nav-tab<?php if (!isset($_GET['tab']) || $_GET['tab']!="1") { echo " nav-tab-active"; } ?>">
			Settings
                    </a>
		    <a href="<?php admin_url(); ?>admin.php?page=wpvisitorinfopro_slug&tab=1" class="nav-tab<?php if (isset($_GET['tab']) && $_GET['tab']=="1") { echo " nav-tab-active"; } ?>">
			Upgrade
                    </a>
                </h2>

<?php } ?>


<?php if (!isset($_GET['tab']) || $_GET['tab']!="1")
{ ?>

<div align="center">
<p align="center"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>/slogo.PNG"></p>
<h2 align="center">Wordpress (WP) Visitor Info Plugin</h2>
<br><br><b>Thank you for installing this plugin</b>, use the below short codes to show site visitor info on page anwyhere on your site.
<br><br>
<strong>[wpvinfo_city]</strong>: Use this short code to show city name<br><br>
<strong>[wpvinfo_state]</strong>: Use this short code to show state name<br><br>
<strong>[wpvinfo_statecode]</strong>: Use this short code to show state code<br><br>
<strong>[wpvinfo_country]</strong>: Use this short code to show country name<br><br>
<strong>[wpvinfo_countrycode]</strong>: Use this short code to show country code (ISO 2 digit)<br><br>
<strong>[wpvinfo_currencycode]</strong>: Use this short code to show currency code<br><br>
<strong>[wpvinfo_currencysymbol]</strong>: Use this short code to show currency symbol<br><br>
<strong>[wpvinfo_ineu]</strong>: Use this short code to yes or no depending upon whether the site visitor is in euro zone or not<br><br>
<strong>[wpvinfo_timezone]</strong>: Use this short code to show site visitor timezone<br><br>
<br><br>
<strong>[wpvinfo_city=Los Angeles]Showing Only For LA City[/wpvinfo_city]</strong>:
<br>Use the above short tag to show text between tags only for specific cities else it disappears. The above shows "Showing Only For LA City" only when the visitor is from Los Angeles.<br><br>

<strong>[wpvinfo_state=Arizona]Showing Only For AZ State[/wpvinfo_state]</strong>: 
<br>Use the above short tag to show text between tags only for specific states else it disappears. The above shows "Showing Only For AZ State" only when the visitor is from Arizona state.<br><br>

<strong>[wpvinfo_statecode=AZ]Showing Only For AZ State[/wpvinfo_statecode]</strong>: 
<br>Use the above short tag to show text between tags only for specific states else it disappears. The above shows "Showing Only For AZ State" only when the visitor is from Arizona state.<br><br>

<strong>[wpvinfo_country=United States]Showing Only For US Country[/wpvinfo_country]</strong>: 
<br>Use the above short tag to show text between tags only for specific countries else it disappears. The above shows "Showing Only For US Country" only when the visitor is from United States.<br><br>

<strong>[wpvinfo_countrycode=US]Showing Only For AZ State[/wpvinfo_countrycode]</strong>: 
<br>Use the above short tag to show text between tags only for specific countries else it disappears. The above shows "Showing Only For US Country" only when the visitor is from United States.<br><br>

<strong>[wpvinfo_currencycode=USD]Your Currency Is USD[/wpvinfo_currencycode]</strong>:
<br>Use the above short tag to show text between tags only for specific currencies else it disappears. The above shows "Your Currency Is USD" only when the visitor country currency is USD.<br><br>

<strong>[wpvinfo_currencysymbol=£]Your Currency Sybmol Is £[/wpvinfo_currencysymbol]</strong>: 
<br>Use the above short tag to show text between tags only for specific currency symbols else it disappears. The above shows "Your Currency Symbol Is £" only when the visitor country currency symbol is £<br><br>
<br><br>
For any help, email office@webmuehle.at<br>
</div>
<?php
}
else
{ ?>

                <div id="packages" style="width: 100%;">
                    <ul>
                        <li class="plan free-pricing">
                            <article class="card current">
                                <header>
                                    <h2>Lite</h2>
                                    <h3>Basic Features</h3>
                                </header>
                                <div class="body">
                                    <div class="offer">
                                        <span class="price"><var>Free</var></span>
                                        <span class="renewals-amount" style="display: none;"></span>
                                        <span class="period">Billed Annually</span>
                                        <div class="tooltip-wrapper info-icon">
                                            <span class="license" title="If you are running a multi-site network, each site in the network requires a license.">
						SINGLE SITE
                                            </span>
                                        </div>
                                    </div>
                                    <div class="support">
                                        <span><var>No support</var></span>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li class="plan premium">
                            <article class="card featured">
                                <header>
                                    <h2>PREMIUM</h2>
                                    <h3>
					MORE SHORTCODES
				    </h3>

                                    <h3>
					QUERIES IN SHORTCODES
				    </h3>

                                    <h3>
					24/7 E-MAIL-SUPPORT
				    </h3>

                                    <h3>
					$35,99 /YEAR
				    </h3>

                                    <h3>
					BILLED ANNUALY
				    </h3>

                                    <h3>
					SINGLE SITE
				    </h3>
                                </header>
                                <div class="body">
                                    <div class="offer">
                                        <span class="price">
                                            <span>
                                                <b class="currency">$</b><var>35</var>
                                            </span>
                                            <span>
                                                <b class="price-decimal">99</b>
                                                <sub class="billing-cycle">/ YEAR</sub>
                                            </span>
                                        </span>
                                        <span class="period">
						BILLED ANNUALY
					</span>
                                        <div class="tooltip-wrapper info-icon">
                                            <span class="license" title="If you are running a multi-site network, each site in the network requires a license.">
						 SINGLE SITE 
					   </span
                                        ></div>
                                    </div>
                                    <div class="support">
                                        <span><var>Priority E-Mail & Help Center Support</var></span>
                                    </div>
                                </div>
                            </article>
                        </li>
                    </ul>


                </div>

		</div>

	</div>
<?php
}
}

function wpvisitorinfopro_in_content($content) {
global $wpdb;

// require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
// require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

// $wpvinfodata_raw_=WP_Filesystem_Direct::get_contents("http://www.geoplugin.net/json.gp?ip=".$_SERVER['REMOTE_ADDR']);


global $wp_filesystem;
WP_Filesystem();

$wpvinfodata_raw_=$wp_filesystem->get_contents ("http://www.geoplugin.net/json.gp?ip=".$_SERVER['REMOTE_ADDR']);
$wpvinfodata_raw=@json_decode($wpvinfodata_raw_);


if ( wpv_fs()->can_use_premium_code() ) { $wpvinfo_city=$wpvinfodata_raw->geoplugin_city; } else { $wpvinfo_city="(for premium users only)"; }
if ( wpv_fs()->can_use_premium_code() ) { $wpvinfo_state=$wpvinfodata_raw->geoplugin_region; } else { $wpvinfo_state="(for premium users only)"; }
if ( wpv_fs()->can_use_premium_code() ) { $wpvinfo_statecode=$wpvinfodata_raw->geoplugin_regionCode; } else { $wpvinfo_statecode="(for premium users only)"; }
$wpvinfo_country=$wpvinfodata_raw->geoplugin_countryName;
$wpvinfo_countrycode=$wpvinfodata_raw->geoplugin_countryCode;
$wpvinfo_currencycode=$wpvinfodata_raw->geoplugin_currencyCode;
$wpvinfo_currencysymbol=$wpvinfodata_raw->geoplugin_currencySymbol;
$wpvinfo_ineu_raw=$wpvinfodata_raw->geoplugin_inEU;
if($wpvinfo_ineu_raw==0)
$wpvinfo_ineu = "no";
else
$wpvinfo_ineu = "yes";
if ( wpv_fs()->can_use_premium_code() ) { $wpvinfo_timezone=$wpvinfodata_raw->geoplugin_timezone; } else { $wpvinfo_timezone="(for premium users only)"; }


//tags logic starts
if (!function_exists('wpvisitorinfo_get_string_between'))   {
function wpvisitorinfo_get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
}

//for city
$wpvinfotag1 = substr_count($content,"[wpvinfo_city=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_city=';
$popcheckend = '[/wpvinfo_city]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_city;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for state
$wpvinfotag1 = substr_count($content,"[wpvinfo_state=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_state=';
$popcheckend = '[/wpvinfo_state]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_state;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for state code
$wpvinfotag1 = substr_count($content,"[wpvinfo_statecode=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_statecode=';
$popcheckend = '[/wpvinfo_statecode]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_statecode;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;


if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}

//for country
$wpvinfotag1 = substr_count($content,"[wpvinfo_country=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_country=';
$popcheckend = '[/wpvinfo_country]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_country;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;


if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for country code
$wpvinfotag1 = substr_count($content,"[wpvinfo_countrycode=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_countrycode=';
$popcheckend = '[/wpvinfo_countrycode]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_countrycode;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for currency code
$wpvinfotag1 = substr_count($content,"[wpvinfo_currencycode=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_currencycode=';
$popcheckend = '[/wpvinfo_currencycode]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_currencycode;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for currency symbol
$wpvinfotag1 = substr_count($content,"[wpvinfo_currencysymbol=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_currencysymbol=';
$popcheckend = '[/wpvinfo_currencysymbol]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_currencysymbol;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for in eurozone
$wpvinfotag1 = substr_count($content,"[wpvinfo_ineu=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_ineu=';
$popcheckend = '[/wpvinfo_ineu]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_ineu;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}


//for timezone
$wpvinfotag1 = substr_count($content,"[wpvinfo_timezone=");
$i = $wpvinfotag1 + 1;
$i2 = 1;
while($i2<$i)
{
$popcheckstart = '[wpvinfo_timezone=';
$popcheckend = '[/wpvinfo_timezone]';

$fullstring = $content;
$parsed = wpvisitorinfo_get_string_between($fullstring, $popcheckstart, $popcheckend);

$wpvivalpos = strpos($parsed,"]");
$wpvival = substr($parsed,0,$wpvivalpos);
$wpvidata = substr($parsed,$wpvivalpos+1);
$wpvidataval = $wpvinfo_timezone;
$toreplaceval = $popcheckstart.$parsed.$popcheckend;

if ( wpv_fs()->can_use_premium_code() ) {
if($wpvival==$wpvidataval)
$content = str_replace($toreplaceval,$wpvidata,$content); 
else
$content = str_replace($toreplaceval,"",$content); 
}
else
{
$content = str_replace($toreplaceval,"(for premium users only)",$content); 
}

$i2 = $i2 + 1;
}

//tags logic ends

$content = str_replace('[wpvinfo_city]',$wpvinfo_city,$content);
$content = str_replace('[wpvinfo_state]',$wpvinfo_state,$content);
$content = str_replace('[wpvinfo_statecode]',$wpvinfo_statecode,$content);
$content = str_replace('[wpvinfo_country]',$wpvinfo_country,$content);
$content = str_replace('[wpvinfo_countrycode]',$wpvinfo_countrycode,$content);
$content = str_replace('[wpvinfo_currencycode]',$wpvinfo_currencycode,$content);
$content = str_replace('[wpvinfo_currencysymbol]',$wpvinfo_currencysymbol,$content);
$content = str_replace('[wpvinfo_ineu]',$wpvinfo_ineu,$content);
$content = str_replace('[wpvinfo_timezone]',$wpvinfo_timezone,$content);

return($content);

}

add_filter('the_content', 'wpvisitorinfopro_in_content');
?>
