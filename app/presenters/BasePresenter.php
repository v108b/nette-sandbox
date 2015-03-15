<?php

namespace App\Presenters;

use Nette,
	App\Model,
	V108B\NetteBSForms;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var \App\Model\DBContext @inject */
	public $dbContext;
	
	protected function createComponentBsForm() {
		return new NetteBSForms\BSForm(NetteBSForms\BSForm::STYLE_PANEL);
	}
}


