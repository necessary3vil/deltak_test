<?php

Class Website {
	public $name;
	public $logo;
	public $url;
	protected $_data = array(
		'http://example.com/engage' => array('Engage University', 'http://example.com/logo.png'),
		'http://officite.com' => array('Officite', 'http://www.officite.com/wp-content/themes/ofc_corp/img/logo.png'),
		'http://agentisenergy.com/' => array('Agentis Energy', 'http://agentisenergy.com/images/logo_agentis.jpg'),
	);
	
	/**
	 * Seaches internal data and loads members if a match is found
	 * @param string $search url to search
	 * @return Website returns $this for fluid interface
	 */
	public function load($search) {
		//strip out http(s) and www.
		$search = preg_replace('/http[s]?:\/\//', '', $search);
		$search = preg_replace('/www\./', '', $search);
		foreach ($this->_data as $url => $data) {
			if (preg_match("|$search|", $url) && !empty($search)) {
				$this->name = $this->_data[$url][0];
				$this->logo = $this->_data[$url][1];
				$this->url = $url;
			}
		}
		return $this;
	}
	
	/**
	 * Tests if object is valid
	 * @return bool
	 */
	public function isValid() {
		return ($this->name != null && $this->logo != null && $this->url != null);
	}
	
	/**
	 * Converts object to json if it is valid
	 * @return string
	 */
	public function toJson() {
		if ($this->isValid()) {
			return json_encode($this);
		} else {
			return null;
		}
	}
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$web = new Website();
echo $web->load($_GET['q'])->toJson();