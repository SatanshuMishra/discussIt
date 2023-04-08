<?php
use PHPUnit\Framework\TestCase;
/**
 * @runInSeparateProcess
 */
require_once 'app/public/scripts/timing-script.php';

class TimeSincePostTest extends TestCase {
  
  public function testTimeSincePost() {
    // Create a test timestamp
    $_GET['timestamp'] = time() - 86400;
    
    // Capture output from the script
    ob_start();
    include 'app/public/scripts/timing-script.php';
    $output = ob_get_clean();
    
    // Check the output
    $this->assertEquals('1 day ago', trim($output));
  }
  
}


?>

