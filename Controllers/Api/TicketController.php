<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Modules\Core\Models\ActivityLog;
use App\Modules\Ticket\Models\Ticket;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Tickets\StoreRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function call_user_func;
use function count;
use function mb_strtolower;
use function trans;

class TicketController extends BaseApiController
{
    /**
     * TimeLogController constructor.
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
        // /** @var Ticket $ticket */
        // $ticket = Ticket::findOrFail($request->input('ticket_id'));

        // $inputs = ['ticket_id', 'user_id', 'time', 'description', 'billable'];

        // $record = new TimeLog;
        // $record->fill($request->all($inputs));
        // $record->status = 2;
        // $record->created_at = $request->input('start_time');
        // $record->save();

        Ticket::create([
            'user_email'   => $request->input('email'),
            'department_id'   => 1,
            'brand_id'   => 1,
            'status'       => $request->input('status'),
            'priority'     => $request->input('priority'),
            'subject'      => $request->input('subject'),
            'text'         => $request->input('description')
        ]);

        // // Update time logged on ticket
        // $this->updateTicketTime($ticket->id);

        // return $this->response->array([
        //     'status'  => 'success',
        //     'message' => trans('messages.success_created', [
        //         'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
        //     ]),
        //     'data'    => $record->loadMissing(['ticket', 'user'])
        // ]);

        return ;
    }
}
