<?php

namespace App\Modules\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyHistory;
use App\Modules\General\Models\City;
use App\Modules\General\Models\Country;
use App\Modules\General\Models\Zipcode;
use App\Repositories\Image;
use Auth;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function showCompanies()
    {
        return view('Company::showCompanies', ['companies' => Company::all()]);
    }
    public function showAddCompany()
    {

        $lastCompanyId = Company::count() + 1;
        $countries = Country::all();
        return view('Company::addCompany', compact('lastCompanyId', 'countries'));
    }

    public function showCompany($id)
    {
        $company = Company::find($id);

        if ($company) {
            return view('Company::showCompany', compact('company'));
        }
        return view('General::notFound');

    }

    public function handleAddCompany(Request $request)
    {

        $request->validate([
            'code' => 'required|regex:/^[A-Z0-9]+$/|alpha_dash',
            'name' => 'required',
            'designation' => 'required',
            'zipcode_id' => 'required',
            'address' => 'required',
            'tel' => 'required|digits_between:1,12',
            'cc' => 'required|min:3|max:10|regex:/^[+][0-9]{1,3}+$/',
            'logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',

        ], [
            'code.required' => ' Code est obligatoire',
            'code.regex' => ' Code n\'est pas valide',
            'code.alpha_dash' => ' Code n\'est pas valide',
            'name.required' => ' Nom du group est requis',
            'designation.required' => ' Designation est requise',
            'address.required' => ' L\'addresse est requise',
            'zipcode_id.required' => ' Code postale est requis',
            'cc.required' => 'Préfixe telephone est obligatoire',
            'cc.min' => ' Préfixe telephone est invalide',
            'cc.max' => ' Préfixe telephone est invalide',
            'cc.regex' => ' Préfixe telephone est invalide',
            'tel.required' => 'Numéro télephone est requis',
            'tel.digits_between' => 'Numéro télephone invalide',
            'logo.image' => 'Le format du logo importé est non supporté ',
            'logo.mimes' => 'Le format du logo importé est non supporté ',
            'logo.max' => 'Logo importé est volumineux ! ',

        ]);

        if ($request->logo) {
            $path = $this->image->uploadBinaryImage($request->logo);

        } else {
            $path = 'company-placeholder.png';
        }

        $telephone = $request->cc . " " . $request->tel;
        $insertable = $request->all();
        $insertable['tel'] = $telephone;
        $insertable['cc'] = null;
        $insertable['logo'] = $path;
        $checkCode = Company::where('code', preg_replace('/\s/', '', $request->code))->first();
        if ($checkCode) {
            alert()->error('Oups', 'Code déja utilisé !')->persistent('Femer');
            return redirect()->back()->withInput();
        }

        $company = Company::create($insertable);
        CompanyHistory::create([
            'action' => 'Création',
            'company_id' => $company->id,
            'user_id' => Auth::id(),

        ]);
        alert()->success('Succès!', 'La societé a été ajoutée avec succès ')->persistent("Fermer");
        return redirect('/');

    }

    public function edit($id)
    {
        $company = Company::find($id);

        if ($company) {
            $countries = Country::all();
            $cities = City::where('country_id', $company->country_id)->get();
            $zipcodes = Zipcode::where('city_id', $company->city_id)->get();

            return view('Company::updateCompany', compact('company', 'countries', 'cities', 'zipcodes'));

        }
        return view('General::notFound');

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'code' => 'required|regex:/^[A-Z0-9]+$/|alpha_dash',
            'name' => 'required',
            'designation' => 'required',
            'zipcode_id' => 'required',
            'address' => 'required',
            'tel' => 'required|digits_between:1,12',
            'cc' => 'required|min:3|max:10|regex:/^[+][0-9]{1,3}+$/',
            'logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',

        ], [
            'code.required' => ' Code est obligatoire',
            'code.regex' => ' Code n\'est pas valide',
            'code.alpha_dash' => ' Code n\'est pas valide',
            'name.required' => ' Nom du group est requis',
            'designation.required' => ' Designation est requise',
            'address.required' => ' L\'addresse est requise',
            'zipcode_id.required' => ' Code postale est requis',
            'cc.required' => 'Préfixe telephone est obligatoire',
            'cc.min' => ' Préfixe telephone est invalide',
            'cc.max' => ' Préfixe telephone est invalide',
            'cc.regex' => ' Préfixe telephone est invalide',
            'tel.required' => 'Numéro télephone est requis',
            'tel.digits_between' => 'Numéro télephone invalide',
            'logo.image' => 'Le format du logo importé est non supporté ',
            'logo.mimes' => 'Le format du logo importé est non supporté ',
            'logo.max' => 'Logo importé est volumineux ! ',

        ]);

        $company = Company::find($id);

        if ($company) {

            $checkCode = Company::where('code', preg_replace('/\s/', '', $request->code))
                ->where('id', '!=', $company->id)
                ->first();
            if ($checkCode) {
                alert()->error('Oups', 'Code déja utilisé !')->persistent('Femer');
                return redirect()->back();
            }

            $path = null;
            if ($request->logo) {
                $path = $this->image->uploadBinaryImage($request->logo);

            }
            $fullTel = $request->cc . ' ' . $request->tel;

            $company->update([
                'code' => $request->code,
                'status' => $request->status,
                'name' => $request->name,
                'designation' => $request->designation,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'zipcode_id' => $request->zipcode_id,
                'address' => $request->address,
                'complement' => $request->complement,
                'email' => $request->email,
                'tel' => $fullTel,
                'comment' => $request->comment,
                'logo' => isset($path) ? $path : $company->logo,
            ]);

            CompanyHistory::create([
                'action' => 'Modification',
                'company_id' => $company->id,
                'user_id' => Auth::id(),

            ]);

            alert()->success('La societé a été modifiée avec succès', 'Succès!')->persistent("Fermer");
            return redirect()->route('showCompanies');

        }
        return view('General::notFound');

    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if ($company) {
            if (!$company->stores()->exists() && (count($company->rentedMachines()) == 0)) {

                // check related stores and  their rentals ( set up rented machines as free)
                foreach ($company->stores as $store) {
                    $currentRentals = $store->rentals()->where('active', 1)->get();
                    if ($currentRentals) {
                        foreach ($currentRentals as $currentRental) {
                            $currentRental->machine->update(['rented' => 0]);
                        }

                    }

                }
                $company->delete();
                alert()->success('Succès!', 'La societé a été supprimé avec succès ')->persistent("Fermer");
                return redirect()->route('showCompanies');
            } else {
                alert()->error('Cette entité ne peut pas être supprimée, autres entités y sont liées', 'Oups! ')->persistent("Fermer");
                return redirect()->route('showCompanies');

            }

        }

        return view('General::notFound');
    }

}
