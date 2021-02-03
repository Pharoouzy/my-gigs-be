<?php

namespace App\Http\Controllers\V1;

use App\Helpers\RequestHelper;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends Controller
{
    use RequestHelper;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $tags = Tag::orderBy('created_at', 'desc')->get();

        return $this->response('success', $tags);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->customValidator($request, [
            'name' => 'required|string|unique:tags,name'
        ]);


        if ($validator->fails()) {
            return $this->validationError($validator);
        }
        $request['id'] = $this->generateId(Tag::query());
        $request['slug'] = Str::slug($request->name, '-');
        $tag = Tag::create($request->only(['id', 'name', 'slug']));

        return $this->response('success', $tag, 201);
    }

    /**
     * @param Request $request
     * @param $tagId
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $tagId) {
        $request['tag_id'] = $tagId;
        $tag = Tag::find($request->tag_id);

        $validator = $this->customValidator($request, [
            'tag_id' => 'required|string|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        return $this->response('success', $tag);
    }

    /**
     * @param Request $request
     * @param $tag
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $tag) {
        $tag = Tag::find($tag);

        $this->validate($request, [
            'name' => 'required|string|unique:tags,name,'.$tag->id,
        ]);
        $request['slug'] =  Str::slug($request->name, '-');
        $tag->update($request->only(['name',  'slug']));

        return $this->response('Tag updated successfully.', $tag);
    }

    /**
     * @param Request $request
     * @param $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $tag) {

        $request['tag'] = $tag;

        $tag = Tag::find($tag);

        $validator = $this->customValidator($request, [
            'tag' => 'required|string|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        if(!$tag->gigs()->get()->isEmpty())
            return $this->response('Unable to delete Tag because it is not empty.', [], 422);

        $tag->delete();

        return $this->response('Tag deleted successfully.');
    }
}
