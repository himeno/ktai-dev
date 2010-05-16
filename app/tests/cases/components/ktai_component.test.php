<?php
/**
 * Ktai library, supports Japanese mobile phone sites coding.
 * It provides many functions such as a carrier check to use Referer or E-mail, 
 * conversion of an Emoji, and more.
 *
 * PHP versions 4 and 5
 *
 * Ktai Library for CakePHP1.2
 * Copyright 2009-2010, ECWorks.
 
 * Licensed under The GNU General Public Licence
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright		Copyright 2009-2010, ECWorks.
 * @link			http://www.ecworks.jp/ ECWorks.
 * @version			0.3.1
 * @lastmodified	$Date: 2010-05-17 02:00:00 +0900 (Mon, 17 May 2010) $
 * @license			http://www.gnu.org/licenses/gpl.html The GNU General Public Licence
 */

App::import('Vendor', 'ecw/Lib3gkCarrier');
App::import('Controller', 'KtaiTests');

App::import('Component', 'Ktai');

class KtaiComponentTest extends CakeTestCase {
	var $controller = null;
	var $view       = null;
	var $ktai       = null;
	
	var $security_level = 'high';
	
	function start(){
		
		$carrier = Lib3gkCarrier::get_instance();
		$carrier->_carrier = KTAI_CARRIER_DOCOMO;
		
		Router::reload();
		$this->controller = new KtaiTestsController();
		$this->controller->constructClasses();
		
		Configure::write('Security.level', $this->security_level);
		
		$this->controller->Component->initialize($this->controller);
		$this->controller->Component->startup($this->controller);
		
		$this->ktai = &$this->controller->Ktai;
	}
	
	function stop(){
		unset($this->view);
		unset($this->controller);
		ClassRegistry::flush();
	}
	
	function testInitialize(){
		
		$security_level = Configure::read('Security.level');
		$this->assertEqual($security_level, 'medium');
		
		$this->assertEqual($this->ktai->_options['use_img_emoji'], $this->controller->ktai['use_img_emoji']);
		$this->controller->ktai['use_img_emoji'] = false;
		$this->assertEqual($this->ktai->_options['use_img_emoji'], $this->controller->ktai['use_img_emoji']);
		$this->assertEqual($this->ktai->_options['img_emoji_url'], "/img/emoticons/");
	}
	
}
