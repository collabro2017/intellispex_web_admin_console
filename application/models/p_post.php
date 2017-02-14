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

	const CLASS_NAME='Post';

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
		return $this->parse->update(['classes'=>'Post','objectId'=>$id, 'object'=>['title'=>" "]]);
	}
	public function delete_description($id)
	{
		return $this->parse->update(['classes'=>'Post','objectId'=>$id, 'object'=>['description'=>" "]]);
	}
	public function delete_comment($id)
	{
		return $this->parse->delete(['classes'=>'Comments','objectId'=>$id]);
	}
	public function getListPost(array $postId)
	{
		$stringId="";
		$total_id=count( $postId);
		foreach ($postId as $position => $id)
		{
			if($position==$total_id-1)
			{
				$stringId.='"'.$id.'"';
			}else{
				$stringId.='"'.$id.'",';
			}
		}
		$response=$this->parse->query(
			[
				'objectId'=>self::CLASS_NAME,
				'query'=>'{"objectId":{"$in":['. $stringId.']}}',
			]
		)->results;
		return  $response;
	}
	public function getPostById($objectId)
	{
		$response = $this->parse->query(
			[
				'objectId'=>self::CLASS_NAME,
				'query'=>'{"objectId":"'.$objectId.'"}',
			]
		)->results;

		return $response;
	}

	public function deletePostComments( $postId, array $listCommentsId )
	{

		$this->parse->delete_batch( "Comments", $listCommentsId );
		$post = $this->getPostById( $postId );
		if ( isset( $post[0]->commentsArray ) && $post[0]->commentsArray )
		{
			$commentsArray = $post[0]->commentsArray;
			$deleteCommentsIds = [];
			foreach ( $commentsArray as $comment )
			{
				if ( in_array( $comment->objectId, $listCommentsId ) )
				{
					$deleteCommentsIds[] = $comment->objectId;
				}
			}
			return $this->parse->update_array_pointer_relation("Remove", 'Comments', $postId, $deleteCommentsIds, self::CLASS_NAME,'commentsArray');
		}
		return ['code'=>200];
	}

	public function deletePosts( array $postId )
	{
		$listPost = $this->getListPost( $postId );
		foreach ( $listPost as $post )
		{
			if(isset( $post->commentsArray ) && $post->commentsArray )
			{
				$listCommentsId=[];
				foreach ($post->commentsArray as $comment)
				{
						$listCommentsId[]=$comment->objectId;
				}
				$this->deletePostComments( $post->objectId, $listCommentsId);
			}
		}
		$this->parse->delete_batch(self::CLASS_NAME, $postId);
	}
	public function getPostByEvent($objecId)
	{
		$response = $this->parse->query(
			[
				'objectId'=>self::CLASS_NAME,
				'query'=>'{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"'.$objecId.'"}}',
				'include'=>'commentsArray,usersBadgeFlag'
			]
		)->results;

		return $response;
	}
}