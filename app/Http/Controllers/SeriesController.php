<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        return Series::all();
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',  // Updated to 'name'
            'groups' => 'array|nullable',
            'groups.*' => 'exists:groups,group_name'  // Change to validate against 'group_name'
        ]);

        // Check if groups exist (optional field)
        $groups = $validatedData['groups'] ? $validatedData['groups'] : []; // Directly use validated groups

        // Create a new Series record
        $series = Series::create([
            'name' => $validatedData['name'],  // Updated to 'name'
            'groups' => $groups,  // Store groups as JSON (optional)
        ]);

        // Log the created series for debugging
        \Log::info('Created series:', ['series' => $series]);

        return response()->json($series, 201);  // Return 201 status code
    }



    public function update(Request $request, Series $series)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',  // Updated to 'name'
            'groups' => 'array|nullable',
            'groups.*' => 'exists:groups,group_name'  // Change to validate against 'group_name'
        ]);

        // Check if groups exist (optional field)
        $groups = $validatedData['groups'] ? $validatedData['groups'] : []; // Directly use validated groups

        // Update the Series record
        $series->update([
            'name' => $validatedData['name'],  // Updated to 'name'
            'groups' => $groups,  // Store groups as JSON (optional)
        ]);

        // Log the updated series for debugging
        \Log::info('Updated series:', ['series' => $series]);

        return response()->json($series, 200);  // Return 200 status code
    }

    public function addGroupToSeries(Request $request, $seriesId)
    {
        $series = Series::findOrFail($seriesId);

        // Validate that group exists
        $newGroup = $this->validateGroups([$request->input('group')])[0];

        $existingGroups = $series->groups ?? [];

        // Check if the group is already in the series
        if (!in_array($newGroup, $existingGroups)) {
            $existingGroups[] = $newGroup;
            $series->groups = $existingGroups;
            $series->save();
        }

        return response()->json($series, 200);
    }

    public function removeGroupFromSeries(Request $request, $seriesId)
    {
        $series = Series::findOrFail($seriesId);

        $groupToRemove = $request->input('group');
        $existingGroups = $series->groups ?? [];

        // Remove the group if it exists
        if (($key = array_search($groupToRemove, $existingGroups)) !== false) {
            unset($existingGroups[$key]);
            $series->groups = array_values($existingGroups);  // Re-index array after removal
            $series->save();
        }

        return response()->json($series, 200);
    }

    public function destroy(Series $series)
    {
        $series->delete();
        return response()->json(null, 204);
    }

    public function deleteGroupFromAllSeries($groupId)
    {
        // Fetch all series that have this group
        $seriesList = Series::all();

        foreach ($seriesList as $series) {
            $groups = $series->groups ?? [];

            // Remove the group from the series if it exists
            if (($key = array_search($groupId, $groups)) !== false) {
                unset($groups[$key]);
                $series->groups = array_values($groups);  // Re-index array after removal
                $series->save();
            }
        }

        return response()->json(['message' => 'Group removed from all series'], 200);
    }

// Helper function to validate groups
    private function validateGroups(array $groups)
    {
        // Assuming Group is a model and checking if the group exists
        $validatedGroups = [];

        foreach ($groups as $groupId) {
            $group = Group::find($groupId);

            if ($group) {
                $validatedGroups[] = $groupId;
            } else {
                // You can throw an exception or handle as needed if the group does not exist
                throw new \Exception("Group with ID $groupId does not exist.");
            }
        }

        return $validatedGroups;
    }

}
