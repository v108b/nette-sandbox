<?php

namespace App\Presenters;

class AdminPresenter extends BasePresenter {
	
	public function createComponentUserGrid() {
		//$this['crudList'] = $this->getCrudExtenstion()->getComponents()->buildTableGrid('users');
		return $this->getContext()->getService('crud')->getComponents()->buildTableGrid('users');
	}
	
	public function renderDefault()
	{

	}
	
	

}
