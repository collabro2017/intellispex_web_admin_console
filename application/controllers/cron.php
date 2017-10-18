<?php

ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
include_once('CI_Controller_EX.php');

class cron extends CI_Controller_EX {

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

    // Run every day mid night. 
    public function flaggedContent() {
        $this->load->model('m_client');
        $this->load->model('m_user');
        $event_id = array();
        $event_post_id = array();
        $result = $this->M_user->getUserByType(1);
        $temp = $this->parserestclient->query
                (
                array
                    (
                    "objectId" => "_User",
                    'query' => '{"email":"' . strtolower($result->username) . '"}',
                )
        );
        $users = json_decode(json_encode($temp), true);
        $current_user = $users[0];
        $user = $current_user['objectId'];
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
                if (isset($event['user'])) {
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
                        // Report Content
                        $date = date(DateTime::ISO8601, time());
                        $eventId = $event['objectId'];
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
                    $postId = $post['objectId'];
                    $targetEvent = $post['targetEvent'];
                    $eventId = $targetEvent['objectId'];
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
                        $commenter = $post['user'];
                        $user_details = $this->parserestclient->query(array(
                            "objectId" => "_User",
                            'query' => '{"deletedAt":null,"objectId":"' . $commenter['objectId'] . '"}',
                                )
                        );
                        // Report Content
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

                        $i++;
                    }
                }
            }
        }
    }

    // Run This Job Monthly
    public function deleteOldEvent() {
        $events = json_decode(json_encode($this->parserestclient->query
                                (
                                array
                                    (
                                    "objectId" => "Event",
                                    "query" => '{"deletedAt":{"$ne":null}}'
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

}

?>
