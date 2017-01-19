<?php
/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/19/2017
 * Time: 10:13 AM
 */
class P_event extends CI_Model
{
	private $parse;
	private $objectId;

	const CLASS_NAME='Event';

	function __construct()
	{
		parent::__construct();
		//$this->parse=$parse;
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
	 * instance of ParseRestClient library
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

	public function countPost()
	{
		return $this->parse->query
		(
			[
				"objectId" => 'Post',
				'query'=>'{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"'. $this->objectId . '"}}',
				'count'=>1,
				'limit'=>0
			]
		)->count;
	}

	public function deleteEvent()
	{
		$limit=50;
		$skip=0;
		$total=$this->countPost();
		$counter=0;
/*		var_dump( $this->objectId);
		var_dump( 'total '.$total);*/
		while($counter<$total)
		{
			$posts=$this->parse->query
			(
				[
					"objectId" => 'Post',
					'skip'=>$skip,
					'limit'=>$limit,
					'query'=>'{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"'. $this->objectId . '"}}'
				]
			)->results;
			if($posts)
			{
				$param=[];
				foreach ($posts as $post){
					$param[]=[
						"method"=> "DELETE",
						"path"=>"/parse/classes/Post/{$post->objectId}"
					];
				}
				$this->parse->batch($param);
			}
			$counter+=$limit;
			$limit+=50;
			$skip+=50;
		}
		$this->parse->delete(['classes'=>'Event','objectId'=>$this->objectId]);
	}
}