<?php

/**
 * This function creates a ticket in zendesk
 * @param string $z_subject     Subject line for the ticket
 * @param string $z_description Description for the ticket
 * @param string $z_recipient   Recipient email address
 * @param string $z_name        Name of the requester
 * @param string $z_requester   Requester email address
 * @return int                  Ticket ID
 */
//require_once dirname(__FILE__) . '/../vendor/autoload.php';

require( FCPATH . "/vendor/autoload.php");

use Zendesk\API\HttpClient as ZendeskAPI;

function create_ticket_with_image($file, $type, $file_name, $extension, $reciever_name, $subject, $body, $reciever_email) {
    $subdomain = config_item('z_SUBDOMAIN');
    $username = config_item('z_USER');
    $token = config_item('z_APIKEY');

    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

    try {
        // Upload file
        $attachment = $client->attachments()->upload([
            'file' => $file,
            'type' => $type,
            'name' => $file_name . "." . $extension
        ]);
        // Create a new ticket with attachment
        $newTicket = $client->tickets()->create([
            'type' => 'problem',
            'tags' => array('intellispex', 'support', $reciever_name),
            'subject' => $subject,
            'comment' => array(
                'body' => $body,
                'uploads' => [$attachment->upload->token]
            ),
            'requester' => array(
                'locale_id' => '1',
                'name' => $reciever_name,
                'email' => $reciever_email,
            ),
            'priority' => 'normal',
        ]);

        // Show result
    } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
    echo $e->getMessage().'</br>';exit;
    }
}

function create_ticker_simple($requester_name,$requester_email,$subject,$body) {
    $subdomain = config_item('z_SUBDOMAIN');
    $username = config_item('z_USER');
    $token = config_item('z_APIKEY');

    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

    try {
        // Create a new ticket
        $newTicket = $client->tickets()->create([
            'type' => 'problem',
            'tags' => array('intellispex', 'support', $username),
            'subject' => $subject,
            'comment' => array(
                'body' => $body
            ),
            'requester' => array(
                'locale_id' => '1',
                'name' => $requester_name,
                'email' => $requester_email,
            ),
            'priority' => 'normal',
        ]);
    } catch (\Zendesk\API\Exceptions\ApiResponseException $e) {
        
    }
}

function create_ticket($z_subject, $z_description, $z_recipient, $z_name, $z_requester) {
    $zendesk = new zendesk(
            config_item('z_APIKEY'), config_item('z_USER'), config_item('z_SUBDOMAIN')
    );

    $arr = array(
        "z_subject" => $z_subject,
        "z_description" => $z_description,
        "z_recipient" => $z_recipient,
        "z_name" => $z_name,
        "z_requester" => $z_requester
    );

    $create = json_encode(array('ticket' => array('subject' => $arr['z_subject'], 'description' => $arr['z_description'], 'requester' => array('name' => $arr['z_name'], 'email' => $arr['z_requester']))), JSON_FORCE_OBJECT);

    $data = $zendesk->call("/tickets", $create, "POST");

    return $data->ticket->id;
}
