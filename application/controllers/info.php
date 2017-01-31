<?php
/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/20/2017
 * Time: 12:55 PM
 */
class Info extends CI_Controller {

	/**
	 * Sys_Contract constructor.
	 */
	public function __construct()
	{
		parent::__construct();


	}
	public function index( $name = null ){
		
		if(!$name)
		{
			redirect( 'manage', 'refresh' );
		}
		else
		{
			$data = new stdClass;
			$this->load->model('m_sys_contract', 'contract', TRUE);
			$version=$this->getVersion();
			if($version){
				$data->content = $this->contract->getByVersionName( $name, $version );
				if( count($data->content) == 0)
				{
					redirect( 'manage', 'refresh' );
				}
				else
				{
					$this->load->view('info/index', $data);
				}
			}else{
				redirect( 'manage', 'refresh' );
			}
		}
	}
	private function getVersion(){
		$this->load->library('ParseRestClient');
		$result =$this->parserestclient->getConfig();
		if($result['code']==200){
			$param=json_decode( $result['response']);
			return $param->params->version;
		}
		return null;
	}

	  //le pasamos un array como segundo argumento, estos son los parámetros
	  public function _remap($method, $params = array())
	  {
	    //comprobamos si existe el método, no queremos que al llamar
	    //a un método codeigniter crea que es un parámetro del index
	    if(!method_exists($this, $method))
	      {
	       $this->index($method, $params);
	    }else{
	      return call_user_func_array(array($this, $method), $params);
	    }
	  }
	
}	
