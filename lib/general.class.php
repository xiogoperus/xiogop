<?php
class General {
	private $config = null;
	function __construct($config) {
       $this->config = $config;
   	}
	public function process() {
		require($this->config);
		foreach ($structArray as $view) {
		    self::render($view);
		}
	}
	public function render($view) 
	{
		include($view);
	}
	public function renderPage($view) 
	{
		require($this->config);
		include($view);
	}

}
?>