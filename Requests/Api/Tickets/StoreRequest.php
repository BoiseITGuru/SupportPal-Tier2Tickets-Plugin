<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Tickets;

use App\Http\ApiFormRequest;
use Illuminate\Support\Carbon;

use function config;

class StoreRequest extends ApiFormRequest
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
            'email'         => ['required', 'string'],
            'subject'       => ['required', 'string'],
            'status'        => ['required', 'integer'],
            'priority'      => ['required', 'integer'],
            'description'   => ['required', 'string'],
        ];
    }
}
