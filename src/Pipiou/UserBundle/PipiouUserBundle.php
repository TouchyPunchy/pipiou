<?php

namespace Pipiou\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PipiouUserBundle extends Bundle
{
	public function getParent(){
		return 'FOSUserBundle';
	}
}
