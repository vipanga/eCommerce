<?php

// src/ecommerce/UserBundle/ecommerceUserBundle.php

namespace ecommerce\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ecommerceUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }

}
