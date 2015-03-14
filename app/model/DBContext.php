<?php
namespace App\Model;

use Nette;

class DBContext extends Nette\Object
{
    /** @var UserManager */
    public $userManager;

    /** @var Nette\Database\Context */
    public $db;


    public function __construct(Nette\Database\Context $db)
    {
        $this->db = $db;
        $this->userManager = new UserManager($db);
    }
}