<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;
use App\Models\Guide;

class GuideFavoriteRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Persist the changes.
     *
     * @param Guide $guide
     *
     * @return bool
     */
    public function persist(Guide $guide)
    {
        if ($guide->hasFavorite() && $guide->unFavorite()) {
            // If the guide is currently already a favorite, we'll assume
            // the user is wanting to 'un-favorite' the guide.
            return true;
        } elseif ($guide->favorite()) {
            return true;
        }

        return false;
    }
}
