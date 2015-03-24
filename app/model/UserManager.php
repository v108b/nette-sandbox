<?php

namespace App\Model;

use Nette,
	Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager extends Nette\Object implements Nette\Security\IAuthenticator
{
	const
		USER_TABLE_NAME = 'users',
		COLUMN_ID = 'id',
		COLUMN_NAME = 'username',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_ROLE = 'role',
		ROLE_TABLE_NAME = self::USER_TABLE_NAME;			


	/** @var Nette\Database\Context */
	private $db;
	private $row;


	public function __construct(Nette\Database\Context $db)
	{
		$this->db = $db;
	}


	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$row = $this->db->table(self::USER_TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();
		$this->row = $row;

		if (!$row) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update(array(
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);				
		$roles = $this->getRoles($row['id']);				
		
		return new Nette\Security\Identity($row[self::COLUMN_ID], $roles, $arr);
	}
	
	public function getRoles($userid) {
		
		$roles[] = 'guest';
		if (self::USER_TABLE_NAME == self::ROLE_TABLE_NAME) {		
			if ($this->row[self::COLUMN_ROLE] != '') {							
				$roles[] = $this->row[self::COLUMN_ROLE];
			}
		} else {
			$roles = $this->db->table('userroles')->where('userid = ?', $userid)->fetchPairs(null, 'role');
		}				
		
		return $roles;
	}
	
	/**
	 * Adds new user.
	 * @param  string
	 * @param  string
	 * @return void
	 */
	public function add($username, $password)
	{
		try {
			$this->db->table(self::USER_TABLE_NAME)->insert(array(
				self::COLUMN_NAME => $username,
				self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
			));
		} catch (Nette\Database\UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

}



class DuplicateNameException extends \Exception
{}
