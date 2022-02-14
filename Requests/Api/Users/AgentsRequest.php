<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Users;

use App\Http\ApiFormRequest;
use Illuminate\Support\Carbon;

use function config;

class AgentsRequest extends ApiFormRequest
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
            'name'         => ['required', 'string']
        ];
    }
}
