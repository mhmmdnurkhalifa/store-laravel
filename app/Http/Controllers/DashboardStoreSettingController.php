<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardStoreSettingController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $categories = Category::all();
        $stores = Store::with(['user'])->where('users_id', Auth::user()->id)->firstOrFail();
        return view('pages.dashboard-store-setting', [
            'user' => $user,
            'stores' => $stores,
            'categories' => $categories
        ]);
    }

    public function accountAdmin()
    {
        $user = Auth::user();
        return view('pages.dashboard-account', [
            'user' => $user,
        ]);
    }
    public function accountUser()
    {
        $user = Auth::user();
        return view('pages.setting-account', [
            'user' => $user,
        ]);
    }

    public function updateStore(Request $request, $redirect)
    {
        $data = [
            'users_id' => Auth::user()->id,
            'store_name' => $request->store_name,
            'account_number' => $request->account_number,
            'store_status' => $request->store_status,

        ];
        $item = Store::with(['user'])->where('users_id', Auth::user()->id);
        $item->update($data);
        return redirect()->route($redirect);
    }
    public function updateAdmin(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();
        $item->update($data);
        return redirect()->route($redirect);
    }
    public function updateUser(Request $request, $redirect)
    {
        $data = $request->all();
        $item = Auth::user();
        $item->update($data);
        return redirect()->route($redirect);
    }
}
