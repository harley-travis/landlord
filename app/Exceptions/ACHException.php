<?php

namespace App\Exceptions;

use Exception;

class ACHException extends Exception {
    
    public function report() {
        // add email here to send message
    }

    public function render() {
        
    }

}
