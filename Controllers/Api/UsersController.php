<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Users\AgentsRequest;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\Api\Users\ContactsRequest;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function call_user_func;
use function count;
use function mb_strtolower;
use function mb_strimwidth;
use function trans;

class UsersController extends BaseApiController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param AgentsRequest $request
     * @return mixed
     */
    public function getOperators(AgentsRequest $request)
    {
        //Get Query Data
        $name = $request->input('name');

        //Check if user exists
        $whereCondition = [
            ['firstname', '=', $name]
        ];

        $user = User::where($whereCondition)->first();

        if ($user) {
            return [$user];
        } else {
            return;
        }
    }

    /**
     * @param ContactsRequest $request
     * @return mixed
     */
    public function getContacts(ContactsRequest $request)
    {
        //Get Query Data
        $email = $request->input('email');

        //Check if user exists
        $whereCondition = [
            ['email', '=', $email]
        ];

        $user = User::where($whereCondition)->first();

        $response = array(
            'active'    => true,
            'name'      => $user['formatted_name'],
            'email'     => $user['email'],
            'company_id'    => 'Test Company'
        );

        if ($user) {
            return [$response];
        } else {
            return;
        }
    }
}
