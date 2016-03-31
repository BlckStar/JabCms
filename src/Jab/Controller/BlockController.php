<?php

namespace Jab\Controller;

class BlockController extends TemplateController
{

	public function __construct ($templatePath)
	{
		$templatePath = ltrim($templatePath, '/\\');
		$this->templatePath = JAB_ROOT . '/src/' . $templatePath;
	}

	public function render ($sitePath)
	{
		ob_start();
		include $this->templatePath . $sitePath;
		$page = ob_get_contents();
		ob_end_clean();
		return $page;
	}

}
