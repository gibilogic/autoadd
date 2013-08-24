<?php defined('_JEXEC') or die( 'The way is shut!' );
/*
 * @version       autoadd.php 2013-08-24 15:25:00Z zanardi
 * @package       GiBi VMautoAdd
 * @author        GiBiLogic <info@gibilogic.com>
 * @authorUrl     https://extensions.gibilogic.com
 * @copyright     Copyright (C) 2012-2013 GiBiLogic snc - All rights reserved.
 * @license       GNU/GPL v2 or later
 */

if (!class_exists ('vmPSPlugin'))	require(JPATH_VM_PLUGINS.'/vmpsplugin.php');

class plgVmShipmentAutoadd extends vmPSPlugin 
{
  /**
   * plgVmOnCheckoutAdvertise event handler
   * Checks that the product to add is not already present in the cart
   * 
   * @param VmCart $cart
   * @param $checkoutAdvertise
   * @return bool true
   */
	public function plgVmOnCheckoutAdvertise($cart, &$checkoutAdvertise) 
  {
    if (!isset($cart->products[$this->params->get('product_id',0)])) 
    {
      $this->addProductToCart();
    }
    return true;
	}
  
  /**
   * Add product to cart
   * 
   * @return void
   */
  private function addProductToCart()
  {
    $session = JFactory::getSession();
    if (!$this->params->get('force_add',0) && $session->get('VMautoadded')) return true; // check so that this product gets added only once per session if "force_add" is not set
    
    JRequest::setVar('quantity', array('1') );
    $cart = VirtueMartCart::getCart();
    $cart->add(array($this->params->get('product_id',0)));
    
    $session->set('VMautoadded', true); // set the session so that this product gets added only once per session
  }
}
