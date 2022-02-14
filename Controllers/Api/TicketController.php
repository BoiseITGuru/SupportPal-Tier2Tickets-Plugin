<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Modules\Core\Controllers\Mailer\Mailer;
use App\Modules\Core\Models\ActivityLog;
use App\Modules\Ticket\Models\Ticket;
use App\Modules\Ticket\Models\DepartmentEmail;
use App\Modules\Ticket\Models\Message;
use App\Modules\Ticket\Events\TicketCreated;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserOrganisationDomain;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Tickets\StoreRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function call_user_func;
use function count;
use function mb_strtolower;
use function mb_strimwidth;
use function trans;

class TicketController extends BaseApiController
{
    /**
     * TicketController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function createTicket(StoreRequest $request)
    {
        /**
         * TO DO
         * Look up department ticket number format
         * Map Priorites
         * Map Status
         * Support Email Aliases (Need to create plugin first)
         */

        // //save POST Data to file for Dev review
        file_put_contents('/var/www/supportpal/app/Plugins/HelpdeskButtonsAPIEmulator/Controllers/Api/json_array.json', json_encode($request->input()));


        // //Get POST Data
        // $email = $request->input('email');
        // $subject = $request->input('subject');
        // $status = $request->input('status');
        // $priority = $request->input('priority');
        // $description = $request->input('description');
        // $brand_id = $request->input('custom_fields.brand');
        // $department_id = $request->input('custom_fields.department');
        // $source = $request->input('source');

        // //Check if user exists
        // $whereCondition = [
        //     ['email', '=', $email],
        //     ['brand_id', '=', $brand_id]
        // ];
        // $user = User::where($whereCondition)->first();

        // if (!$user) {
        //     //Get org by domain if exists
        //     $domain = substr($email, strpos($email, '@') + 1);
        //     $org = UserOrganisationDomain::where('domain', $domain)->first();

        //     //Create User
        //     if ($org) {
        //         $user = User::create([
        //             'brand_id'          => $brand_id,
        //             'email'             => $email,
        //             'organisation_id'   => $org->organisation_id
        //         ]);
        //     } else {
        //         $user = User::create([
        //             'brand_id'          => $brand_id,
        //             'email'             => $email
        //         ]);
        //     }
        // }

        // //Get Department Defualt Email
        // $department_email = DepartmentEmail::where('department_id', $department_id)->first();
        // $department_email_id = $department_email->id;

        // //Create Ticket
        // $digits = 7;
        // $ticket = Ticket::create([
        //     'number'                => rand(pow(10, $digits-1), pow(10, $digits)-1),
        //     'channel_id'            => 3,
        //     'user_id'               => $user->id,
        //     'department_id'         => $department_id,
        //     'department_email_id'   => $department_email_id,
        //     'brand_id'              => $brand_id,
        //     'status_id'             => $status,
        //     'priority_id'           => $priority,
        //     'subject'               => $subject,
        //     'text'                  => $description
        // ]);

        // //Check if users name exist and assign to email if not
        // if ($ticket->user->formatted_name) {
        //     $user_name = $ticket->user->formatted_name;
        // } else {
        //     $user_name = $user->email;
        // }

        // //Create ticket message
        // Message::create([
        //     'ticket_id'     => $ticket->id,
        //     'channel_id'    => 3,
        //     'user_id'       => $user->id,
        //     'user_name'     => $user_name,
        //     'by'            => 1,
        //     'type'          => 0,
        //     'excerpt'       => mb_strimwidth($ticket->subject, 0, 20, "..."),
        //     'text'          => $description,
        //     'purified_text' => $description
        // ]);

        // event(new TicketCreated($ticket));

        // //send ticket created email
        // Mailer::sendTicketMail(3,$ticket);

        // return $ticket;
    }
}
