<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class AkceManager
{
	use Nette\SmartObject;

	const
		TABLE_NAME = 'akce',
		COLUMN_ID = 'id',
		COLUMN_UCITEL = 'ucitel',
		COLUMN_NAZEV = 'nazev',
		COLUMN_POPIS = 'popis',
		COLUMN_DATUM = 'datum',
  	    COLUMN_TYP = 'typ',
        COLUMN_ZACI = 'zaci',
        COLUMN_DVPP = 'dvpp',
        COLUMN_MSMT = 'msmt',
        COLUMN_PORADATEL = 'poradatel',
        COLUMN_VYUKOVE_HODINY = 'vyukove_hodiny',
        COLUMN_FILE = 'file';
        


	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getAll($order) {
		return $this->database->table(self::TABLE_NAME)->order($order)->fetchAll();
	}

	public function getByType($type) {
		return $this->database->table(self::TABLE_NAME)->where('typ = ?', $type)->fetchAll();
	}

	public function getOne($id) {
		return $this->database->table(self::TABLE_NAME)->get($id);
	}

	public function insert($values) {
		$this->database->table(self::TABLE_NAME)->insert($values);
	}

	public function update($id, $values) {
		$row = $this->getOne($id);
		$row->update($values);
	}

	public function delete($id) {
		$row = $this->getOne($id);
		$row->delete();
	}

}	