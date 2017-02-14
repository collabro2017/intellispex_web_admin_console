<!DOCTYPE html>
<html lang="en">
	<?php $this->load->view('default/head/console_page.php'); ?>
	<link rel="stylesheet" href="<?= base_url('public') ?>/css/events.css" />
	<body class="login-layout admin-body">
	<?php $this->load->view('default/nav/console_page.php'); ?>
  	<div class="container-fluid" id="main-container">
		<div id="main-content">
			<div class="row-fluid">
				<div class="span12">
					<div class="widget-main">
						<div class="row-fluid">
							<div class="span10">
								<div class="row">
									<h3 class="event-title" data-id="<?=$info[0]->objectId?>">Event <?php
										if( isset( $info[0]->eventBadgeFlag) && $info[0]->eventBadgeFlag){
											echo '<i class="icon-flag"></i>';
										}
										?></h3>
									<div id="event_header">
										<ul>
											<li>
												<div class="row">
													<div class="span10 post-title">
														<h4><?=$info[0]->eventname?></h4>
													</div>
												</div>

												<img src="<?= $info[0]->postImage->url?>"  width="100%" />
												<div class="row">
													<div class="span10 post-description">
														<h4>Description</h4>
													</div>

													<div class="span10 post-comment" >
														<p><?=$info[0]->description;?></p>
													</div>
												</div>
											</li>
										</ul>

									</div>
									<h3 class="event-title">Posts</h3>
									<div id="event_area">
										<ul>
											<?php foreach($info[0]->postedObjects as $key ) : ?>

													<li data-id="<?=$key->objectId?>" style="text-align: left">
														<?php
														if( isset( $key->usersBadgeFlag) && $key->usersBadgeFlag){
															echo '<i class="icon-flag" ></i>';
														}
														?>
														<?php if($key->title && $key->title!=" "):?>
															<div class="row">
																<div class="span10 post-title">
																	<h4 class=""><?=$key->title;?></h4>
																</div>
																<div class="span1" style="margin-left: 3em">
																	<button onclick="script:delete_title('<?=$key->objectId?>');"
																			style="margin-top: 0.5em">Delete</button>
																</div>
															</div>
														<?php endif;?>
														<?php
															if(isset($key->postType))
															{
																$html='';
																switch ($key->postType){
																	case 'audio':
																		$html="<audio  controls>";
																		$html.="<source src='{$key->postFile->url}' type='audio/wav'/>";
																		$html.="<source src='{$key->postFile->url}' type='audio/mp3'/>";
																		$html.="<source src='{$key->postFile->url}' type='audio/ogg'/>";
																		$html.="Your browser does not support the audio element.";
																		$html.="</audio>";
																		break;
																	case 'video':
																		$html="<video width='320' height='240' controls>";
																		$html.="<source src='{$key->postFile->url}' type='video/wav'/>";
																		$html.="<source src='{$key->postFile->url}' type='video/mov'/>";
																		$html.="<source src='{$key->postFile->url}' type='video/mp4'/>";
																		$html.="</video>";
																		break;
																	case 'photo':
																		$html="<img src='{$key->thumbImage->url}' width='100%'/>";
																		break;
																	default:break;
																}
																echo $html;
															}
														?>
														<div class="row">
															<?php if($key->description && $key->description!=" "):?>
																<div class="span10 post-description">
																	<h4 >Description</h4>
																</div>
																<div class="span10 post-comment" >
																	<p><?=$key->description;?></p>
																</div>
																<div class="span1">
																	<button onclick="script:delete_description('<?=$key->objectId?>')";>Delete</button>
																</div>
															<?php endif;?>
														</div>
														<div class="row">
															<?php  if ( isset( $key->commentsArray ) && $key->commentsArray ):?>
																<div class="span10 post-description">
																	<h4  class="">Comments</h4>
																</div>
																<?php foreach ($key->commentsArray as $comment):?>
																		<div class="span10 post-comment" >
																			<?php
																				if(isset($comment->Comments))
																				{
																					echo "<p>{$comment->Comments}</p>";
																				}else{
																						echo  "<p>{$comment}</p>";
																				}
																			?>
																			<div class="comment-separator"></div>
																		</div>
																		<div class="span1">
																			<button onclick="script:delete_comment('<?=$key->objectId?>','<?=$comment->objectId;?>')">
																				Delete</button>
																		</div>
																<?php endforeach;?>
															<?php endif;?>
														</div>
													</li>

											<?php endforeach; ?>
										</ul>
									</div>
								</div>
								<div class="clear">
									<a href="#" onclick="script:deletesheets();" class="btn btn-small btn-primary menu-button">
										Delete Selected Sheets
									</a>
								</div>
								<div class="clear">
									<a href="<?php echo base_url(); ?>manage/console_menu" class="btn btn-small btn-primary menu-button">
										Console Menu
									</a>
								</div>
							</div>
							<div class="span2">
								<a class="btn btn-small btn-primary menu-button menu-logout-button" href="<?php echo base_url(); ?>manage/logout">
			  						Logout
			  					</a>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<a class=" btn btn-small btn-primary menu-button menu-logout-button menu-button-small" href="<?php echo base_url(); ?>/manage/sqlserver">
									SQL Server
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('default/footer/console_page.php'); ?>
	<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready
		(
			function()
			{
			    $('#event_area ul').multiSelect
				(
					{
			        	unselectOn: '#event_area',
			        	keepSelection: true,
			    	}
				);
			}
		);
		function delete_title(id){
			var result=confirm("Are you sure?");
			if ( result==true )
			{
				var url="<?php echo base_url("/events/ajax_delete_post_title"); ?>"+"/"+id;
				$.ajax({
					url: url,
					method: "GET",
					success:function(data)
					{
						if(data.result=='success'){
							location.reload();
						}else{
							alert("the selected post's title could not be deleted");
						}
					}
				});
			}
		}
		function delete_comment(postId,commentId){
			var result=confirm("Are you sure?");
			if ( result==true )
			{
				var url = "<?php echo base_url( "/events/ajax_delete_comment" ); ?>" + "/" + postId+"/"+commentId;
				$.ajax ( {
					url : url ,
					method : "GET" ,
					success : function ( data )
					{
						if ( data.result == 'success' )
						{
							location.reload ();
						} else
						{
							alert ( "the selected post's comment could not be deleted" );
						}
					}
				} );
			}
		}
		function delete_description(id)
		{
			var result=confirm("Are you sure?");
			if ( result==true )
			{
				var url = "<?php echo base_url( "/events/ajax_delete_post_description" ); ?>" + "/" + id;
				$.ajax ( {
					url : url ,
					method : "GET" ,
					success : function ( data )
					{
						if ( data.result == 'success' )
						{
							location.reload ();
						} else
						{
							alert ( "the selected post's description could not be deleted" );
						}
					}
				} );
			}
		}
		function deletesheets()
		{
			var result=confirm("Are you sure?");
			if ( result==true )
			{
				var id = [];
				$ ( "#event_area ul li.selected" ).each(function ( index )
					  {
						  id.push ( $ ( this ).data ( "id" ) );
					  }
				  );
				$.ajax ( {
					url : "<?php echo base_url( "/events/ajax_delete_post" ); ?>" ,
					method : "POST" ,
					data : { id : id } ,
					success : function ( data )
					{
						if ( data.result == 'success' )
						{
							location.reload ();
						} else
						{
							alert ( 'the selected sheets could not be deleted' );
						}
					}
				} );
			}
		}
		$.fn.multiSelect = function(o)
		{
		    var defaults = {
		        multiselect: true,
		        selected: 'selected',
		        filter:        ' > *',
		        unselectOn:    false,
		        keepSelection: true,
		        list:            $(this).selector,
		        e:                null,
		        element:    null,
		        start: false,
		        stop: false,
		        unselecting: false
		    }
		    return this.each(function(k,v) {
		        var options = $.extend({}, defaults, o || {});
		        // selector - parent, assign listener to children only
		        $(document).on('mousedown', options.list+options.filter, function(e)
				{
		            if (e.which == 1)
					{
						if (options.handle != undefined && !$(e.target).is(options.handle)) {

		                     return true;
		                }
		                options.e = e;
		                options.element = $(this);
		                multiSelect(options);
		            }
		            return true;
		        });

		        if (options.unselectOn)
				{
		            $(document).on('mousedown', options.unselectOn, function(e)
					{
		                if (!$(e.target).parents().is(options.list) && e.which != 3)
						{
		                    $(options.list+' .'+options.selected).removeClass(options.selected);
		                    if (options.unselecting != false)
							{
		                        options.unselecting();
		                    }
		                }
		            });

		        }

		    });


		}

		function multiSelect(o)
		{
		    var target = o.e.target;
		    var element = o.element;
		    var list = o.list;

		    if ($(element).hasClass('ui-sortable-helper'))
			{
		        return false;
		    }

		    if (o.start != false)
			{
		        var start = o.start(o.e, $(element));
		        if (start == false)
				{
		            return false;
		        }
		    }

		    if (o.e.shiftKey && o.multiselect)
			{
		        $(element).addClass(o.selected);
		        first = $(o.list).find('.'+o.selected).first().index();
		        last = $(o.list).find('.'+o.selected).last().index();

		        if (last < first)
				{
		            firstHolder = first;
		            first = last;
		            last = firstHolder;
		        }

		        if (first == -1 || last == -1)
				{
		            return false;
		        }

		        $(o.list).find('.'+o.selected).removeClass(o.selected);

		        var num = last - first;
		        var x = first;

		        for (i=0;i<=num;i++)
				{
		            $(list).find(o.filter).eq(x).addClass(o.selected);
		            x++;
		        }
		    }
			else if ((o.e.ctrlKey || o.e.metaKey) && o.multiselect)
			{
		        if ($(element).hasClass(o.selected))
				{
		            $(element).removeClass(o.selected);
		        } else
				{
		            $(element).addClass(o.selected);
		        }
		    }
			else
			{
		        if (o.keepSelection && !$(element).hasClass(o.selected))
				{
		           $(list).find('.'+o.selected).removeClass(o.selected);
		           $(element).addClass(o.selected);
		        }
				else
				{
		           $(list).find('.'+o.selected).removeClass(o.selected);
		           $(element).addClass(o.selected);
		        }

		    }

		    if (o.stop != false)
			{
		        o.stop($(list).find('.'+o.selected), $(element));
		    }

		}

	</script>
	</body>
</html>
