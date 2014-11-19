<?php

namespace WCM\AstroFields\Examples\UserMeta;

/**
 * Plugin Name: (WCM) AstroFields UserMeta Example
 * Description: UserMeta example plugin
 */

// Composer autoloader
if ( file_exists( __DIR__."/vendor/autoload.php" ) )
	require_once __DIR__."/vendor/autoload.php";


use WCM\AstroFields\Core\Mediators\Entity;
use WCM\AstroFields\Core\Commands\ViewCmd;

use WCM\AstroFields\UserMeta\Receivers\UserMetaValue;
use WCM\AstroFields\UserMeta\Templates\InputFieldTmpl;
use WCM\AstroFields\UserMeta\Commands\DeleteMeta;
use WCM\AstroFields\UserMeta\Commands\SaveMeta;

use WCM\AstroFields\Security\Commands\SanitizeString;

### USER META
add_action( 'wp_loaded', function()
{
	if ( ! is_admin() )
		return;

	// Commands
	$input_view = new ViewCmd;
	$input_view
		->setContext( '{proxy}_user_profile' )
		->setProvider( new UserMetaValue )
		->setTemplate( new InputFieldTmpl );

	// Entity: Field
	$input_field = new Entity( 'wcm_input_user' );
	// Attach Commands
	$input_field
		->setProxy( array( 'edit', 'show' ) )
		->attach(
		$input_view,
			array(
				'attributes' => array(
					'class' => 'regular-text',
				),
			)
		)
		->attach( new DeleteMeta )
		->attach( new SaveMeta )
		->attach( new SanitizeString );
} );