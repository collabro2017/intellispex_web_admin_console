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

require_once dirname(__FILE__) . '/../libraries/zendesk.php';

function create_ticket($z_subject, $z_description, $z_recipient, $z_name, $z_requester)
{
    $zendesk = new zendesk(
        config_item('z_APIKEY'),
        config_item('z_USER'),
        config_item('z_SUBDOMAIN')
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