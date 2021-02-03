<?php

namespace App\Http\Controllers\V1;

use App\Models\Gig;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Helpers\RequestHelper;

/**
 * Class GigController
 * @package App\Http\Controllers\V1
 */
class GigController extends Controller {

    use RequestHelper;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $gigs = Gig::orderBy('created_at', 'desc')->with(['country', 'state', 'tags'])->get();

        return $this->response('success', $gigs);
    }

    /**
     * @param Request $request
     * @param $gig
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, $gig) {

        $request['gig_id'] = $gig;
        $gig = Gig::find($request->gig_id);

        $validator = $this->customValidator($request, [
            'gig_id' => 'required|string|exists:gigs,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        return $this->response('success', $gig);
    }

    /**
     * @param Request $request
     * @param $filter
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request, $filter) {
        $request['filter'] = $filter;
        $validator = $this->customValidator($request, [
            // 'filter' => 'required|string|exists:tags,name',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $gigs = Tag::where('name', 'LIKE', '%'.$request->filter.'%')->with(['gigs'])->first();

        if(!$gigs) $gigs = Tag::with(['gigs'])->first();

        return $this->response('success', $gigs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {

        $validator = $this->customValidator($request, [
            'role' => 'required|string',
            'company_name' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'address' => 'required|string',
            'min_salary' => 'required|numeric|gt:0',
            'max_salary' => 'required|numeric|gt:min_salary',
            'tags' => 'required|array',
            'tags.*' => 'required|string|exists:tags,name',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $request['id'] = $this->generateId(Gig::query());

        $gig = Gig::create($request->only([
            'id', 'company_name',
            'role', 'country_id',
            'state_id', 'address',
            'min_salary', 'max_salary'
        ]));
        $tags = [];

        foreach($request->tags as $tag)
            $tags[] = Tag::where('name', $tag)->first()->id;
        
        $gig->tags()->sync($tags, true);

        $data = Gig::where('id', $gig->id)->with(['country', 'state', 'tags'])->first();

        return $this->response('success', $data, 201);
    }


    /**
     * @param Request $request
     * @param $gig
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $gig) {

        $request['gig_id'] = $gig;
        $gig = Gig::where('id', $request->gig_id)->with(['country', 'state', 'tags'])->first();
        $validator = $this->customValidator($request, [
            'role' => 'sometimes|string',
            'company_name' => 'sometimes|string',
            'country_id' => 'sometimes|string|exists:countries,id',
            'state_id' => 'sometimes|string|exists:states,id',
            'address' => 'sometimes|string',
            'min_salary' => 'sometimes|numeric|gt:0',
            'max_salary' => 'sometimes|numeric|gt:0',
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|string|exists:tags,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $gig->update($request->only([
            'company_name', 'role',
            'country_id', 'state_id', 'address',
            'min_salary', 'max_salary'
        ]));

        $gig->tags()->sync($request->tags, true);

        return $this->response('success', $gig);
    }

    /**
     * @param Request $request
     * @param $gig
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $gig) {

        $request['gig_id'] = $gig;
        $gig = Gig::find($request->gig_id);

        $validator = $this->customValidator($request, [
            'gig_id' => 'required|string|exists:gigs,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator);
        }

        $gig->delete();

        return $this->response('success');
    }
}
