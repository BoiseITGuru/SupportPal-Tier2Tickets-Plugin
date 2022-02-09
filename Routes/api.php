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

});
