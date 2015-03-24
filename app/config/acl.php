<?php

namespace App;

class Acl extends \V108B\Nette\Security\AclHelper{
	
	const SIGN_IN_ACTION = 'Sign:in';
	
	public function config() {		
		//$this->addRoles(['guest','user','member','admin','root']);		
		// definujeme role
		$this->acl->addRole('guest');
		$this->acl->addRole('registered', 'guest'); // registered dědí od guest
		$this->acl->addRole('member', 'registered'); 
		$this->acl->addRole('admin', 'member'); 
		$this->acl->addRole('root', 'admin'); 
		
		$this->allow(\Nette\Security\Permission::ALL, 'SignPresenter', \Nette\Security\Permission::ALL);		
		$this->allow(['registered'], 'HomepagePresenter', \Nette\Security\Permission::ALL);		
		
//		$this->allow(\Nette\Security\Permission::ALL, 'Public:HomepagePresenter', \Nette\Security\Permission::ALL);			
		
	}
	
}
