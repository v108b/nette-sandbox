<?php

namespace App\Lib;

class Acl extends \V108B\Nette\Security\AclHelper{
	
	public function config() {		
		$this->addRoles(['guest','user','member','admin','root']);		
		
		$this->allow(\Nette\Security\Permission::ALL, 'SignPresenter', \Nette\Security\Permission::ALL);		
		$this->allow('user', 'HomepagePresenter', \Nette\Security\Permission::ALL);		
	}
	
}
