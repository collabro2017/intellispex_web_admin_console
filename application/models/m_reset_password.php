<?php

/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/31/2017
 * Time: 2:52 PM
 */
class M_reset_password extends CI_Model
{

	protected $id;
	protected $hash;
	protected $user;
	const TABLE_NAME = 'reset_password';

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
	public function getHas()
	{
		return $this->hash;
	}

	/**
	 * @param mixed $hash
	 */
	public function setHash( $hash )
	{
		$this->hash = $hash;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user )
	{
		$this->user = $user;
	}

	public function __construct()
	{
		parent::__construct();
	}

	public function save()
	{
		if ( $this->getId() )
		{
			return $this->db->update( static::TABLE_NAME, $this, [ 'id' => $this->getId() ] );
		}
		else
		{
			$result = $this->db->insert( self::TABLE_NAME,
				[
					'user' => $this->user,
					'hash' => $this->hash,
				] );
			if ( $result )
			{
				$this->id = $this->db->insert_id();
			}
			return $this->id;
		}
	}

	public function getByUser( $user )
	{
		$query = $this->db->where( self::TABLE_NAME, [ 'user' => $user ], 1 );
		return $query->result_array( );
	}

	public function getUserHash( $user, $hash )
	{
		$query = $this->db->get_where( self::TABLE_NAME, [ 'user' => $user, 'hash' => $hash ], 1 );
		return $query->result_array(  );
	}

	public function delete( $user )
	{
		return $this->db->delete( self::TABLE_NAME, array( 'user' => $user ) );
	}
}