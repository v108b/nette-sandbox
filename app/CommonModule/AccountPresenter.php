<?php

namespace App\CommonModule;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class AccountPresenter extends \App\CommonModule\BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
