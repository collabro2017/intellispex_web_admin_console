<?php

/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/28/2017
 * Time: 8:22 AM
 */
class P_user extends CI_Model
{
	private $parse;
	private $objectId;

	protected $name;
	protected $LastName;
	protected $company;
	protected $email;
	protected $country;
	protected $zipcode;
	protected $phone;
	protected $City;
	protected $Gender;
	protected $State;

	const CLASS_NAME = '_User';

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->State;
	}

	/**
	 * @param mixed $State
	 */
	public function setState( $State )
	{
		$this->State = $State;
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
	public function getLastname()
	{
		return $this->LastName;
	}

	/**
	 * @param mixed $lastname
	 */
	public function setLastname( $lastname )
	{
		$this->LastName = $lastname;
	}

	/**
	 * @return mixed
	 */
	public function getCompany()
	{
		return $this->company;
	}

	/**
	 * @param mixed $company
	 */
	public function setCompany( $company )
	{
		$this->company = $company;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail( $email )
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param mixed $country
	 */
	public function setCountry( $country )
	{
		$this->country = $country;
	}

	/**
	 * @return mixed
	 */
	public function getZipcode()
	{
		return $this->zipcode;
	}

	/**
	 * @param mixed $zipcode
	 */
	public function setZipcode( $zipcode )
	{
		$this->zipcode = $zipcode;
	}

	/**
	 * @return mixed
	 */
	public function getTelephone()
	{
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 */
	public function setTelephone( $phone )
	{
		$this->phone = $phone;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->City;
	}

	/**
	 * @param mixed $City
	 */
	public function setCity( $City )
	{
		$this->City = $City;
	}

	/**
	 * @return mixed
	 */
	public function getGender()
	{
		return $this->Gender;
	}

	/**
	 * @param mixed $Gender
	 */
	public function setGender( $Gender )
	{
		$this->Gender = $Gender;
	}


	/**
	 * @return mixed
	 */
	public function getParse()
	{
		return $this->parse;
	}

	/**
	 * @param mixed $parse
	 */
	public function setParse( $parse )
	{
		$this->parse = $parse;
	}

	/**
	 * @return mixed
	 */
	public function getObjectId()
	{
		return $this->objectId;
	}

	/**
	 * @param mixed $objectId
	 */
	public function setObjectId( $objectId )
	{
		$this->objectId = $objectId;
	}

	function __construct()
	{
		parent::__construct();
		//$this->parse=$parse;
	}

	/**
	 * get all user from mongodb
	 * @param $limit , how many results to get
	 * @param $skip , similar to offset
	 * @return mixed
	 */
	public function getAll( $limit, $skip, $order, $dir )
	{
		if ( $dir == 'desc' )
		{
			$order = "-{$order}";
		}

		$response = $this->parse->query
		(
			[
				"objectId" => self::CLASS_NAME,
				'query' => '{"Status":{"$ne":false}}',
				'skip' => $skip,
				'limit' => $limit,
				'order' => $order
			]
		)->results;
		return $response;
	}

	public function getAllSuspendedUser( $limit, $skip, $order, $dir )
	{
		if ( $dir == 'desc' )
		{
			$order = "-{$order}";
		}

		$response = $this->parse->query
		(
			[
				"objectId" => self::CLASS_NAME,
				'query' => '{"Status":false}',
				'skip' => $skip,
				'limit' => $limit,
				'order' => $order
			]
		)->results;
		return $response;
	}

	public function countAll()
	{
		return $this->parse->query
		(
			[
				"objectId" => self::CLASS_NAME,
				'query' => '{"Status":{"$ne":false}}',
				'limit' => 0,
				'count' => 1,
			]
		)->count;
	}

	public function countAllSuspendedUser(){
		return $this->parse->query
		(
			[
				"objectId" => self::CLASS_NAME,
				'query' => '{"Status":false}',
				'limit' => 0,
				'count' => 1,
			]
		)->count;
	}

	public function update()
	{
		$object = get_object_vars( $this );
		unset( $object[ 'parse' ] );
		unset( $object[ 'objectId' ] );
		/*echo '<pre>';var_dump( $object );'</pre>';
				exit;*/
		return $this->parse->update( [ 'classes' => self::CLASS_NAME, 'objectId' => $this->objectId,
			'object' => $object, 'use_master' => 1 ] );
	}

	public function updatePassword( $password )
	{
		return $this->parse->update( [ 'classes' => self::CLASS_NAME, 'objectId' => $this->objectId,
			'object' => [ 'password' => $password ], 'use_master' => 1 ] );
	}

	public function getById( $id )
	{
		$response = $this->parse->query
		(
			[
				"objectId" => self::CLASS_NAME,
				'query' => '{"objectId":"' . $id . '","Status":{"$ne":false}}'
			]
		)->results;

		return $response;
	}

	public function suspend_batch_user( $ids )
	{
		$request = [ 'request' => [], 'use_master' => 1 ];
		$counter = 0;
		foreach ( $ids as $index => $id )
		{
			if ( $counter >= 50 )
			{
				$this->parse->batch( $request );
				$request = [ 'request' => [], 'use_master' => 1 ];
				$counter = 0;
			}
			else
			{
				$request[ 'request' ][] = [
					'method' => 'PUT',
					'path' => '/parse/classes/_User/' . $id,
					'body' => [ 'Status' => false ]
				];
				$counter++;
			}
		}
		if ( $request )
		{
			$this->parse->batch( $request );
		}
	}

	public function delete_batch_user( $ids )
	{
		$request = [ 'request' => [], 'use_master' => 1 ];
		$counter = 0;
		foreach ( $ids as $index => $id )
		{
			if ( $counter >= 50 )
			{
				$this->parse->batch( $request );
				$request = [ 'request' => [], 'use_master' => 1 ];
				$counter = 0;
			}
			else
			{
				$request[ 'request' ][] = [
					'method' => 'DELETE',
					'path' => '/parse/classes/_User/' . $id,
				];
				$counter++;
			}
		}
		if ( $request )
		{
			$this->parse->batch( $request );
		}
	}

	public function enable_batch_user( $ids )
	{
		$request = [ 'request' => [], 'use_master' => 1 ];
		$counter = 0;
		foreach ( $ids as $index => $id )
		{
			if ( $counter >= 50 )
			{
				$this->parse->batch( $request );
				$request = [ 'request' => [], 'use_master' => 1 ];
				$counter = 0;
			}
			else
			{
				$request[ 'request' ][] = [
					'method' => 'PUT',
					'path' => '/parse/classes/_User/' . $id,
					'body' => [ 'Status' => true ]
				];
				$counter++;
			}
		}
		if ( $request )
		{
			$this->parse->batch( $request );
		}
	}

	public function login( $user, $pass )
	{
		return $this->parse->login( $user, $pass );
	}

	public function logout()
	{

	}
}