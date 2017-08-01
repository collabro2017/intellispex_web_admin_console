<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include_once('CI_Controller_EX.php');

class events extends CI_Controller_EX {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_user', '', TRUE);
        $this->load->model('M_client', '', TRUE);
        if ($this->input->post('remember_me')) // set sess_expire_on_close to 0 or FALSE when remember me is checked.
            $this->config->set_item('sess_expire_on_close', '0'); // do change session config
        $this->load->library("session");
        $this->load->library('form_validation');
        $this->load->library('grocery_CRUD');
        $this->load->library('ParseRestClient');
    }

    public function index() {
        $day = $this->input->get('day');
        $asc = $this->input->get('asc');

        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        $data->asc = ($asc == FALSE) ? 0 : 1;
        $asc = ($asc == FALSE) ? 'createdAt' : '-createdAt';
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";

            if (!$day || is_null($day) || $day == "") {
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            'query' => '{"deletedAt":null}',
                            'order' => $asc
                        )
                );
                $data->day = "";
            } else {

                $dayCount = -1 * $day;
                $date = date(DateTime::ISO8601, strtotime($dayCount . ' days'));
                //$date = "2017-06-01T00:00:00.000Z";
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            //'query'=>'{"deletedAt":null, "createdAt":{"$gt":"'.$date.'"}}',
                            'query' => '{"deletedAt":null, "createdAt":{"$gte":{"__type":"Date","iso":"' . $date . '"}}}',
                            'order' => $asc,
                        //'limit'=>intval($day),
                        )
                );
                $data->day = $day;
            }

            $data->info = json_decode(json_encode($temp), true);
            $this->load->view('default/events/list', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function event($event_id) {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->event_id = $event_id;

            $event = json_decode(json_encode($this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        "query" => '{"objectId":"' . $event_id . '"}'
                    )
            ), true));
            $data->event_comment = json_decode(json_encode($this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "EventComment",
                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}'
                    )
            ), true));
            $user = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"XVr1sAmAQl"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                        )
                    );
            $data->associated_user = json_decode(json_encode($user), true); 
            $user_group = $this->parserestclient->query(
                        array(
                            "objectId" => "user_group",
                            'query' => '{"created_by":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                        )
                    );
            $data->user_group = json_decode(json_encode($user_group), true); 
            
            $data->function_name = $event[0]->eventname;
            $data->event = $event[0];
            $data->current_user = $session_data['mongodb_id'];
            $this->load->view('default/events/view', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function eventdelete() {
        $deletelist = $this->input->post('deletelist');
        foreach ($deletelist as $val) {
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $this->parserestclient->update
                    (
                    array
                        (
                        "objectId" => "Event",
                        'object' => ['deletedAt' => "2017-07-03"],
                        'where' => $val
                    )
            );
        }
    }
    
    public function add_event_comment() {
        $date = date(DateTime::ISO8601, time());
        $Comments = $this->input->post('Comments');
        $Commenter = $this->input->post('Commenter');
        $targetEvent = $this->input->post('targetEvent');
        $response = $this->parserestclient->create
                        (
                        array
                            (
                            "objectId" => "EventComment",
                            'object' => ['Comments' => "$Comments",
                                'createdAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'Commenter' => [
                                    "__type" => "Pointer",
                                    "className" => "_User",
                                    "objectId" => "$Commenter"
                                ], 'targetEvent' => [
                                    "__type" => "Pointer",
                                    "className" => "Event",
                                    "objectId" => "$targetEvent"
                                ]]
                        )
                );
        redirect('/events/event/'.$targetEvent, 'refresh');
    }
    
    public function update_event($event_id) {
        $date = date(DateTime::ISO8601, time());
        $name = $this->input->post('eventname');
        $description = $this->input->post('description');
        $response = $this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "Event",
                            'object' => ['eventname' => "$name",'description' => "$description",
                                'updatedAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ]],
                                'where' => $event_id
                        )
                );
        redirect('/events/event/'.$event_id, 'refresh');
    }
    
    public function tag_user(){
        $TagFriends = array();
        $TagFriendAuthorities = array();
        $user_id =  $this->input->post('user_id');
        $event_id =  $this->input->post('event_id');
        $access_rights = $this->input->post('access_rights');
        $date = date(DateTime::ISO8601, time());
        
        $TagFriends[] = $user_id;
        $TagFriendAuthorities[] = $access_rights;
        
        $response = $this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "Event",
                            'object' => ['TagFriends' => [
                                    "__op" => "Add",
                                    "objects" => $TagFriends
                                ],
                                'TagFriendAuthorities' => [
                                    "__op" => "Add",
                                    "objects" => $TagFriendAuthorities
                                ],
                                'updatedAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ]],
                                'where' => $event_id
                        )
                );
        redirect('/events/event/'.$event_id, 'refresh');
    }
    
    public function tag_user_group($group_id, $event_id){
        $TagFriends = array();
        $TagFriendAuthorities = array();
        $date = date(DateTime::ISO8601, time());
        $user_group = $this->parserestclient->query(
                array(
                    "objectId" => "user_group",
                    'query' => '{"objectId":"'.$group_id.'"}',
                )
            );
        $user_group = json_decode(json_encode($user_group), true);
        if(count($user_group) > 0){
            if(isset($user_group[0]['users'])){
                $users = $user_group[0]['users'];
                $access_rights = $user_group[0]['access_rights'];
                foreach ($users as $key => $value) {
                    $TagFriends[] = $value;
                    $TagFriendAuthorities[] = $access_rights;
                }
                $response = $this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "Event",
                            'object' => ['TagFriends' => [
                                    "__op" => "Add",
                                    "objects" => $TagFriends
                                ],
                                'TagFriendAuthorities' => [
                                    "__op" => "Add",
                                    "objects" => $TagFriendAuthorities
                                ],
                                'updatedAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ]],
                                'where' => $event_id
                        )
                );
            }
        }
        redirect('/events/event/'.$event_id, 'refresh');
    }
    public function deletedevents() {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        //'query'=>'{"deletedAt":null}',
                        'query' => '{"deletedAt":{"$ne":null}}'
                    )
            );
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "Deleted Events";
            $data->info = json_decode(json_encode($temp), true);
            $this->load->view('default/events/deletedlist', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function eventmetadata() {
        $metadatalist = $this->input->post('metaviewlist');
        $id = $this->input->post('id');
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "EventComment",
                        //'query'=>'{"deletedAt":null}',	
                        //'query'=>'{"targetEvent":"'.$id.'"}'
                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}'
                    )
            );
            $temp_event = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        //'query'=>'{"objectId":{"$all":"'.$id.'"}}',
                        //'query'=>'{"deletedAt":null}',	
                        'query' => '{"objectId":"' . $id . '"}'
                    //"query" =>  '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"'. $id . '","__op":"Add","objects":["totalCount","location"]}}'
                    )
            );
            $temp_special = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        //'query'=>'{"objectId":{"$all":"'.$id.'"}}',
                        //'query'=>'{"deletedAt":null}',	
                        //'query'=>'{"objectId":"'.$id.'"}'
                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '","__op":"Add","objects":["totalCount","location"]}}'
                    )
            );
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "Metadata Viewer/Editor";
            $data->info = json_decode(json_encode($temp), true);
            $data->event = json_decode(json_encode($temp_event), true);
            $data->special = json_decode(json_encode($temp_special), true);
            $data->list = $metadatalist;
            $this->load->view('default/events/downloadlist', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

}

?>
