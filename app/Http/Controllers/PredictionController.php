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
        // Mengambil nama item unik dari tabel bakerysales
        $item = bakerysales::distinct()->pluck('item_name');

        // Mengambil semua parameter unik dari tabel Forecasting
        $selectitem = Forecasting::distinct()->pluck('parameter');

        // Get the selected parameter from the request
        $selectedParameter = $request->input('parameter', '');

        // If a parameter is selected, filter the predictions based on that parameter
        if ($selectedParameter) {
            $predictions = Forecasting::where('parameter', $selectedParameter)->get();
        } else {
            // If no parameter is selected, fetch all predictions
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

        // Cek apakah prediksi untuk item ini sudah ada
        $existingPrediction = Forecasting::where('parameter', $article)->first();

        if ($existingPrediction) {
            return redirect()->back()->with('alert', 'Prediction for this item has already been made.');
        }

        // Kirim request POST ke Flask untuk prediksi
        $response = Http::timeout(180)->post('http://localhost:5000/superadmin', [
            'article' => $article,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['predictions']) && isset($data['dates'])) {
                $predictions = $data['predictions'];
                $dates = $data['dates'];

                $formattedDates = [];
                foreach ($dates as $date) {
                    $formattedDates[] = date('m-Y', strtotime($date));
                }

                $predictionsData[] = [
                    'item_name' => $article,
                    'dates' => $formattedDates,
                    'predictions' => $predictions,
                ];

                // dd($predictionsData);

                // Simpan hasil prediksi ke dalam tabel forecasting
                foreach ($dates as $index => $date) {
                    Forecasting::create([
                        'date' => $date,
                        'parameter' => $article,
                        'value' => $predictions[$index][0],
                    ]);
                }
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }
    // public function index()
    // {
    //      return view('auth.predict.predict');
    // }

    // public function predict(Request $request)
    // {
    //     // Mengambil 2 nama item unik dari tabel bakerysales
    //     $article = $request->input('item_name');

    //     // Kirim request POST ke Flask untuk prediksi
    //     $response = Http::timeout(300)->post('http://localhost:5000/superadmin', [
    //         'article' => $article,
    //     ]);

    //     // Check if the request was successful
    //     if ($response->successful()) {
    //         // Ambil data hasil prediksi dari respons Flask
    //         $data = $response->json(); // Mengambil respons sebagai array atau objek

    //         if (isset($data['predictions']) && isset($data['dates'])) {
    //             $predictions = $data['predictions'];
    //             $dates = $data['dates'];

    //             $formattedDates = [];
    //             foreach ($dates as $date) {
    //                 $formattedDates[] = date('m-Y', strtotime($date));
    //             }
    //             // Tambahkan hasil prediksi ke array $predictionsData
    //             $predictionsData[] = [
    //                 'item_name' => $article,
    //                 'dates' => $formattedDates,
    //                 'predictions' => $predictions,
    //             ];
    //         } else {
    //             return view('prediction_result', ['error_message' => 'Response from Flask does not contain predictions or dates.']);
    //         }
    //     } else {
    //         // Handle the case where the request failed
    //         return view('prediction_result', ['error_message' => 'Failed to retrieve predictions from Flask.']);
    //     }

    //     dd($predictionsData);
    //     // Jika berhasil, kembalikan hasil prediksi ke halaman blade
    //     return view('prediction_result', ['predictionsData' => $predictionsData]);
    // }
}
