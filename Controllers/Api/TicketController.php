<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Modules\Core\Models\ActivityLog;
use App\Modules\Ticket\Models\Ticket;
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
     * @param IndexRequest $request
     * @return mixed
     */
    public function index(IndexRequest $request)
    {
        $records = $this->indexResource($request);

        if ($request->has('ticket_id')) {
            $records->where('ticket_id', $request->input('ticket_id'));
        }

        if ($request->has('user_id')) {
            $records->where('user_id', $request->input('user_id'));
        }

        if ($request->has('status')) {
            $records->where('status', $request->input('status'));
        }

        if ($request->has('billable')) {
            $records->where('billable', $request->input('billable'));
        }

        if ($request->has('start_date')) {
            $records->where('created_at', '>=', $request->input('start_date'));
        }

        if ($request->has('end_date')) {
            $records->where('created_at', '<=', $request->input('end_date'));
        }

        return $this->getIndex($records);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function show(int $id)
    {
        try {
            // Find item
            $record = call_user_func([$this->getClass(), 'findOrFail'], $id);
        } catch (ModelNotFoundException $e) {
            // Model not found
            $this->response->errorNotFound(trans('messages.error_notfound', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]));

            return;
        }

        return $this->response->array([
            'status'  => 'success',
            'message' => null,
            'data'    => $record->load(['ticket', 'user'])
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        /** @var Ticket $ticket */
        $ticket = Ticket::findOrFail($request->input('ticket_id'));

        $inputs = ['ticket_id', 'user_id', 'time', 'description', 'billable'];

        $record = new TimeLog;
        $record->fill($request->all($inputs));
        $record->status = 2;
        $record->created_at = $request->input('start_time');
        $record->save();

        ActivityLog::addEntry([
            'brand_id'   => $ticket->brand_id,
            'type'       => ActivityLog::API,
            'rel_name'   => $ticket->number,
            'rel_id'     => $ticket->id,
            'rel_route'  => 'ticket.operator.ticket.show',
            'section'    => 'ticket.ticket',
            'event_text' => 'Stored a time entry on ticket #' . $ticket->number . '.',
        ]);

        // Update time logged on ticket
        $this->updateTicketTime($ticket->id);

        return $this->response->array([
            'status'  => 'success',
            'message' => trans('messages.success_created', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]),
            'data'    => $record->loadMissing(['ticket', 'user'])
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            // Get record
            $record = call_user_func([$this->getClass(), 'findOrFail'], $id);
        } catch (ModelNotFoundException $e) {
            // Model not found
            $this->response->errorNotFound(trans('messages.error_notfound', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]));

            return;
        }

        if ($request->has('user_id')) {
            $record->user_id = $request->input('user_id');
        }

        if ($request->has('time')) {
            $record->time = $request->input('time');
        }

        if ($request->has('description')) {
            $record->description = $request->input('description');
        }

        if ($request->has('billable')) {
            $record->billable = $request->input('billable');
        }

        if ($request->has('start_time')) {
            $record->created_at = $request->input('start_time');
        }

        $ticket = $record->ticket;

        if (count($record->getDirty()) && $record->save()) {
            ActivityLog::addEntry([
                'brand_id'   => $ticket->brand_id,
                'type'       => ActivityLog::API,
                'rel_name'   => $ticket->number,
                'rel_id'     => $ticket->id,
                'rel_route'  => 'ticket.operator.ticket.show',
                'section'    => 'ticket.ticket',
                'event_text' => 'Updated a time entry on ticket #' . $ticket->number . '.',
            ]);

            // Update time logged on ticket
            $this->updateTicketTime($ticket->id);
        }

        return $this->response->array([
            'status'  => 'success',
            'message' => trans('messages.success_updated', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]),
            'data'    => $record->loadMissing(['ticket', 'user'])
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        try {
            // Get record
            $record = call_user_func([$this->getClass(), 'findOrFail'], $id);
        } catch (ModelNotFoundException $e) {
            // Model not found
            $this->response->errorNotFound(trans('messages.error_notfound', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]));

            return;
        }

        $ticket = $record->ticket;

        // Attempt to delete
        $record->delete();

        // Add entry to log
        ActivityLog::addEntry([
            'brand_id'   => $ticket->brand_id,
            'type'       => ActivityLog::API,
            'rel_name'   => $ticket->number,
            'rel_id'     => $ticket->id,
            'rel_route'  => 'ticket.operator.ticket.show',
            'section'    => 'ticket.ticket',
            'event_text' => 'Deleted a time entry on ticket #' . $ticket->number . '.',
        ]);

        return $this->response->array([
            'status'  => 'success',
            'message' => trans('messages.success_deleted', [
                'item' => mb_strtolower(trans('TimeTracking::lang.time_entry'), 'UTF-8')
            ]),
            'data'    => null
        ]);
    }

    /**
     * Updates the time (and billable time) logged on the ticket.
     *
     * @param  int $ticketId
     * @return void
     */
    private function updateTicketTime(int $ticketId)
    {
        TimeTotal::firstOrNew(['ticket_id' => $ticketId])->updateTicketTime();
    }
}
