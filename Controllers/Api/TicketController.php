<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Modules\Core\Models\ActivityLog;
use App\Modules\Ticket\Models\Ticket;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserOrganisationDomain;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Tickets\StoreRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GuzzleHttp\Client;

use function call_user_func;
use function count;
use function mb_strtolower;
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
         * Send Ticket Created Email
         * Look up department ticket number format
         * Look up department email id
         * Save description as message
         * Map Priorites
         * Map Status
         * Support Email Aliases (Need to create plugin first)
         */



        //Get POST Data
        $email = $request->input('email');
        $subject = $request->input('subject');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $description = $request->input('description');
        $brand_id = $request->input('custom_fields.brand');
        $department_id = $request->input('custom_fields.department');
        $source = $request->input('source');

        //Check if user exists
        $whereCondition = [
            ['email', '=', $email],
            ['brand_id', '=', $brand_id]
        ];
        $user = User::where($whereCondition)->first();

        if (!$user) {
            //Get org by domain if exists
            $domain = substr($email, strpos($email, '@') + 1);
            $org = UserOrganisationDomain::where('domain', $domain)->first();

            //Create User
            if ($org) {
                $user = User::create([
                    'brand_id'          => $brand_id,
                    'email'             => $email,
                    'organisation_id'   => $org->organisation_id
                ]);
            } else {
                $user = User::create([
                    'brand_id'          => $brand_id,
                    'email'             => $email
                ]);
            }
        }


        //Create Ticket
        $digits = 7;
        $ticket = Ticket::create([
            'number'            => rand(pow(10, $digits-1), pow(10, $digits)-1),
            'channel_id'        => 3,
            'user_id'           => $user->id,
            'department_id'     => $department_id,
            'brand_id'          => $brand_id,
            'status_id'         => $status,
            'priority_id'       => $priority,
            'subject'           => $subject,
            'text'              => $description
        ]);

        return $ticket;

        // return $this->response->array([
        //     'status'  => 'success',
        //     'message' => trans('messages.success_created', [
        //         'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
        //     ]),
        //     'data'    => $record->loadMissing(['ticket', 'user'])
        // ]);
    }
}
