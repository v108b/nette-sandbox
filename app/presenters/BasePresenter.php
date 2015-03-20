<?php

namespace App\Presenters;

use Nette,
	App\Model,
	V108B\NetteBSForms;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter implements \Nette\Security\IResource
{	
	
	/** @var \App\Model\DBContext @inject */
	public $dbContext;
	
	public function startup() {

		parent::startup();
		
		try {			
			$acl = $this->context->getByType('App\Lib\Acl');
			$acl->check($this->getResourceId(), $this->getAction());
		} catch(\AclException $e) {
			if (!$this->user->isLoggedIn() && $this->getAction(true) !== \V108B\Nette\Security\AclHelper::SIGN_IN_ACTION) {				
				$this->redirect(\V108B\Nette\Security\AclHelper::SIGN_IN_ACTION);
			} else {
				throw $e;
			}
		}
		
	}

	public function getResourceId() {
		return $this->getName().'Presenter';
	}

	protected function createComponentBsForm() {
		return new NetteBSForms\BSForm(NetteBSForms\BSForm::STYLE_PANEL);
	}
	
	public function createComponentModalWindow()
	{
		return new \V108B\NetteCrud\Components\ModalWindow();
	}
	

}


