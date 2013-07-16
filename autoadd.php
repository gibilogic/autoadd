<?php defined('_JEXEC') or die( 'The way is shut!' );
/*
 * @version       $Id: autoadd.php 2013-01-07 14:32:00Z zanardi $
 * @package       GiBi VMautoAdd
 * @author        GiBiLogic
 * @authorUrl     http://www.gibilogic.com
 * @authorEmail   info@gibilogic.com
 * @copyright     Copyright (C) 2012-2013 GiBiLogic snc - All rights reserved.
 * @license       GNU/GPL v2 or later
 */

if (!class_exists ('vmPSPlugin'))	require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');

class plgVmShipmentAutoadd extends vmPSPlugin 
{
	function __construct (& $subject, $config) 
  {
    parent::__construct ($subject, $config);
    $this->product_to_add = $this->params->get('product_id',0);    
	}
  
	public function plgVmOnCheckoutAdvertise( $cart, &$checkoutAdvertise ) 
  {
    if( isset( $cart->products[ $this->product_to_add ] ) ) {
      return true;
    } else {
      $this->_addProductToCart();
    }
	}
  
  private function _addProductToCart()
  {
    $session =& JFactory::getSession();
    if( $session->get( 'VMautoadded' ) ) return true; // check so that this product gets added only once per session
    
    JRequest::setVar('quantity', array('1') );
    $cart = VirtueMartCart::getCart();
    $cart->add( array( $this->product_to_add ) );
    
    $session->set( 'VMautoadded', true ); // set the session so that this product gets added only once per session
        
  }
}
