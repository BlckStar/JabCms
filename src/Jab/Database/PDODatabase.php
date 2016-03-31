<?php

namespace Jab\Database;

use PDO;
use Jab\Misc\Exception\PdoStatementException;

class PDODatabase extends PDO
{

	public function __construct ($aConfig)
	{
		parent::__construct($aConfig['driver'] . ':' .
				'host=' . $aConfig['host'] . ';' .
				'dbname=' . $aConfig['db'] . ';' .
				'charset=' . $aConfig['charset'], $aConfig['user'], $aConfig['pw'], $aConfig['options']
		);

		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		if (!isset(array_flip($this->getAvailableDrivers())[$aConfig['driver']])) {
			throw new Exception('The provided PDO-Driver "' . $aConfig['driver'] . '" is not enabled.');
		}
	}

	public function q ($sQuery)
	{
		$oStatement = $this->prepare($sQuery);
		$args = func_get_args();
		array_shift($args);
		if (count($args)) {
			$aSanitizedArgs = array();
			foreach ($args[0] as $sArgKey => $aArg) {
				$aSanitizedArgs[$sArgKey] = is_array($aArg) ? $aArg[0] : $aArg;
			}
			if (!$oStatement->execute($aSanitizedArgs)) {
				throw new PdoStatementException;
			}
		}
		else {
			if (!$oStatement->execute()) {
				throw new PdoStatementException;
			}
		}
		return $oStatement;
	}

}
