<?php

namespace kail520\wx\mp\message;

use kail520\wx\core\Driver;

class Transfer extends Driver {

    public $type = 'transfer_customer_service';
    public $props = [];
}