<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	public function createComponentUserGrid() {
		//$this['crudList'] = $this->getCrudExtenstion()->getComponents()->buildTableGrid('users');
		return $this->getContext()->getService('crud')->getComponents()->buildTableGrid('users');
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';		
		
		\Tracy\Debugger::barDump($this->user->roles);
		\Tracy\Debugger::barDump($this->user->getRoles());
	}

}
