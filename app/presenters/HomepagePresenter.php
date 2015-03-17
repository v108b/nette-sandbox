<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';		
		
		\Tracy\Debugger::barDump($this->user->roles);
		\Tracy\Debugger::barDump($this->user->getRoles());
	}

}
