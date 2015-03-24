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
			$acl = $this->context->getByType('App\Acl');
			$acl->check($this->getResourceId(), $this->getAction());
		} catch(\AclException $e) {
			if (!$this->user->isLoggedIn() && $this->getAction(true) !== \App\Acl::SIGN_IN_ACTION) {				
				$this->redirect(\App\Acl::SIGN_IN_ACTION);
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


