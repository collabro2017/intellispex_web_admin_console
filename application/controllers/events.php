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

    public function create() {
        $session_data = $this->session->userdata('logged_in');
        $data = new stdClass();
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->message = '';
            $data->function_name = "Create New Event";
            if (base_url() == 'http://intellispex.com/') {
                $regular_user = 'Di56R0ITXB';
            } else {
                $regular_user = 'XVr1sAmAQl';
            }
            if ($session_data['role'] == 1) {
                $user = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"}}',
                        )
                );
            } else {
                $user = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                        )
                );
            }
            $data->associated_user = json_decode(json_encode($user), true);
            $user_group = $this->parserestclient->query(
                    array(
                        "objectId" => "user_group",
                        'query' => '{"created_by":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                    )
            );
            $data->user_group = json_decode(json_encode($user_group), true);

            if ($this->input->post('submit')) {
                if (isset($_FILES['postImage'])) {
                    $name = $_FILES['postImage']['name'];
                    $type = $_FILES['postImage']['type'];
                    $file_base64 = file_get_contents($_FILES['postImage']['tmp_name']);
                    $temp = $this->parserestclient->file(
                            array(
                                "object" => $file_base64,
                                "content-type" => $type,
                                "file-name" => $name
                            )
                    );

                    $image = json_decode(json_encode($temp));

                    $eventname = $this->input->post('eventname');
                    $description = $this->input->post('description');
                    $country = $this->input->post('country');
                    $user_id = $session_data['mongodb_id'];
                    $temp = $this->parserestclient->query
                            (
                            array
                                (
                                "objectId" => "_User",
                                'query' => '{"objectId":"' . $user_id . '"}'
                            )
                    );
                    $user = json_decode(json_encode($temp));
                    if (count($user) > 0) {
                        $user_name = $user[0]->username;
                    } else {
                        $user_name = '';
                    }
                    $image_name = $image->name;
                    $image_url = $image->url;
                    $date = date(DateTime::ISO8601, time());
                    $response = $this->parserestclient->create
                            (
                            array
                                (
                                "objectId" => "Event",
                                'object' => ['eventname' => "$eventname", 'description' => "$description", 'country' => "$country", 'username' => "$user_name",
                                    'postType' => "image",
                                    'createdAt' => [
                                        "__type" => "Date",
                                        "iso" => $date,
                                    ], 'thumbImage' => [
                                        "__type" => "File",
                                        "name" => "$image_name",
                                        "url" => "$image_url"
                                    ], 'postImage' => [
                                        "__type" => "File",
                                        "name" => "$image_name",
                                        "url" => "$image_url"
                                    ], 'user' => [
                                        "__type" => "Pointer",
                                        "className" => "_User",
                                        "objectId" => "$user_id"
                                    ]]
                            )
                    );
                    if (isset($response->objectId)) {
                        echo '<pre>';
                        print_r($response);
                        // Tag Users to events
                        $event_id = $response->objectId;
                        $TagFriends = array();
                        $TagFriendAuthorities = array();
                        $users = $this->input->post('user_id');
                        $access_rights = $this->input->post('access_rights');
                        $date = date(DateTime::ISO8601, time());
                        if (count($users) > 0) {
                            foreach ($users as $user) {
                                $TagFriends[] = $user;
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
                            // Tag Groups from Users 
                            $user_groups = $this->input->post('user_group');
                            foreach ($user_groups as $user_group) {
                                $this->_tag_user_group($user_group, $event_id);
                            }
                            redirect(base_url() . "events/event/" . $event_id);
                        } else {
                            $data->message = 'Some issues with Event';
                        }
                    }
                }
            }
            $this->load->view('default/events/create', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function upload_event_image() {
        $image_d = file_get_contents(base_url() . "/public/like.png");
        $encoded_image = base64_encode($image_d);
        $imgdata = base64_decode($encoded_image);
        $f = finfo_open();

        $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
        echo $mime_type;
        $temp = $this->parserestclient->file
                (
                array
                    (
                    "object" => $imgdata,
                    "content-type" => $mime_type,
                    "file-name" => "like.png"
                )
        );
        print_r($temp);
    }

    public function admin_content_search() {
        $this->load->model('m_client');
        $event_id = array();
        $event_post_id = array();
//        echo '<pre>';
//            $line = 'test';
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Event",
                    "query" => '{"description":{"$ne": "" }}',
                )
        );
        $results = array();
        $i = 0;
        $events = json_decode(json_encode($temp), true);
        $results = array();
        $i = 0;
        $events = json_decode(json_encode($temp), true);
        if (isset($events) && count($events) > 0) {
            foreach ($events as $event) {
                if(isset($event['user'])){
                    $commenter = $event['user'];
                    $description = explode(' ', $event['description']);
                    $des_flag = false;
                    foreach ($description as $des) {
                        if (strlen($des) > 3) {
                            if ($this->m_client->checkBadWords($des)) {
                                $des_flag = TRUE;
                                break;
                            }
                        }
                    }
                    if ($des_flag) {
                        $results[$i]['objectId'] = $event['objectId'];
                        $results[$i]['createdAt'] = date('Y-m-d g:i A', strtotime($event['createdAt']));
                        $results[$i]['eventname'] = $event['eventname'];
                        $results[$i]['username'] = $event['username'];
                        $results[$i]['description'] = $event['description'];
                        $results[$i]['content_type'] = 'Event';
                        $results[$i]['reported_id'] = $content['objectId'];
                        $results[$i]['user_id'] = $commenter['objectId'];
                        $results[$i]['post_id'] = '';
                        $i++;
                    }
                }
            }
        }
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Post",
                    "query" => '{"description":{"$ne": "" }}',
                    'order' => 'postType'
                )
        );
        $event_posts = json_decode(json_encode($temp), true);
        if (isset($event_posts)) {
            foreach ($event_posts as $post) {
                if (isset($post['targetEvent'])) {
                    $description = explode(' ', $post['description']);
                    $des_flag = false;
                    foreach ($description as $des) {
                        if (strlen($des) > 3) {
                            if ($this->m_client->checkBadWords($des)) {
                                $des_flag = TRUE;
                                break;
                            }
                        }
                    }
                    if ($des_flag) {
                        $targetEvent = $post['targetEvent'];
                        $commenter = $post['user'];
                        $user_details = $this->parserestclient->query(array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"objectId":"' . $commenter['objectId'] . '"}',
                                )
                        );
                        $user_details = json_decode(json_encode($user_details), true);
                        $results[$i]['objectId'] = $targetEvent['objectId'];
                        $results[$i]['createdAt'] = date('Y-m-d g:i A', strtotime($post['createdAt']));
                        $results[$i]['eventname'] = $post['title'];
                        if (isset($user_details[0]['username'])) {
                            $results[$i]['username'] = $user_details[0]['username'];
                        } else {
                            $results[$i]['username'] = '';
                        }
                        $results[$i]['user_id'] = $commenter['objectId'];
                        $results[$i]['description'] = $post['description'];
                        $results[$i]['content_type'] = 'Event, Post';
                        $results[$i]['reported_id'] = $content['objectId'];
                        $results[$i]['post_id'] = $post['objectId'];
                        $i++;
                    }
                }
            }
        }
        $data = new stdClass();
        $data->page = 'admin_content_search';
        $data->event = $results; // json_decode(json_encode($temp), true);
        $html = $this->load->view('default/events/admin_content_result', $data, true);
        echo $html;
    }

    public function FlaggedEvents() {
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
            $data->function_name = "Managed Report Content";
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        'query' => '{"deletedAt":null}',
                        'order' => $asc
                    )
            );
            $i = 0;
            $event = json_decode(json_encode($temp), true);
            foreach ($event as $ev) {
                if (isset($ev)) {
                    if ($i == 0) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    } elseif (!(in_array($ev['objectId'], $eventId))) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    }
                }
                $i++;
            }
            $data->info = $events; //json_decode(json_encode($temp), true);
            $this->load->view('default/events/reported_content', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
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
            if (base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/') {
                $regular_user = 'XVr1sAmAQl';
            } else {
                $regular_user = 'Di56R0ITXB';
            }
            $user = $this->parserestclient->query(
                    array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                    )
            );
            $associated_user = json_decode(json_encode($user), true);
            $events = array();
            $eventId = array();
            $i = 0;
            $userArr = array();
            foreach ($associated_user as $user) {
                $userArr[] = $user['objectId'];
            }
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        'query' => '{"deletedAt":null, "TagFriends":{"$in":' . json_encode($userArr, true) . '}}',
                        'order' => $asc
                    )
            );
            $event = json_decode(json_encode($temp), true);
            foreach ($event as $ev) {
                if (isset($ev)) {
                    if ($i == 0) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    } elseif (!(in_array($ev['objectId'], $eventId))) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    }
                }
                $i++;
            }
            if (!$day || is_null($day) || $day == "") {

                foreach ($associated_user as $user) {
                    $temp = $this->parserestclient->query
                            (
                            array
                                (
                                "objectId" => "Event",
                                'query' => '{"deletedAt":null, "user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"}}',
                                'order' => $asc
                            )
                    );
                    $event = json_decode(json_encode($temp), true);
                    foreach ($event as $ev) {
                        if (isset($ev)) {
                            if ($i == 0) {
                                $eventId[$i] = $ev['objectId'];
                                $events[$i] = $ev;
                            } elseif (!(in_array($ev['objectId'], $eventId))) {
                                $eventId[$i] = $ev['objectId'];
                                $events[$i] = $ev;
                            }
                        }
                        $i++;
                    }
                }
                $data->day = "";
            } else {

                $dayCount = -1 * $day;
                $date = date(DateTime::ISO8601, strtotime($dayCount . ' days'));
                //$date = "2017-06-01T00:00:00.000Z";
                foreach ($associated_user as $user) {
                    $temp = $this->parserestclient->query
                            (
                            array
                                (
                                "objectId" => "Event",
                                //'query'=>'{"deletedAt":null, "createdAt":{"$gt":"'.$date.'"}}',
                                'query' => '{"deletedAt":null, "user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"}, "createdAt":{"$gte":{"__type":"Date","iso":"' . $date . '"}}}',
                                'order' => $asc,
                            //'limit'=>intval($day),
                            )
                    );
                    $event = json_decode(json_encode($temp), true);
                    foreach ($event as $ev) {
                        if (isset($ev)) {
                            if ($i == 0) {
                                $eventId[$i] = $ev['objectId'];
                                $events[$i] = $ev;
                            } elseif (!(in_array($ev['objectId'], $eventId))) {
                                $eventId[$i] = $ev['objectId'];
                                $events[$i] = $ev;
                            }
                        }
                        $i++;
                    }
                }
                $data->day = $day;
            }

            $data->info = $events; //json_decode(json_encode($temp), true);
            $this->load->view('default/events/list', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function event($event_id, $restor = 0) {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->event_id = $event_id;
            if ($restor == 0) {
                $event = json_decode(json_encode($this->parserestclient->query
                                        (
                                        array
                                            (
                                            "objectId" => "Event",
                                            "query" => '{"deletedAt":null,"objectId":"' . $event_id . '"}'
                                        )
                                ), true));
            } else {
                $event = json_decode(json_encode($this->parserestclient->query
                                        (
                                        array
                                            (
                                            "objectId" => "Event",
                                            "query" => '{"objectId":"' . $event_id . '"}'
                                        )
                                ), true));
            }
            $data->event_comment = json_decode(json_encode($this->parserestclient->query
                                    (
                                    array
                                        (
                                        "objectId" => "EventComment",
                                        "query" => '{"deletedAt":null,"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}'
                                    )
                            ), true));
            $data->event_post = json_decode(json_encode($this->parserestclient->query
                                    (
                                    array
                                        (
                                        "objectId" => "Post",
                                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                        'order' => 'postType'
                                    )
                            ), true));
            if (base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/') {
                $regular_user = 'XVr1sAmAQl';
            } else {
                $regular_user = 'Di56R0ITXB';
            }
            if ($session_data['role'] == 1) {
                $user = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"}}',
                        )
                );
            } else {
                $user = $this->parserestclient->query(
                        array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                        )
                );
            }
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
        $data = date('Y-m-d');
        foreach ($deletelist as $val) {
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $this->parserestclient->update
                    (
                    array
                        (
                        "objectId" => "Event",
                        'object' => ['deletedAt' => "$data"],
                        'where' => $val
                    )
            );
        }
    }

    public function reportEvent() {
        $session_data = $this->session->userdata('logged_in');
        $eventId = $this->input->post('deletelist');
        $user = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        $reported_content = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "ReportedContent",
                                    'query' => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $eventId . '"}}',
                                )
                )), true);
        if (count($reported_content) > 0) {
            $response = $this->parserestclient->update
                    (
                    array
                        (
                        "objectId" => "ReportedContent",
                        'object' => ['targetEvent' => [
                                "__type" => "Pointer",
                                "className" => "Event",
                                "objectId" => "$eventId"
                            ], 'reportedBy' => [
                                "__type" => "Pointer",
                                "className" => "_User",
                                "objectId" => "$user"
                            ],
                            'updatedAt' => [
                                "__type" => "Date",
                                "iso" => $date,
                            ]],
                        'where' => $reported_content[0]['objectId']
                    )
            );
        } else {
            $response = $this->parserestclient->create
                    (
                    array
                        (
                        "objectId" => "ReportedContent",
                        'object' => [
                            'createdAt' => [
                                "__type" => "Date",
                                "iso" => $date,
                            ], 'targetEvent' => [
                                "__type" => "Pointer",
                                "className" => "Event",
                                "objectId" => "$eventId"
                            ], 'reportedBy' => [
                                "__type" => "Pointer",
                                "className" => "_User",
                                "objectId" => "$user"
                            ]]
                    )
            );
        }
    }

    public function reportPost($eventId) {
        $session_data = $this->session->userdata('logged_in');
        $postId = $this->input->post('deletelist');
        $user = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        $reported_content = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "ReportedContent",
                                    'query' => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $eventId . '"}}',
                                )
                )), true);
        if (count($reported_content) > 0) {
            $response = $this->parserestclient->update
                    (
                    array
                        (
                        "objectId" => "ReportedContent",
                        'object' => ['targetEvent' => [
                                "__type" => "Pointer",
                                "className" => "Event",
                                "objectId" => "$eventId"
                            ], 'targetPost' => [
                                "__type" => "Pointer",
                                "className" => "Post",
                                "objectId" => "$postId"
                            ], 'reportedBy' => [
                                "__type" => "Pointer",
                                "className" => "_User",
                                "objectId" => "$user"
                            ],
                            'updatedAt' => [
                                "__type" => "Date",
                                "iso" => $date,
                            ]],
                        'where' => $reported_content[0]['objectId']
                    )
            );
        } else {
            $response = $this->parserestclient->create
                    (
                    array
                        (
                        "objectId" => "ReportedContent",
                        'object' => [
                            'createdAt' => [
                                "__type" => "Date",
                                "iso" => $date,
                            ], 'targetEvent' => [
                                "__type" => "Pointer",
                                "className" => "Event",
                                "objectId" => "$eventId"
                            ], 'targetPost' => [
                                "__type" => "Pointer",
                                "className" => "Post",
                                "objectId" => "$postId"
                            ], 'reportedBy' => [
                                "__type" => "Pointer",
                                "className" => "_User",
                                "objectId" => "$user"
                            ]]
                    )
            );
        }
    }

    public function eventRestore() {
        $deleteId = $this->input->post('deleteId');
        $data = date('Y-m-d');
        $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Event",
                    'object' => ['deletedAt' => ""],
                    'where' => $deleteId
                )
        );
    }

    public function update_event_comment($event_id) {
        $Comments = $this->input->post('Comments');
        $commentId = $this->input->post('commentId');
        $date = date(DateTime::ISO8601, time());
        print_r($this->parserestclient->update
                        (
                        array
                            (
                            "objectId" => "EventComment",
                            'object' => ['updatedAt' => [
                                    "__type" => "Date",
                                    "iso" => $date,
                                ], 'Comments' => "$Comments"],
                            'where' => $commentId
                        )
        ));
        redirect(base_url() . "events/event/" . $event_id);
    }

    public function update_event_post($event_id) {
        $description = $this->input->post('description');
        $title = $this->input->post('title');
        $postId = $this->input->post('title2');
        $date = date(DateTime::ISO8601, time());
        $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Post",
                    'object' => ['updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ], 'title' => "$title", 'description' => "$description"],
                    'where' => $postId
                )
        );
        redirect(base_url() . "events/event/" . $event_id);
    }

    public function commentdelete() {
        $comment_id = $this->input->post('commentId');
        $data = date('Y-m-d');
        $this->parserestclient->delete
                (
                array
                    (
                    "className" => "EventComment",
                    'objectId' => $comment_id
                )
        );
    }

    public function postdelete() {
        $post_id = $this->input->post('postId');
        $this->parserestclient->delete
                (
                array
                    (
                    "className" => "Post",
                    'objectId' => $post_id
                )
        );
    }
    
    public function dismiss() {
        $reportId= $this->input->post('reportId');
        $this->parserestclient->delete
                (
                array
                    (
                    "className" => "ReportedContent",
                    'objectId' => $reportId
                )
        );
    }
    public function userdelete() {
        $user_id = $this->input->post('user_id');
        $this->parserestclient->delete
                (
                array
                    (
                    "className" => "_User",
                    'objectId' => $user_id
                )
        );
    }

    public function suspendUser() {
        $user_id = $this->input->post('user_id');
        $date = date('Y-m-d');
        $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "_User",
                    'object' => ['status' => FALSE],
                    'where' => $val
                )
        );
    }

    public function send_user_warning() {
        $session_data = $this->session->userdata('logged_in');
        $user_id = $this->input->post('user_id');
        $user = $this->parserestclient->query(
                array(
                    "objectId" => "_User",
                    'query' => '{"objectId":"' . $user_id . '"}',
                )
        );
        $user = json_decode(json_encode($user), true);
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "test.IntelliSpeX@gmail.com";
        $config['smtp_pass'] = "Test123456789";

        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);
        $ci->email->from($session_data['username']);
        $ci->email->to($user->email);
        $this->email->reply_to($session_data['username']);
        $ci->email->subject('Warning Message for prohibited text of your post.');
        $message = 'Hi ' . $user->username . ", <br/>";
        $message .= 'This is to notify that your post is having some prohibited words. Please becareful this is final warning. <br/>Next time we will take serious action against you. <br/><br/>';
        $message .= 'Regards,<br/>';
        $message .= 'ICYMI';
        $ci->email->message($message);
    }

    public function comments() {
        $comment_id = $this->input->post('commentId');
        $event = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "EventComment",
                                    "query" => '{"deletedAt":null,"objectId": "' . $comment_id . '"}'
                                )
                        ), true));
        if (isset($event[0])) {
            echo json_encode($event[0]);
        }
    }

    public function Post() {
        $post_id = $this->input->post('postId');
        $post = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Post",
                                    "query" => '{"objectId": "' . $post_id . '"}'
                                )
                        ), true));
        if (isset($post[0])) {
            echo json_encode($post[0]);
        }
    }

    public function download($event_id, $download = 'full') {
        ob_clean();
        $data = new stdClass();
        $event = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Event",
                                    "query" => '{"deletedAt":null,"objectId":"' . $event_id . '"}'
                                )
                        ), true));
        $event = $event[0];
        $data->event = $event;
        $data->event_comment = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "EventComment",
                                    "query" => '{"deletedAt":null,"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}'
                                )
                        ), true));

        $data->event_post = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Post",
                                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                    'order' => 'postType'
                                )
                        ), true));

        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->preferences($pdf);
        $pdf->AddPage();
        if ($download == 'full') {
            $html = $this->load->view('default/events/fullResolution', $data, true);
        } else {
            $html = $this->load->view('default/events/pdfDownload', $data, true);
        }

// output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("$event->eventname.pdf", 'I');
        ob_end_clean();
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
        $comment = array();
        $comment[] = $Comments;
        $commenterArray = array();
        $commenterArray[] = [
            "__type" => "Pointer",
            "className" => "_User",
            "objectId" => "$Commenter"
        ];
        $response = $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Event",
                    'object' => ['commentsArray' => [
                            "__op" => "Add",
                            "objects" => $comment
                        ], 'commenters' => [
                            "__op" => "Add",
                            "objects" => $commenterArray
                        ],
                        'updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ]],
                    'where' => $targetEvent
                )
        );
        redirect('/events/event/' . $targetEvent, 'refresh');
    }

    public function add_post_comment($post_id) {
        $date = date(DateTime::ISO8601, time());
        $Comments = $this->input->post('Comments');
        $Commenter = $this->input->post('Commenter');
        $targetEvent = $this->input->post('targetEvent');
        $response = $this->parserestclient->create
                (
                array
                    (
                    "objectId" => "Comments",
                    'object' => ['Comments' => "$Comments",
                        'createdAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ], 'Commenter' => [
                            "__type" => "Pointer",
                            "className" => "_User",
                            "objectId" => "$Commenter"
                        ], 'postMedia' => [
                            "__type" => "Pointer",
                            "className" => "Post",
                            "objectId" => "$post_id"
                        ]]
                )
        );

        $comments = $response->objectId;
        $commentsArray[] = ["type" => "Pointer",
            "className" => "Comments",
            "objectId" => "$comments"
        ];
        $users[] = $comments;
        $response = $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Post",
                    'object' => ['commentsArray' => [
                            "__op" => "Add",
                            "objects" => $commentsArray
                        ],
                        'updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ]],
                    'where' => $post_id
                )
        );
        redirect('/events/event/' . $targetEvent, 'refresh');
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
                    'object' => ['eventname' => "$name", 'description' => "$description",
                        'updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ]],
                    'where' => $event_id
                )
        );
        redirect('/events/event/' . $event_id, 'refresh');
    }

    public function tag_user() {
        $TagFriends = array();
        $TagFriendAuthorities = array();
        $user_id = $this->input->post('user_id');
        $event_id = $this->input->post('event_id');
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
        redirect('/events/event/' . $event_id, 'refresh');
    }

    private function _tag_user_group($group_id, $event_id) {
        $TagFriends = array();
        $TagFriendAuthorities = array();
        $date = date(DateTime::ISO8601, time());
        $user_group = $this->parserestclient->query(
                array(
                    "objectId" => "user_group",
                    'query' => '{"objectId":"' . $group_id . '"}',
                )
        );
        $user_group = json_decode(json_encode($user_group), true);
        if (count($user_group) > 0) {
            if (isset($user_group[0]['users'])) {
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

                print_r($response);
                print_r($_SESSION);
            }
        }
    }

    public function tag_user_group($group_id, $event_id) {
        $this->_tag_user_group($group_id, $event_id);
        redirect('/events/event/' . $event_id, 'refresh');
    }

    public function deletedevents() {
        $data = new stdClass;
        $session_data = $this->session->userdata('logged_in');
        if ($session_data) {
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";
            if (base_url() == 'http://test.intellispex.com/' || base_url() == 'http://localhost/icymi/') {
                $regular_user = 'XVr1sAmAQl';
            } else {
                $regular_user = 'Di56R0ITXB';
            }
            $user = $this->parserestclient->query(
                    array(
                        "objectId" => "_User",
                        'query' => '{"deletedAt":null,"user_type":{"__type":"Pointer","className":"_Role","objectId":"' . $regular_user . '"},"associated_with":{"__type":"Pointer","className":"_User","objectId":"' . $session_data['mongodb_id'] . '"}}',
                    )
            );
            $associated_user = json_decode(json_encode($user), true);
            $events = array();
            $eventId = array();
            $i = 0;
            $userArr = array();
            foreach ($associated_user as $user) {
                $userArr[] = $user['objectId'];
            }
            $temp = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Event",
                        'query' => '{"deletedAt":{"$ne":null}, "TagFriends":{"$in":' . json_encode($userArr, true) . '}}'
                    )
            );
            $event = json_decode(json_encode($temp), true);
            foreach ($event as $ev) {
                if (isset($ev)) {
                    if ($i == 0) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    } elseif (!(in_array($ev['objectId'], $eventId))) {
                        $eventId[$i] = $ev['objectId'];
                        $events[$i] = $ev;
                    }
                }
                $i++;
            }
            $data->username = $session_data['username'];
            $data->role = $session_data['role'];
            $data->id = $session_data['id'];
            $data->function_name = "Deleted Events";
            $data->info = $events; //json_decode(json_encode($temp), true);
            $this->load->view('default/events/deletedlist', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function downloadMeta($id, $type) {
        ob_clean();
        $data = new stdClass();
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
        $temp_activity = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Post",
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
        $event = json_decode(json_encode($temp_event), true);
        $data->eventComment = json_decode(json_encode($temp), true);
        $data->eventActivity = json_decode(json_encode($temp_activity), true);
        $data->event = $event; // json_decode(json_encode($temp_event), true);
        $data->special = json_decode(json_encode($temp_special), true);
        if ($type == 'pdf') {
            $this->load->library('Pdf');
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->preferences($pdf);
            $pdf->AddPage();
            $html = $this->load->view('default/events/pdfDownloadMeta', $data, true);

// output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
            $name = $event[0]['eventname'];
            $pdf->Output("$name.pdf", 'I');
            ob_end_clean();
        } else if ($type == 'xls') {
            $name = $event[0]['eventname'];
            $filename = 'Data-' . Date('YmdGis') . "-Event.$type";
//            echo $filename;exit;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=" . $filename);
            echo $this->load->view('default/events/pdfDownloadMeta', $data, true);
        } else {
            $name = $event[0]['eventname'];
            $eventActivity = array();
            $posts = json_decode(json_encode($temp_activity), true);
            $eventActivity[] = 'Creator,' . $event[0]['username'];
            $eventActivity[] = 'Data Created,' . date('Y-m-d', strtotime($event[0]['createdAt']));
            $eventActivity[] = 'Time Created,' . date('g:i A', strtotime($event[0]['createdAt']));
            if (isset($event[0]['commenters'])) {
                $eventActivity[] = 'Number of Participants,' . count($event[0]['commenters']);
            }
            $eventActivity[] = 'Tagged Friends, ' . count(implode(",", $event[0]['TagFriends']));
            $eventActivity[] = 'Number of Activity Sheets,' . count($eventActivity);
            $eventActivity[] = 'Title of Activity Sheet,' . $event[0]['eventname'];
            $eventActivity[] = 'Date,Time,Title,Location,Description';
            foreach ($posts as $post) {
                $eventActivity[] = date('Y-m-d', strtotime($post['createdAt'])) . ',' . date('g:i A', strtotime($post['createdAt'])) . ',' . $post['title'] . ',' . $post['countryLatLong'] . ',' . $post['description'];
            }
            header('Content-Type: application/excel');
            header('Content-Disposition: attachment; filename="' . $name . '.csv"');

            $fp = fopen('php://output', 'w');
            foreach ($eventActivity as $line) {
                $val = explode(",", $line);
                fputcsv($fp, $val);
            }
            fclose($fp);
        }
    }

    public function eventDeleteAuto() {
        
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
            $temp_activity = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Post",
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
            $data->eventComment = json_decode(json_encode($temp), true);
            $data->eventActivity = json_decode(json_encode($temp_activity), true);
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
