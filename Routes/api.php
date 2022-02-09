<?php

 $api->version('v1', [ ], function ($api) {

     $api->post('plugin/helpdeskbuttons/api/v2/tickets', [
         'as'   => 'api.user.settings',
         function () {
     	   return 'Hello World';
   	 }
     ]);

});
