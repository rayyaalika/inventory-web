<?php

namespace App\Http\Controllers;

use App\Models\bakerysales;
use App\Models\Forecasting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function index(Request $request)
    {
        $item = bakerysales::distinct()->pluck('item_name');
        $selectitem = Forecasting::distinct()->pluck('parameter');
        $selectedParameter = $request->input('parameter', '');
        if ($selectedParameter) {
            $predictions = Forecasting::where('parameter', $selectedParameter)->get();
        } else {
            $predictions = Forecasting::all();
        }

        return view('auth.predict.predict', [
            'items' => $item,
            'selectitems' => $selectitem,
            'selectedParameter' => $selectedParameter,
            'predictionsData' => $predictions,
        ]);
    }



    public function predict(Request $request)
{
    $article = $request->input('item_name');
    $existingPrediction = Forecasting::where('parameter', $article)->first();

    if ($existingPrediction) {
        return redirect()->back()->with('alert', 'Prediction for this item has already been made.');
    }

    $response = Http::timeout(180)->post('http://localhost:5000/superadmin', [
        'article' => $article,
    ]);

    if ($response->successful()) {
        $data = $response->json();

        if (isset($data['predictions']) && isset($data['dates'])) {
            $predictions = $data['predictions'];
            $dates = $data['dates'];

            // Convert date format for display
            $formattedDates = [];
            foreach ($dates as $date) {
                $formattedDates[] = date('d-m-Y', strtotime($date));
            }

            // Debugging: Check predictions and dates
            dd([
                'item_name' => $article,
                'dates' => $formattedDates,
                'predictions' => $predictions,
            ]);

            foreach ($dates as $index => $date) {
                Forecasting::create([
                    'date' => $date,
                    'parameter' => $article,
                    'value' => $predictions[$index],
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Item not found');
        }
    } else {
        return redirect()->back()->with('error', 'Product not found');
    }

    return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
}

    
    public function updateModel(Request $request)
    {
        $response = Http::timeout(180)->post('http://localhost:5000/update_model');

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Model berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui model.');
        }
    }
}
