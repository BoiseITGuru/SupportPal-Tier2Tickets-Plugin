<?php declare(strict_types=1);

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\Api;

use App\Modules\Core\Controllers\BaseApiController;
use App\Modules\Ticket\Models\Department;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function call_user_func;
use function count;
use function mb_strtolower;
use function mb_strimwidth;
use function trans;

class DepartmentController extends BaseApiController
{
    /**
     * DepartmentController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * @return mixed
     */
    public function getDepartments()
    {
        $departments = Department::get();

        return $departments;
    }
}
