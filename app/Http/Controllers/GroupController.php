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

    public function getGroupsByYear(int $year)
    {
        // Validate that the year is valid (optional, but good practice)
        if ($year < 1 || $year > 8) {
            return response()->json(['error' => 'Invalid year.'], 400);
        }

        // Fetch groups based on the year
        $groups = Group::where('year', $year)->get();

        // Check if any groups were found
        if ($groups->isEmpty()) {
            return response()->json(['message' => 'No groups found for the specified year.'], 404);
        }

        return response()->json($groups, 200);
    }
    public function create(Request $request){
        $request->validate([
            'group_name' => 'required|string|unique:groups,group_name',
            'year' => 'required|integer|min:1|max:8', // Validate year between 1900 and the current year
        ]);

        $group = Group::create([
            'group_name' => $request['group_name'],
            'year' => $request['year'],
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
            'year' => 'integer|min:1|max:8',
        ]);

        $group->update([
            'group_name' => $request->group_name ?? $group->group_name,
            'year' => $request->year ?? $group->year,
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
