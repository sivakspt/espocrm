<?php

namespace Espo\Core;

class Container
{

	private $data = array();


	/**
     * Constructor
     */
    public function __construct()
    {

    }

    
    public function get($name)
    {
    	if (empty($this->data[$name])) {
    		$this->load($name);
    	}
    	
    	return $this->data[$name];
    }

    private function load($name)
    {
    	$loadMethod = 'load' . ucfirst($name);
    	if (method_exists($this, $loadMethod)) {
    		$obj = $this->$loadMethod();
    		$this->data[$name] = $obj;
    	} else {
            //external loader class \Espo\Core\Loaders\<className> or \Custom\Espo\Core\Loaders\<className> with load() method
			$className = '\Espo\Custom\Core\Loaders\\'.ucfirst($name);
            if (!class_exists($className)) {
            	$className = '\Espo\Core\Loaders\\'.ucfirst($name);
            }

			if (class_exists($className)) {
            	 $loadClass = new $className($this);
				 $this->data[$name] = $loadClass->load();
			}
    	}

		// TODO throw an exception
    	return null;
    }


    private function loadSlim()
    {
        return new \Slim\Slim();
    }

	private function loadFileManager()
    {
    	return new \Espo\Core\Utils\File\Manager(
			(object) array(
				'defaultPermissions' => (object)  array (
				    'dir' => '0775',
				    'file' => '0664',
				    'user' => '',
				    'group' => '',
			  ),
			)
		);
    }

	private function loadConfig()
    {
    	return new \Espo\Core\Utils\Config(
			$this->get('fileManager')
		);
    }

	private function loadLog()
    {
    	return new \Espo\Core\Utils\Log(
			$this->get('fileManager'),
			$this->get('output'),
			$this->get('resolver'),
			(object) array(
				'options' => $this->get('config')->get('logger'),
				'datetime' => $this->get('datetime')->getDatetime(),
			)
		);
    }

	private function loadOutput()
    {
    	return new \Espo\Core\Utils\Api\Output(
			$this->get('slim')
		);
    }

	private function loadMetadata()
    {
    	return new \Espo\Core\Utils\Metadata(
			$this->get('entityManager'),
			$this->get('config'),
			$this->get('fileManager'),
			$this->get('uniteFiles')
		);
    }


	private function loadLayout()
    {
    	return new \Espo\Core\Utils\Layout(
			$this->get('config'),
			$this->get('fileManager'),
			$this->get('metadata')
		);
    }

	private function loadResolver()
    {
    	return new \Espo\Core\Utils\Resolver(
			$this->get('metadata')
  		);
    }

	private function loadDatetime()
    {
    	return new \Espo\Core\Utils\Datetime(
			$this->get('config')
		);
    }    

	private function loadUniteFiles()
    {
       	return new \Espo\Core\Utils\File\UniteFiles(
			$this->get('fileManager'),
            (object) array(
				'unsetFileName' => $this->get('config')->get('unsetFileName'),
				'defaultsPath' => $this->get('config')->get('defaultsPath'),
			)
		);
    }
    
	private function loadAcl()
	{
		return new \Espo\Core\Acl(
			$this->get('user')
		);
	}
	
	public function setUser($user)
	{
		$this->data['user'] = $user;
	}
	
	/*private function loadUser()
    {
       	return new \Espo\Core\Utils\User(
			$this->get('entityManager'),
			$this->get('config')
		);
    }*/

}