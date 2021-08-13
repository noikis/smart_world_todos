<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Resources\ListCollection;
use App\Http\Resources\ListResource;
use App\Models\Listing;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $decodedURL = urldecode(url()->full());
        $parsedUrl = parse_url($decodedURL);
        parse_str($parsedUrl['query'], $parsedQueryString);

        $list = Listing::all();
        $resource = (new ListCollection($list) );

        // items per page
        if ($request->filled('per_page') && is_numeric($request['per_page'])) {
            $resource = new ListCollection(Listing::paginate($request['per_page']) );
        }
        // current page
        if ($request->filled('page') && is_numeric($request['page'])) {
            $list->append('page', $request['page']);
        }
        // with relations
        try {
            if($request->filled('with')) $list->load($request['with']);
        }
        catch (RelationNotFoundException $exception) {
            $resource->additional(['message' => 'Received!', 'error' => 'Relation Not Found']);
        }
        // order
        if($request->filled('order')   ) {
            $list->sortByDesc('name');
            return $resource->additional(['order' => 'By ID']);
        }



        return $resource;
    }

    public function store(Request $request): ListResource
    {
        $list = Listing::create($request['attributes']);
        $list->users()->attach(Auth::id());
        return (new ListResource($list))->additional(['message' => 'Created!']);
    }

    public function update(ListRequest $request, $id): ListResource
    {
        $list = Listing::with('users')->findOrFail($id);
        $list->update($request['attributes']);
        return (new ListResource($list))->additional(['message' => 'Updated!']);
    }

    public function show(Request $request, $id): ListResource
    {
        $list = Listing::findOrFail($id);
        // Check Relation
        try {
            if($request->filled('with')) $list->load($request['with']);
            return (new ListResource($list))->additional(['message' => 'Received!']);
        }
        catch (RelationNotFoundException $exception) {
            return (new ListResource($list))->additional(
                ['message' => 'Received!', 'error' => 'Relation Not Found']);
        }

    }


}
