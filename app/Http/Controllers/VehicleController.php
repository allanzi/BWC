<?php

namespace App\Http\Controllers;

use App\Validators\VehicleValidator;
use App\Vehicle;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class VehicleController extends Controller
{
    private const MESSAGE_NOT_FOUND = 'The Vehicle not found';
    private const MESSAGE_DELETED = 'The Vehicle has been deleted';
    /**
     * @var Vehicle
     */
    private $model;
    /**
     * @var VehicleValidator
     */
    private $validator;

    /**
     * VehicleController constructor.
     * @param Vehicle $model
     * @param VehicleValidator $validator
     */
    public function __construct(Vehicle $model, VehicleValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = [
            'data' => $this->model->orderBy('id', 'desc')->get()
        ];

        return response()->json($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {
            $data = $request->input();

            $this->validator
                ->with($data)
                ->passesOrFail(ValidatorInterface::RULE_CREATE);

            $this->model
                ->create($data);

            return response()->redirectToRoute('vehicles.index');

        } catch (ValidatorException $e) {

            return response()->json($e->toArray(), 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = $this->model
                      ->find($id);

        if (!$model) {
            return response()->json(['message' => self::MESSAGE_NOT_FOUND], 404);
        }

        return response()->json(['data' => $model]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->input();
            $model = $this->model
                ->find($id);

            if (!$model) {
                return response()->json(['message' => self::MESSAGE_NOT_FOUND], 404);
            }

            $this->validator
                ->with($data)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $model->update($data);

            return response()->json(['data' => $model], 200);

        } catch (ValidatorException $e) {

            return response()->json($e->toArray(), 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->model
                ->findOrFail($id)
                ->delete();

            return response()->json(['data' => self::MESSAGE_DELETED]);
        } catch (\Exception $e) {
            return response()->json($e->toArray(), 404);
        }
    }

    public function search(Request $request)
    {
        $lookingFor = $request->get('q');

        $data = [
            'data' => $this->model->search($lookingFor)

        ];

        return response()->json($data);
    }
}
