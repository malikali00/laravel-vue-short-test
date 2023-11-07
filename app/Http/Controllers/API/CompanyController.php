<?php

namespace App\Http\Controllers\API;

use App\Events\NewCompanyEvent;
use App\Models\Company;
use App\Notifications\NewCompanyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(10); // Retrieve all company records

        return $this->sendResponse($companies, 'Companies Retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming you want to upload images
            'website' => 'url',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            $validatedData['logo'] = $logoPath;
        }

        $company = Company::create($validatedData);
        // Notify the specified email address with the NewCompanyNotification
        try{
            Notification::route('mail', 'malikali_00@hotmail.com')->notify(new NewCompanyNotification($company));
        } catch (\Exception $e){
            echo $e->getMessage();
        }

        return $this->sendResponse($company, 'Company created successfully.');

        //return response()->json(['message' => 'Company created successfully', 'company' => $company], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return $this->sendError('Company not found', [], 404);
        }

        return $this->sendResponse($company, 'Company retrieved successfully');
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
        $company = Company::find($id);

        if (!$company) {
            return $this->sendError('Company not found', [], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Assuming you want to upload images
            'website' => 'url',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos');
            $validatedData['logo'] = $logoPath;
        }


        $company->update($validatedData);

        return $this->sendResponse($company, 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return $this->sendError('Company not found', [], 404);
        }

        if ($company->delete()) {
            return $this->sendResponse([], 'Company deleted successfully');
        }

        return $this->sendError('Failed to delete company', [], 500);
    }
}
