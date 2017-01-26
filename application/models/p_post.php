<?php
/**
 * Created by IntelliJ IDEA.
 * User: Global21
 * Date: 1/19/2017
 * Time: 4:50 PM
 */
class P_post extends CI_Model
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

	public function delete()
	{
		$this->parse->delete(['classes'=>'Post','objectId'=>$this->objectId]);
	}
	public function delete_title($id)
	{
		return $this->parserestclient->update(['classes'=>'Post','objectId'=>$id, 'object'=>['title'=>" "]]);
	}
	public function delete_description($id)
	{
		return $this->parserestclient->update(['classes'=>'Post','objectId'=>$id, 'object'=>['description'=>" "]]);
	}
	public function delete_comment($id)
	{
		return $this->parserestclient->delete(['classes'=>'Comments','objectId'=>$id]);
	}
}