<?php
include_once 'p_post.php';
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

	/*public function deleteEvent()
	{
		$limit=50;
		$skip=0;
		$total=$this->countPost();
		$counter=0;
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
	}*/

	public function countFlaggedPostEvent()
	{
		return $this->parse->query
		(
			[
				"objectId" => 'Post',
				'query' => '{
"$or":[
{"usersBadgeFlag":{"$exists":true,"$ne":[]},"targetEvent":{"$inQuery":{"where":{"objectId":{"$exists":true}},"className":"Event"}}},
{"targetEvent":{"$inQuery":{"where":{"eventBadgeFlag":{"$ne":[],"$exists":true}},"className":"Event"}}}
]
}',
				'limit' => 0,
				'include'=>'targetEvent',
				'count' => 1
			]
		)->count;
	}

	public function get_data_table_flagged_post_events( $limit, $skip, $order, $dir )
	{
		if ( $dir == 'desc' )
		{
			$order = "-{$order}";
		}
		$response = $this->parse->query
		(
			[
				"objectId" => 'Post',
				'query' => '{
							"$or":[
									{"usersBadgeFlag":{
														"$exists":true,"$ne":[]
														},
														"targetEvent":{
															"$inQuery":{"where":{
																			"objectId":{"$exists":true}
																			},
																		"className":"Event"
																		}
														}
									},
									{"targetEvent":{
											"$inQuery":{
													"where":{
														"eventBadgeFlag":{"$ne":[],"$exists":true}
														},
													"className":"Event"
													}
												}
									}
								]
							}',
				'skip' => $skip,
				'limit' => $limit,
				'order' => $order,
				'include'=>"targetEvent"
			]
		)->results;
		return $response;
	}

	public function getEventById( $id )
	{
		$response = $this->parse->query(
			[
				'objectId' => self::CLASS_NAME,
				'query' => '{"objectId":"' . $id . '"}',
				'include' => "postedObjects.user,postedObjects.usersBadgeFlag,postedObjects.commentsArray.Comments,eventBadgeFlag,user"
			]
		)->results;
		return $response;

	}

	public function deleteEvent( $eventId )
	{
		$event = $this->getEventById( $eventId );
		if ( $event )
		{
			if ( isset( $event->postedObjects ) && $event->postedObjects )
			{
				$listPostId = [];
				foreach ( $event->postedObjects as $post )
				{
					$listPostId[] = $post->objectId;
				}
				$post = new p_post();
				$post->deletePosts( $listPostId );
			}
			$this->parse->delete( [ 'classes' => 'Event', 'objectId' => $eventId ] );
		}
	}
}