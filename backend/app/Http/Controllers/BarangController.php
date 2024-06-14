<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(barang $barang)
    {
        $data = $barang->orderBy('created_at', 'desc')->where('stat_data', '=', 1)->get();
        try {
            if ($data->isNotEmpty()) {
                $response = [
                    "message" => "Get All Data Success",
                    'status' => 200,
                    "data" => [
                        "barang" => $data,
                    ],
                    "foot" => [
                        "total_data" => $data->count(),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];

                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    "message" => "Get All Data Failed",
                    'status' => 404,
                    "foot" => [
                        "total_data" => $data->count(),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            };
        } catch (ValidationException $ve) {
            $response = [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $ve->errors(),
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $qe) {
            $response = [
                'message' => 'Database query error',
                'status' => 500,
                'error' => $qe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $response = [
                'message' => 'General error',
                'status' => 500,
                'error' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\PDOException $pdoe) {
            $response = [
                'message' => 'Database connection error',
                'status' => 500,
                'error' => $pdoe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'qty_kecil' => 'required|integer',
            'qty_sedang' => 'required|integer',
            'ppn' => 'required|integer',
            'name' => 'required|string|max:255',
            'satuan_kecil' => 'required|string|max:255',
            'satuan_sedang' => 'required|string|max:255',
            'satuan_besar' => 'required|string|max:255',
            'vendor_id' => 'required',
            'fp' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);
        try {
            $barang = new Barang();
            $barang->uuid = Str::uuid();
            $barang->user_id = auth()->user()->id;
            $barang->vendor_id = $validatedData['vendor_id'];
            $barang->name = $validatedData['name'];
            $barang->qty_kecil = $validatedData['qty_kecil'];
            $barang->qty_sedang = $validatedData['qty_sedang'];
            $barang->qty_besar = $barang->qty_sedang * $barang->qty_kecil;
            $barang->satuan_kecil = $validatedData['satuan_kecil'];
            $barang->satuan_sedang = $validatedData['satuan_sedang'];
            $barang->satuan_besar = $validatedData['satuan_besar'];
            $barang->fp = $validatedData['fp'];
            $barang->type = $validatedData['type'];
            $barang->keterangan = $validatedData['keterangan'];
            $barang->ppn = $validatedData['ppn'];
            $barang->save();

            $response = [
                'message' => "Created Data Successfully",
                'status' => 201,
                'data' => [
                    'name' => $barang->name,
                    'create_by' => $barang->user_id,
                    'created_at' => $barang->created_at,
                ],
                "foot" => [
                    "response_time" => microtime(true) - LARAVEL_START,
                    "timestamp_now" => now(),
                ]
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (ValidationException $ve) {
            $response = [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $ve->errors(),
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $qe) {
            $response = [
                'message' => 'Database query error',
                'status' => 500,
                'error' => $qe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $response = [
                'message' => 'General error',
                'status' => 500,
                'error' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\PDOException $pdoe) {
            $response = [
                'message' => 'Database connection error',
                'status' => 500,
                'error' => $pdoe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(barang $barang, $uuid)
    {
        $finduuid = $barang::where('uuid', $uuid)->where('stat_data', '=', 1)->first();
        // $data = $barang::find($finduuid->id);
        try {
            if ($finduuid) {
                $response = [
                    "message" => "Get Data By Id Success",
                    "data" => [
                        "barang" => $finduuid,
                    ],
                    "foot" => [
                        "total_data" => $finduuid->count(),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];

                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    "message" => "Get Data By Id Failed",
                    "foot" => [
                        "total_data" => $finduuid->count(),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];
            };
        } catch (ValidationException $ve) {
            $response = [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $ve->errors(),
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $qe) {
            $response = [
                'message' => 'Database query error',
                'status' => 500,
                'error' => $qe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $mnfe) {
            $response = [
                'message' => 'UUID tidak ditemukan',
                'status' => 404,
                'error' => $mnfe->getMessage(),

            ];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            $response = [
                'message' => 'General error',
                'status' => 500,
                'error' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\PDOException $pdoe) {
            $response = [
                'message' => 'Database connection error',
                'status' => 500,
                'error' => $pdoe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, barang $barang, $uuid)
    {
        $validatedData = $request->validate([
            'qty_kecil' => 'required|integer',
            'qty_sedang' => 'required|integer',
            'ppn' => 'required|integer',
            'name' => 'required|string|max:255',
            'satuan_kecil' => 'required|string|max:255',
            'satuan_sedang' => 'required|string|max:255',
            'satuan_besar' => 'required|string|max:255',
            'vendor_id' => 'required',
            'fp' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'stat_data' => 'nullable|string|max:1',
            'stat_barang' => 'nullable|string|max:1',
        ]);
        try {
            $barang = $barang::where('uuid', $uuid)->where('stat_data', '=', 1)->first();
            // $barang = $barang::find($finduuid->id);
            $barang->uuid = $barang->uuid;
            $barang->user_id = auth()->user()->id;
            $barang->vendor_id = $validatedData['vendor_id'];
            $barang->name = $validatedData['name'];
            $barang->qty_kecil = $validatedData['qty_kecil'];
            $barang->qty_sedang = $validatedData['qty_sedang'];
            $barang->qty_besar = $barang->qty_sedang * $barang->qty_kecil;
            $barang->satuan_kecil = $validatedData['satuan_kecil'];
            $barang->satuan_sedang = $validatedData['satuan_sedang'];
            $barang->satuan_besar = $validatedData['satuan_besar'];
            $barang->fp = $validatedData['fp'];
            $barang->type = $validatedData['type'];
            $barang->keterangan = $validatedData['keterangan'];
            $barang->ppn = $validatedData['ppn'];
            $barang->stat_data = $validatedData['stat_data'];
            $barang->stat_barang = $validatedData['stat_barang'];
            $barang->save();

            $changedData = $barang->getChanges();
            if (count($changedData) >= 1) {
                $response = [
                    'message' => "Updated Data Successfully",
                    'status' => 200,
                    'data' => [
                        "uuid" => $barang->uuid,
                        "changed_data" => $changedData
                    ],
                    "foot" => [
                        "total_column_updated" => count($changedData),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    'message' => "Updated Data Failed",
                    'status' => 200,
                    'data' => [
                        "No Data Update or Change ??"
                    ],
                    "foot" => [
                        "total_column_updated" => count($changedData),
                        "response_time" => microtime(true) - LARAVEL_START,
                        "timestamp_now" => now(),
                    ]
                ];
            }
            return response()->json($response, Response::HTTP_NOT_MODIFIED);
        } catch (ValidationException $ve) {
            $response = [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $ve->errors(),
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $qe) {
            $response = [
                'message' => 'Database query error',
                'status' => 500,
                'error' => $qe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $response = [
                'message' => 'General error',
                'status' => 500,
                'error' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\PDOException $pdoe) {
            $response = [
                'message' => 'Database connection error',
                'status' => 500,
                'error' => $pdoe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(barang $barang, $uuid)
    {
        $finduuid = $barang::where('uuid', $uuid)->where('stat_data', '=', 1)->first();
        try {
            if (auth()->user()->role == 'admin') {
                if ($finduuid) {
                    $dataToDelete = $finduuid->toArray();
                    $destroy_data = $barang::where('uuid', $uuid)->delete();
                    if ($destroy_data) {
                        $response = [
                            'message' => "Data Has Been Deleted",
                            'status' => 200,
                            'data' => $dataToDelete,
                            "foot" => [
                                "total_data_deleted" => $destroy_data,
                                "response_time" => microtime(true) - LARAVEL_START,
                                "timestamp_now" => now(),
                            ]
                        ];
                        return response()->json($response, Response::HTTP_OK);
                    }
                } else {
                    $response = [
                        'message' => "No Data Has been Deleted / Not Found Data",
                        'status' => 404,
                        'data' => [
                            'request' => $uuid,
                        ]
                    ];
                    return response()->json($response, Response::HTTP_NOT_FOUND);
                }
            } else {
                $response = [
                    'message' => "Doesn't Have Permission To Access Removed Features",
                    'status' => 403,
                ];
                return response()->json($response, Response::HTTP_FORBIDDEN);
            }
        } catch (ValidationException $ve) {
            $response = [
                'message' => 'Validation error',
                'status' => 422,
                'errors' => $ve->errors(),
            ];
            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (QueryException $qe) {
            $response = [
                'message' => 'Database query error',
                'status' => 500,
                'error' => $qe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            $response = [
                'message' => 'General error',
                'status' => 500,
                'error' => $e->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\PDOException $pdoe) {
            $response = [
                'message' => 'Database connection error',
                'status' => 500,
                'error' => $pdoe->getMessage(),
            ];
            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
