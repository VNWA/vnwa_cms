<?php

namespace App\Http\Controllers;

use App\Models\Appearance;
use Illuminate\Http\Request;

class AppearanceController extends Controller
{
    public function loadJsonDataTopNav()
    {

        $data = Appearance::where('type', 'top_nav')->first();

        return response()->json($data->value, 200);
    }
    function updateTopNav(Request $request)
    {
        try {
            Appearance::where('type', 'top_nav')->update(['value' => $request->data]);
            return response()->json(['message' => 'Update Top Nav Success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update Top Nav Failing'], 500);

        }
    }


    public function loadJsonDataProfile()
    {

        $data = Appearance::where('type', 'profile')->first();

        return response()->json($data->value, 200);
    }
    function updateProfile(Request $request)
    {
        try {
            Appearance::where('type', 'profile')->update(['value' => $request->data]);
            return response()->json(['message' => 'Update Porifie Company  Success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update Porifie Company  Failing'], 500);

        }
    }


    public function loadJsonDataBotSearch()
    {

        $data = Appearance::where('type', 'bot_search')->first();

        return response()->json($data->value, 200);
    }
    function updateBotSearch(Request $request)
    {
        try {
            Appearance::where('type', 'bot_search')->update(['value' => $request->data]);
            return response()->json(['message' => 'Update Bot Search Success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update Bot Search Failing'], 500);

        }
    }



    public function loadJsonDataLogo()
    {

        $data = Appearance::where('type', 'logo')->first();

        return response()->json($data->value, 200);
    }
    function updateLogo(Request $request)
    {
        try {
            Appearance::where('type', 'logo')->update(['value' => $request->data]);
            return response()->json(['message' => 'Update Logo Success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update Logo Failing'], 500);

        }
    }


    public function loadJsonDataFooter()
    {

        $data = Appearance::where('type', 'footer')->first();

        return response()->json($data->value, 200);
    }
    function updateFooter(Request $request)
    {
        try {
            Appearance::where('type', 'footer')->update(['value' => $request->data]);
            return response()->json(['message' => 'Update Footer Success'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update Footer Failing'], 500);

        }
    }
}
