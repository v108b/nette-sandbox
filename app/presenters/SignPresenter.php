<?php

namespace App\Presenters;

use 
	\Nette\Application\UI,
	\Nette\Forms\Form,
	\V108B\NetteBSForms;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentSignUpForm() {
		$form = new \Nette\Application\UI\Form();
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

		$form->addText('captcha', 'Who you gonna call!? (v108b)')
			->setRequired('Answer to the security question is required')				
			->addRule(Form::EQUAL, 'Bad answer', 'v108b');

		$form->addSubmit('submit', 'Register me!');		
		$form->onSuccess[] = $this->signUpSuccess;
		
		return $form;
	
	}
	

	public function signUpSuccess(\Nette\Application\UI\Form $form, $values)
	{			
		$this->dbContext->userManager->add($values['username'], $values['password']);
		$this->flashMessage('You were successfully registered.');
		$this->redirect('Homepage:');
	}


	public function createComponentSignInForm() {
		$form = new UI\Form();
		$form->addGroup('');
		$form->addText('username', 'Username:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');
		$form->addSubmit('submit', 'Sign in');

		// call method signInFormSubmitted() on success
		$form->onSuccess[] = $this->signInFormSuccess;
		
		return $form;
	}
	
	public function signInFormSuccess(\Nette\Application\UI\Form $form)
	{
		$values = $form->getValues();
		\Tracy\Debugger::barDump($form);

		if ($values->remember) {
			$this->getUser()->setExpiration('+ 14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('+ 20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->redirect('Homepage:');
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}
