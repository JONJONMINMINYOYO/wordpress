<?php
use PHPUnit\Framework\TestCase;  
require_once 'C:\Program Files\Ampps\www\wordpress\wp-load.php';
require_once 'C:\Program Files\Ampps\www\wordpress\vendor\johnpbloch\wordpress-core\wp-includes\taxonomy.php';
class Test123 extends TestCase
{
      function testRegisterTaxonomy(){

      //$tax = rand_str();
   
      $tax = array(2,2);
      $this->assertFalse(taxonomy_exists($tax));
    
      register_taxonomy($tax, 'post');
    
      $this->assertTrue(taxonomy_exists($tax));
      $this->assertFalse(is_taxonomy_hierarchical($tax));
    
      unset($GLOBALS['wp_taxonomies'][$tax]);
    }
  
      
     
}
