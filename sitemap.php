<?php
/*
Clickable Sitemap generator v1
Author: Paul Charpie
Description:  This generates a sitemap when provided with an svg and darkens unrentable units while rentable units can be clicked to go to the 
relevant rental page.
How To Setup:
To use this, generate a sitemap with a path for each rental site. The paths should have no stroke or fill set, and they should have the id of
"path<unit code>."  The unit codes are done by lot number, so the id for lot 72 would be "path72". Give the svg the following style attribute:
style="background-image: url(path to the actual image of the sitemap); background-size: contain;"
then upload it into the plugins/RM4/pages directory with the name sitemap_image.svg. That's it!
Future versions: Add ability to display popups on hover or on click
*/
function generate_sitemap() {
    require_once RM4_PLUGIN_PATH . 'rm4_service.php';
	$RM4 = new RM4Service();
	$unitList = $RM4->UnitSearch([]);
	$units = [];
	$unitLinks = [];
	
	foreach ($unitList as $key => $unit) {
		$units[$unit->Code] = ['Name' => $unit->Name, 'Description' => $unit->Description, 'Id' => $unit->Id, 'Code' => $unit->Code, 'Thumbnail' => $unit->Thumbnail];
		$posts = get_posts(array('post_type'=>'rental','meta_key'=>'rm4_id','meta_value'=>$unit->Id));

	    if (empty($posts)) {
	        $posts = rm4_add_update_cabin($unit);
	    }

		$unitLinks[$unit->Code] = get_permalink($posts[0]);
	}
        
    ob_start();
    echo file_get_contents(RM4_PLUGIN_PATH . 'pages' . DIRECTORY_SEPARATOR . 'sitemap_image.svg');
    $svg_file = ob_get_clean();

    ob_start();
    require RM4_PLUGIN_PATH . 'pages' . DIRECTORY_SEPARATOR . 'sitemap_page.php';
    return ob_get_clean();
}

add_shortcode( 'sitemap', 'generate_sitemap' );