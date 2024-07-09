<?php

namespace App\Http\Controllers\Restaurant;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Restaurant\ContactUsRepository;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $user = auth()->user();
        $params = $request->only('par_page', 'sort', 'direction', 'filter', 'id');
        $params['id'] = $params['id'] ?? $user->id;
        $contactUsEmails = (new ContactUsRepository())->allContactUs($params);
        return view('restaurant.contact_us.index', ['contactUsEmails' => $contactUsEmails]);
    }
    public function destroy($id)
    {
        $contactUs = ContactUs::where('id', $id)->first();
        if (empty($contactUs)) {
            request()->session()->flash('Error', __('system.messages.not_found', ['model' => __('system.contact_us.menu')]));
            return redirect()->back();
        }
        $contactUs->delete();
        request()->session()->flash('Success', __('system.messages.deleted', ['model' => __('system.contact_us.menu')]));
        return redirect(route('restaurant.contact-request.index'));
    }
}
