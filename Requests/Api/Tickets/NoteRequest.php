<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Tickets;

use App\Http\ApiFormRequest;
use Illuminate\Support\Carbon;

use function config;

class NoteRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'attachments'       => ['file'],
            'body'              => ['required', 'string'],
            'incoming'          => ['boolean'],
            'notify_emails'     => [],
            'private'           => ['boolean'],
            'user_id'           => ['integer'],
        ];
    }
}
