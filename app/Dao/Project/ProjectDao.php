<?php

namespace App\Dao\Project;

use App\Contracts\Dao\Project\ProjectDaoInterface;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Payroll
 */
class ProjectDao implements ProjectDaoInterface
{
    /**
     * To get all projects
     * 
     * @return $array of projects
     */
    public function getProjects()
    {
        return Project::with('manager')
            ->withCount('employees')
            ->latest()
            ->get();
    }

    /**
     * To get all employees
     * 
     * @return $array of employee
     */
    public function getEmployee()
    {
        return Employee::where('role_id', '<>', config('constants.Manager'))
            ->latest()
            ->get()
            ->pluck('name', 'id');
    }

    /**
     * To store project
     * 
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeProject(Request $request)
    {
        try {
            DB::beginTransaction();

            $project = Project::create([
                'name' => $request->name,
                'link' => $request->link,
                'manager_id' => auth()->id()
            ]);

            $project->employees()->attach($request->employees);


            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @return $array of employee
     */
    public function getMembers(Project $project)
    {
        $members = $project->employees;
        $nonMembers = Employee::where('role_id', '<>', config('constants.Manager'))
            ->get()
            ->diff($members);
        $members = $members->pluck('name', 'id');
        $nonMembers = $nonMembers->pluck('name', 'id');
        $data = [
            'members' => $members,
            'nonMembers' => $nonMembers
        ];

        return $data;
    }

    /**
     * To get all members and non members
     * 
     * @param App\Models\Project $project
     * @param int $id
     * @return $array of employee
     */
    public function memberToogle(Project $project, $id)
    {
        try {
            DB::beginTransaction();

            $project->employees()->toggle($id);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To update project
     * 
     * @param App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function updateProject(Request $request, Project $project)
    {
        try {
            DB::beginTransaction();

            $project->update([
                'name' => $request->name,
                'link' => $request->link
            ]);

            DB::commit();
            return $project;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To delete project
     * 
     * @param App\Models\Project $project
     * @return bool
     */
    public function deleteProject(Project $project)
    {
        try {
            DB::beginTransaction();

            $project->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
