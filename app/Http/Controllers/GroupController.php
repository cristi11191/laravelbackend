<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller{

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        $groups = Group::all();
        return $groups;
    }

    public function get(int $id)
    {
        $group = Group::find($id);

        if(!$group){
            return response()->json(['message'=>'group not found'],404);
        }
        return response()->json($group);
    }
    public function create(Request $request){
        $request->validate([
            'group_name' => 'required|string|unique:groups,group_name',
        ]);

        $group = Group::create([
            'group_name' => $request['group_name'],
        ]);
        return response()->json($group,201);

    }

    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        if (!$group) {
            return response()->json(['error' => 'Group not found.'], 404);
        }

        $request->validate([
            'group_name' => 'string|unique:groups,group_name,'.$group->id,
        ]);

        $group->update([
            'group_name' => $request->group_name ?? $group->group_name,
        ]);

        return response()->json($group);
    }

    public function delete($id)
    {
        $group = Group::find($id);
        if (!$group) {
            return response()->json(['error' => 'Group not found.'], 404);
        }
        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }



}
