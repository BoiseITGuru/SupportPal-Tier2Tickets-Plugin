<?php

 $api->version('v1', ['namespace' => 'App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api'], function ($api) {

    //  $api->post('plugin/helpdeskbuttons/api/v2/tickets', [
    //      'as'   => 'api.user.settings',
    //      function () {
    //  	   return 'Hello World';
   	//  }
    //  ]);

    $api->post('plugin/helpdeskbuttons/api/v2/tickets', [
        'as'   => 'plugin.helpdeskbuttons.api.ticket.create',
        'uses' => 'TicketController@createTicket'
    ]);

    $api->post('plugin/helpdeskbuttons/api/v2/tickets/{ticketId}/notes', [
        'as'   => 'plugin.helpdeskbuttons.api.ticket.create',
        'uses' => 'TicketController@addNote'
    ]);

    $api->get('plugin/helpdeskbuttons/api/v2/groups', [
        'as'   => 'plugin.helpdeskbuttons.api.get.departments',
        'uses' => 'DepartmentController@getDepartments'
    ]);

    $api->get('plugin/helpdeskbuttons/api/v2/agents', [
        'as'   => 'plugin.helpdeskbuttons.api.get.operators',
        'uses' => 'UsersController@getOperators'
    ]);

    $api->get('plugin/helpdeskbuttons/api/v2/contacts', [
        'as'   => 'plugin.helpdeskbuttons.api.get.contacts',
        'uses' => 'UsersController@getContacts'
    ]);

});
