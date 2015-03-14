<?php

namespace App\Presenters;

use Nette\Application\UI\Form,
		V108B\NetteBSForms;

class RegistrationPresenter extends BasePresenter
{

	protected function createComponentForm()
	{
		$bsform = new NetteBSForms\BSForm('Registration form');
		$form = $bsform['form'];
		$form->addGroup('');

		//$em = $this->em;
		$form->addText('username', 'Username')
			->setRequired('Username is required');
		/*
			->addCondition(Form::FILLED)
				->addRule(function($control) use($em) {
					$value = $control->value;
					return $em->getRepository('User')->findOneByUsername($value) === NULL;
				}, 'This username is already taken');
		 * 
		 */

		$password1 = $form->addPassword('password', 'Password')
			->setRequired('Fill in the password');
		$password2 = $form->addPassword('password2', 'Password (verify)')
			->addConditionOn($password1, Form::FILLED)
			->addRule(Form::FILLED, 'Fill in the password again');

		$password2->addCondition(Form::FILLED)
			->addRule(Form::EQUAL, 'Passwords do not match', $password1);

		$form->addText('captcha', 'Who you gonna call!?')
			->setRequired('Answer to the security question is required')
			->addRule(Form::EQUAL, 'Bad answer', 'ghostbusters');

		$form->addSubmit('submit', 'Register me!');
		$form->onSuccess[] = array($this, 'submitForm');
		return $bsform;
	}

	public function submitForm(Form $form, $values)
	{			
		$this->dbContext->userManager->add($values['username'], $values['password']);
		$this->flashMessage('You were successfully registered.');
		$this->redirect('Homepage:');
	}

}
