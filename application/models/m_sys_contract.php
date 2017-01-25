<?php
/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/21/2017
 * Time: 8:25 AM
 */
class M_sys_contract extends CI_Model {

	/**
	 * M_syst_contract constructor.
	 */
	public $id;
	public $name;
	public $contract;
	const TABLE_NAME='sys_contract';
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getContract()
	{
		return $this->contract;
	}

	/**
	 * @param mixed $contract
	 */
	public function setContract( $contract )
	{
		$this->contract = $contract;
	}

	public function save(){
		if ( $this->getId()  )
		{
			return $this->db->update( static::TABLE_NAME, $this, [ 'id' => $this->getId() ] );
		}else{
			$result = $this->db->insert( self::TABLE_NAME, [ 'name' => $this->name, 'contract' => $this->contract ] );
			if($result){
				$this->id=$this->db->insert_id();
			}
			return $this->id;
		}

	}
	public static function getById($id)
	{
		$ci =&get_instance();
		$ci->load->database();
		$query=$ci->db->get_where(self::TABLE_NAME, ['id' => $id], 1);
	/*	var_dump( $query->result('m_sys_contract'));
		exit;*/
		return $query->result('m_sys_contract');
	}

	public static function getByName($name)
	{
		$ci =&get_instance();
		$ci->load->database();
		$query=$ci->db->get_where(self::TABLE_NAME, ['name' => $name], 1);
	
		return $query->result('m_sys_contract');
	}

	public  function delete()
	{
		$result = $this->db->delete( static::TABLE_NAME, [ 'id' => $this->getId() ] );
		return $result;
	}

	public function getAll($limit=10, $offset=0){
		/*$ci = &get_instance();
		$ci->load->database();*/

		$query = $this->db->get( static::TABLE_NAME/*, $limit, $offset */);

		return $query->result( get_called_class() );
	}
}