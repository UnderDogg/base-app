<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;
use App\Models\Guide;
use Illuminate\Support\Str;

class GuideRequest extends Request
{
    /**
     * The guide request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $slug = $this->route('guides');

        return [
            'title'         => "required|min:5|max:80|unique:guides,title,$slug,slug",
            'description'   => 'min:5|max:1000',
        ];
    }

    /**
     * The guide request custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.unique' => 'A guide with this title already exists.',
        ];
    }

    /**
     * Only allow logged in users to create / update guides.
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
        $guide->slug = $this->makeSlugFromTitle($this->input('title'));
        $guide->title = $this->input('title');
        $guide->description = $this->input('description');

        if ($this->has('publish')) {
            $guide->published = true;
            $guide->published_on = $this->guide->freshTimestampString();
        }

        return $guide->save();
    }

    /**
     * Create a conversation slug.
     *
     * @param string $title
     *
     * @return string
     */
    public function makeSlugFromTitle($title)
    {
        $slug = Str::slug($title);

        $count = Guide::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
