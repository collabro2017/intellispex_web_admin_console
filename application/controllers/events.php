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
            if (base_url() == 'http://test.intellispex.com/') {
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

            if ($this->input->post('submit')) {
                if (isset($_FILES['postImage'])) {
                    $eventname = $this->input->post('eventname');

                    $name = $_FILES['postImage']['name'];
                    $type = $_FILES['postImage']['type'];
                    $file_base64 = file_get_contents($_FILES['postImage']['tmp_name']);

                    $extension = pathinfo($_FILES['postImage']['tmp_name']);
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $extension = end($ext);
                    if (isset($extension)) {
                        $name = strtolower(str_replace(' ', '-', $eventname)) . "." . $extension;


                        $temp = $this->parserestclient->file(
                                array(
                                    "object" => $file_base64,
                                    "content-type" => $type,
                                    "file-name" => $name
                                )
                        );
                        $image = json_decode(json_encode($temp));
                    }
                    $description = $this->input->post('description');
                    $company = $this->input->post('company');

                    $hourStart = $this->input->post('hourStart');
                    $secondStart = $this->input->post('secondStart');
                    $ampmStart = $this->input->post('ampmStart');
                    $startTime = $hourStart . ":" . $secondStart . " " . $ampmStart;

                    $hourEnd = $this->input->post('hourEnd');
                    $secondEnd = $this->input->post('secondEnd');
                    $ampmEnd = $this->input->post('ampmEnd');
                    $endTime = $hourEnd . ":" . $secondEnd . " " . $ampmEnd;

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
                        if (isset($user[0]->username)) {
                            $user_name = $user[0]->username;
                        } else {
                            $user_name = '';
                        }
                    } else {
                        $user_name = '';
                    }
                    $date = date(DateTime::ISO8601, time());
                    if (isset($image->name)) {
                        $image_name = $image->name;
                        $image_url = $image->url;
                        $response = $this->parserestclient->create
                                (
                                array
                                    (
                                    "objectId" => "Event",
                                    'object' => ['eventname' => "$eventname", 'company' => "$company", 'startTime' => "$startTime", 'endTime' => "$endTime", 'description' => "$description", 'country' => "$country", 'username' => "$user_name",
                                        'postType' => "image",
                                        'openStatus' => 1,
                                        'event_type' => 'Web-Console',
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
                                        ], 'completedBy' => [
                                            "__type" => "Pointer",
                                            "className" => "_User",
                                            "objectId" => "$user_id"
                                        ]]
                                )
                        );
                    } else {
                        $response = $this->parserestclient->create
                                (
                                array
                                    (
                                    "objectId" => "Event",
                                    'object' => ['eventname' => "$eventname", 'company' => "$company", 'startTime' => "$startTime", 'endTime' => "$endTime", 'description' => "$description", 'country' => "$country", 'username' => "$user_name",
                                        'postType' => "image",
                                        'openStatus' => 1,
                                        'event_type' => 'Web-Console',
                                        'createdAt' => [
                                            "__type" => "Date",
                                            "iso" => $date,
                                        ], 'user' => [
                                            "__type" => "Pointer",
                                            "className" => "_User",
                                            "objectId" => "$user_id"
                                        ], 'completedBy' => [
                                            "__type" => "Pointer",
                                            "className" => "_User",
                                            "objectId" => "$user_id"
                                        ]]
                                )
                        );
                    }
                    if (isset($response->objectId)) {
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
        $contents = file(base_url() . 'public/bad_words.txt');
        $bad_words = array();
        foreach ($contents as $line) {
            $bad_words[] = strtolower($line);
        }
//        echo '<pre>';
//            $line = 'test';
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Event",
                    'query' => '{"deletedAt":null,"description":{"$ne": "" }}'
                )
        );
        $results = array();
        $i = 0;
        $events = json_decode(json_encode($temp), true);
        if (isset($events) && count($events) > 0) {
            foreach ($events as $event) {
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
                    $results[$i]['user_id'] = $commenter['objectId'];
                    $results[$i]['post_id'] = '';
                    $i++;
                }
            }
        }
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Post",
                    "query" => '{"description":{"$ne": "" }}',
                    'order' => 'postOrder'
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
                        $results[$i]['post_id'] = $post['objectId'];
                        $i++;
                    }
                }
            }
        }
//        }
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
                        'query' => '{"deletedAt":null,"openStatus":1}',
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
            if (base_url() == 'http://intellispex.com/' || base_url() == 'http://localhost/icymi/') {
                $regular_user = 'Di56R0ITXB';
            } else {
                $regular_user = 'XVr1sAmAQl';
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
            $userArr[] = $session_data['mongodb_id'];
            if (!$day || is_null($day) || $day == "") {
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            'query' => '{"deletedAt":null, "TagFriends":{"$in":' . json_encode($userArr, true) . '}}',
                            'order' => $asc,
                            'limit' => '10000000',
                        )
                );
            } else {
                $date = date('Y-m-d', strtotime('-' . $day . ' days'));
                $date = date(DateTime::ISO8601, strtotime($date));
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            'query' => '{"deletedAt":null,"createdAt":{"$gte":{"__type":"Date","iso":"' . $date . '"}}, "TagFriends":{"$in":' . json_encode($userArr, true) . '}}',
                            'order' => $asc,
                            'limit' => '10000000',
                        )
                );
            }
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
                                'query' => '{"deletedAt":null ,"user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"}}',
                                'order' => $asc,
                                'limit' => 1000000
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

                $date = date('Y-m-d', strtotime('-' . $day . ' days'));
                $date = date(DateTime::ISO8601, strtotime($date));
                //$date = "2017-06-01T00:00:00.000Z";
                foreach ($associated_user as $user) {
                    $temp = $this->parserestclient->query
                            (
                            array
                                (
                                "objectId" => "Event",
                                //'query'=>'{"deletedAt":null, "createdAt":{"$gt":"'.$date.'"}}',
                                'query' => '{"deletedAt":null,"createdAt":{"$gte":{"__type":"Date","iso":"' . $date . '"}},"user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"}}',
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
            $data->page = 'events/index';
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
                                        "query" => '{"deletedAt":null,"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                        'order' => '-createdAt'
                                    )
                            ), true));
            $data->event_post = json_decode(json_encode($this->parserestclient->query
                                    (
                                    array
                                        (
                                        "objectId" => "Post",
                                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                        'order' => 'postOrder'
                                    )
                            ), true));
            if (base_url() == 'http://test.intellispex.com/') {
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
            $this->load->view('default/events/event', $data);
        } else {
            $this->load->view('default/include/manage/v_login');
        }
    }

    public function eventdelete() {
        $deletelist = $this->input->post('deletelist');
        $data = date('Y-m-d');
        foreach ($deletelist as $val) {
            //$data = array('deletedAt' => '2017-07-03T00:00:00','objectId'=>$val);
            $response = $this->parserestclient->update
                    (
                    array
                        (
                        "objectId" => "Event",
                        'object' => ['deletedAt' => "$data"],
                        'where' => $val
                    )
            );
        }
        exit;
    }

    public function reportEvent() {
        $session_data = $this->session->userdata('logged_in');
        $eventId = $this->input->post('deletelist');
        $user[] = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        $response = $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Event",
                    'object' => ['eventBadgeFlag' => [
                            "__op" => "Add",
                            "objects" => $user
                        ],
                        'updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ]],
                    'where' => $eventId
                )
        );
    }

    public function reportPost() {
        $session_data = $this->session->userdata('logged_in');
        $postId = $this->input->post('postId');
        $user[] = $session_data['mongodb_id'];
        $date = date(DateTime::ISO8601, time());
        $response = $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "EventPost",
                    'object' => ['usersBadgeFlag' => [
                            "__op" => "Add",
                            "objects" => $user
                        ],
                        'updatedAt' => [
                            "__type" => "Date",
                            "iso" => $date,
                        ]],
                    'where' => $postId
                )
        );
    }

    public function eventRestore() {
        $deleteId = $this->input->post('deleteId');
        $data = date('Y-m-d');
        $this->parserestclient->update
                (
                array
                    (
                    "objectId" => "Event",
                    'object' => ['deletedAt' => "", 'openStatus' => 1],
                    'where' => $deleteId
                )
        );
    }

    public function deleteOldEvent() {
        $events = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Event",
                                    "query" => '{"deletedAt":{"$ne":null},"openStatus":0}'
                                )
                        ), true));
        foreach ($events as $event) {
            $d1 = date('Y-m-d');
            $d2 = $event->deletedAt;

            $leftmonth = (int) abs((strtotime($d1) - strtotime($d2)) / (60 * 60 * 24 * 30));
            if ($leftmonth > 12) {
                $this->parserestclient->delete
                        (
                        array
                            (
                            "className" => "Event",
                            'objectId' => $event->objectId
                        )
                );
            }
        }
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
        $config['smtp_user'] = "jimmy.song1989@gmail.com";
        $config['smtp_pass'] = "Test@123";

        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);
        $ci->email->from($session_data['username']);
        $ci->email->to($user->email);
        $ci->email->reply_to($session_data['username']);
        $ci->email->subject('Warning Message for prohibited text of your post.');
        $message = 'Hi ' . $user->username . ", <br/>";
        $message .= 'This is to notify that your post is having some prohibited words. Please becareful this is final warning. <br/>Next time we will take serious action against you. <br/><br/>';
        $message .= 'Regards,<br/>';
        $message .= 'IntelliSpeX';
        $ci->email->message($message);
    }

    public function comments() {
        $comment_id = $this->input->post('commentId');
        $event = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "EventComment",
                                    "query" => '{"deletedAt":null,"objectId": "' . $comment_id . '"}',
                                    'order' => '-createdAt'
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
                                    "query" => '{"deletedAt":null,"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                    'order' => '-createdAt'
                                )
                        ), true));

        $data->event_post = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Post",
                                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event_id . '"}}',
                                    'order' => 'postOrder'
                                )
                        ), true));

        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('Intellispex');
        $pdf->SetTitle($event->eventname);
        $pdf->SetSubject($event->eventname);

        $pdf->preferences($pdf);
        $pdf->AddPage();
        error_reporting(0);

        if ($download == 'full') {
            $html = $this->load->view('default/events/fullResolution', $data, true);
        } else {
            $html = $this->load->view('default/events/pdfDownload', $data, true);
        }
// output the HTML content

        $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//            $pdf->SetY($event[0]['eventname']);
//            $pdf->Cell(0, 10, $event[0]['eventname'], 0, 0, 'C');

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setPrintFooter(true);
        $_SESSION['RightText'] = $event->eventname;
        $_SESSION['CenterText'] = date('Y-m-d', strtotime($event->createdAt));

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("$event->eventname.pdf", 'I');
        ob_end_clean();
    }
//        $files = array(
//            'https://intellispexbucket.s3.amazonaws.com/a96756bf9f9acbdf443dd69721a24831_image.jpg',
//            'https://intellispexbucket.s3.amazonaws.com/ce660a44ba2517c7ca6e7be7b4294aac_image.jpg',
//        );
//# create new zip object
//
//# create a temp file & open it
//        $zip = new ZipArchive();
//	$zip_file1 = FCPATH . '/public/filename.zip';
//        if( $zip->open($zip_file1, ZipArchive::CREATE) === true){
//
//    # loop through each file
//            foreach ($files as $file) {
//                # download file
//    //            $download_file = file_get_contents($file);
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, $file);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                $data = curl_exec ($ch);
//                curl_close ($ch);
//
//    //print_r($download_file);
//                #add it to the zip
//                $zip->addFromString(basename($file), $data);
//            }
//
//    # close zip
//            $zip->close();
//        }
//# send the file to the browser as a download
////        header('Content-disposition: attachment; filename="my-file.zip"');
////        header('Content-type: application/zip');
////        readfile($tmp_file);
////        unlink($tmp_file);
//        header('Content-type: application/zip');
//	header('Content-Disposition: attachment; filename="'.basename($zip_file1).'"');
//	header("Content-length: " . filesize($zip_file1));
//	header("Pragma: no-cache");
//	header("Expires: 0");
//        ob_clean();
//	flush();
//        readfile($zip_file1);
//        unlink($zip_file1);
//        exit;
    
    private function _fopenLocal($filename, $mode) {
        if (strpos($filename, '://') === false) {
                $filename = 'file://'.$filename;
        } elseif (stream_is_local($filename) !== true) {
                return false;
        }
        return fopen($filename, $mode);
    }
    private function _download_file($id,$type){
        error_reporting(0);
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "EventComment",
                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}',
                    'order' => '-createdAt'
                )
        );
        $temp_activity = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Post",
                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}'
                )
        );
        $temp_event = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Event",
                    'query' => '{"objectId":"' . $id . '"}'
                )
        );
        $temp_special = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "Event",
                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '","__op":"Add","objects":["totalCount","location"]}}'
                )
        );
        $event = json_decode(json_encode($temp_event), true);
        $data->eventComment = json_decode(json_encode($temp), true);
        $data->eventActivity = json_decode(json_encode($temp_activity), true);
        $data->event = $event; // json_decode(json_encode($temp_event), true);
        $data->special = json_decode(json_encode($temp_special), true);
        $posts = json_decode(json_encode($temp_activity), true);
        $files_arr = array();
        
        
        if ($type == 'pdf') {
            $this->load->library('Pdf');
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->preferences($pdf);
            $pdf->AddPage();
            $html = $this->load->view('default/events/pdfDownloadMeta', $data, true);

// output the HTML content

            $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->setPrintFooter(true);
            $_SESSION['RightText'] = $event[0]['eventname'];
            $_SESSION['CenterText'] = date('Y-m-d', strtotime($event[0]['createdAt']));

            $pdf->writeHTML($html, true, false, true, false, '');

            $name = $event[0]['eventname'];
            $filename = FCPATH . '/public/'.$name.'.pdf';
            $pdf->Output($filename, 'F');
            $files_arr[] = $filename;
            $files_arr[basename($filename)] = file_get_contents($filename);
        } else if ($type == 'xls') {
            $name = $event[0]['eventname'];
            $filename = FCPATH . '/public/'.'Data-' . Date('YmdGis') . "-Event.$type";
//            echo $filename;exit;
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=" . $filename);
            $html =  $this->load->view('default/events/pdfDownloadMeta', $data, true);
            $f = $this->_fopenLocal($filename , 'wb');
            
            fwrite($f, $html);
            fclose($f);
            $files_arr[basename($filename)] = file_get_contents($filename);
        } else {
            $name = $event[0]['eventname'];
            $eventActivity = array();
            $filename = FCPATH . '/public/'.$name.'.csv';
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

            $fp = $this->_fopenLocal($filename , 'wb');
            foreach ($eventActivity as $line) {
                $val = explode(",", $line);
                fputcsv($fp, $val);
            }
            fclose($fp);
            
            $files_arr[basename($filename)] = file_get_contents($filename);
        }
        return $files_arr;
        
    }
    public function download_metadata() {
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
            $event_zip_files = array();
            if(isset($_POST['events'])){
                $events  = $_POST['events'];
                foreach ($events as $event){
                    $files  = $this->_download_file($event,$_POST['select_meta_file_type']);
                    $zip = new ZipArchive();
                    $temp_event = $this->parserestclient->query(array(
                        "objectId" => "Event",
                        'query' => '{"objectId":"' . $event . '"}'
                    ));
                    $eventt = json_decode(json_encode($temp_event), true);
                    
                    $zip_file = FCPATH . '/public/'.str_replace(" ",'_', htmlentities($eventt[0]['eventname'])).'.zip';
                    if( $zip->open($zip_file, ZipArchive::CREATE) === true){
                        foreach ($files as $name=>$file){
                            $zip->addFromString($name, $file);
                        }
                        $temp_activity = $this->parserestclient->query(array(
                            "objectId" => "Post",
                            "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $event . '"}}'
                        ));
                        
                        $posts = json_decode(json_encode($temp_activity), true); 
                        $post_file_types = $_POST['fileTypes'];
                        $post_files = '';
                        foreach ($posts as $post){
                            if(isset($post['postFile']['url'])){
                                $file = $post['postFile'];
                                $name = explode('.', basename($file["url"]));
                                $extension = $name['1'];
                                $type = '';
                                if ($extension == 'mp4' || $extension == 'ogg') {
                                    $type = 'videos';
                                }elseif ($extension == 'mp3' || $extension == 'ogg' || $extension == 'wav') {
                                    $type = 'audios';
                                }elseif ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
                                    $type = 'images';
                                }
                                $url = $post['postFile']['url'];
                                foreach ($post_file_types as $fileType){
                                    if($fileType == $type){
                                        $post_files = $file["url"];
                                    }else{
                                        $post_files = '';
                                    }
                                    if($post_files != ''){
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $post_files);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        $data_file = curl_exec ($ch);
                                        curl_close ($ch);
                                        $zip->addFromString(basename($post_files), $data_file);
                                    }
                                }
                            }
                        }
                        $zip->close();
//                        $event_zip_files[] = $zip_file;
                        
                        header('Content-type: application/zip');
                        header('Content-Disposition: attachment; filename="'.basename($zip_file).'"');
                        header("Content-length: " . filesize($zip_file));
                        header("Pragma: no-cache");
                        header("Expires: 0");
                        ob_clean();
                        flush();
                        readfile($zip_file);
                        unlink($zip_file);
                        exit;
                    }
                }
//                $zip_file = FCPATH . '/public/event_zip_files.zip';
//                
//                $zip = new ZipArchive();
//                    
//                if( $zip->open($zip_file, ZipArchive::CREATE) === true){
//                    foreach ($event_zip_files as $files){
//                        $zip->addFromString(basename($files), file_get_contents($files));
//                    }
//                    $zip->close();
//                }
            }else{
                $data->function_name = "VIEW OR EDIT GLOBAL EVENT LIST";
                if (base_url() == 'http://intellispex.com/' || base_url() == 'http://localhost/icymi/') {
                    $regular_user = 'Di56R0ITXB';
                } else {
                    $regular_user = 'XVr1sAmAQl';
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
                $userArr[] = $session_data['mongodb_id'];
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            'query' => '{"deletedAt":null, "TagFriends":{"$in":' . json_encode($userArr, true) . '}}',
                            'order' => $asc,
                            'limit' => '10000000',
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

                foreach ($associated_user as $user) {
                    $temp = $this->parserestclient->query
                            (
                            array
                                (
                                "objectId" => "Event",
                                'query' => '{"deletedAt":null ,"user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"}}',
                                'order' => $asc,
                                'limit' => 1000000
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

                $data->page = 'events/index';
                $data->info = $events; //json_decode(json_encode($temp), true);
                $this->load->view('default/events/download', $data);
            }
        } else {
            $this->load->view('default/include/manage/v_login');
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
        redirect('/events/event/' . $targetEvent, 'refresh');
    }

    public function add_post_comment($post_id) {
        $date = date(DateTime::ISO8601, time());
        $Comments = $this->input->post('Comments');
        $Commenter = $this->input->post('Commenter');
        $post_id = $this->input->post('postIds');
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
            if (base_url() == 'http://test.intellispex.com/') {
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
            $userArr[] = $session_data['mongodb_id'];
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
            foreach ($associated_user as $user) {
                $temp = $this->parserestclient->query
                        (
                        array
                            (
                            "objectId" => "Event",
                            'query' => '{"deletedAt":{"$ne":null},"user":{"__type":"Pointer","className":"_User","objectId":"' . $user['objectId'] . '"} }'
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
                    "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}',
                    'order' => '-createdAt'
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

            $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//            $pdf->SetY($event[0]['eventname']);
//            $pdf->Cell(0, 10, $event[0]['eventname'], 0, 0, 'C');

            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->setPrintFooter(true);
            $_SESSION['RightText'] = $event[0]['eventname'];
            $_SESSION['CenterText'] = date('Y-m-d', strtotime($event[0]['createdAt']));

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
                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}',
                        'order' => '-createdAt'
                    )
            );
            $temp_activity = $this->parserestclient->query
                    (
                    array
                        (
                        "objectId" => "Post",
                        //'query'=>'{"deletedAt":null}',	
                        //'query'=>'{"targetEvent":"'.$id.'"}'
                        "query" => '{"targetEvent":{"__type":"Pointer","className":"Event","objectId":"' . $id . '"}}',
                        'order' => 'postOrder'
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
