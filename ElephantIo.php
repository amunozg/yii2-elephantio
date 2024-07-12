<?php
namespace sammaye\elephantio;

use yii\base\Component;
use ElephantIO\Client;

class ElephantIo extends Component
{
	public $host = 'http://localhost:3000';

	public $options = [];

	private $_client;


	public function init()
	{
		parent::init();

		$host = $this->host;

		$this->_client = Client::create($host, $this->options);
		$this->_client->connect();
	}

	public function emit($event, $params = [], $namespace = null)
	{
		if($namespace){
			$this->setNamespace($namespace);
		}
		return $this->_client->emit($event, $params);
	}

	public function read()
	{
		return $this->_client->read();
	}

	public function close()
	{
		return $this->_client->close();
	}

	public function setNamespace($namespace)
	{
		if(method_exists($this->_client,'of')){
			$this->_client->of($namespace);
		}
	}
}