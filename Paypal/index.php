<?php

require 'Paypal_IPN.php';
$paypal = new Paypal_IPN('live');
$paypal->run();