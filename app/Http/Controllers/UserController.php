<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->userRepository->get();
        return Inertia::render('User', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userRepository->createUser($request);
        return redirect()->back()->with([
            'message' => 'User have been created',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = [
            'success' => true,
            'message' => 'User have been updated!',
        ];
        $updated = $this->userRepository->updateUser($request, $id);
        if (!$updated) {
            $response['success'] = false;
            $response['message'] = 'User haven\'t been updated!';
        }
        return redirect()->back()->with($response);
    }

    /**
     * Soft delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $response = [
            'success' => true,
            'message' => 'User have been deleted!',
        ];

        $deleted = $this->userRepository->deleteUser($id);
        if (!$deleted) {
            $response['success'] = false;
            $response['message'] = 'User haven\'t been deleted!';
        }
        return redirect()->back()->with($response);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [
            'success' => true,
            'message' => 'User have been destory!',
        ];

        $deleted = $this->userRepository->deleteUser($id);
        if (!$deleted) {
            $response['success'] = false;
            $response['message'] = 'User haven\'t been destory!';
        }
        return redirect()->back()->with($response);
    }

    public function changePassword(Request $request, $id)
    {
        $this->userRepository->changePassword($request, $id);
    }
}
