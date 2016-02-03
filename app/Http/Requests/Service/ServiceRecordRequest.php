<?php

namespace App\Http\Requests\Service;

use App\Models\ServiceRecord;
use App\Http\Requests\Request;

class ServiceRecordRequest extends Request
{
    /**
     * The service record validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $min = ServiceRecord::STATUS_ONLINE;
        $max = ServiceRecord::STATUS_OFFLINE;

        return [
            'status'        => "required|integer|between:$min,$max",
            'title'         => 'required',
            'description'   => '',
        ];
    }

    /**
     * Allows all users to create service record requests.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
