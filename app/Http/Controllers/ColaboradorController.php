<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use DateTimeInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Response;

class ColaboradorController extends Controller
{
    public function index()
    {
        return Response::json([
            "timestamp" => (new \DateTime())->format(DateTimeInterface::ISO8601),
            "data" => Colaborador::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "nome_completo" => ["required"],
                "apelido" => ["required"],
                "nome_pai" => ["required"],
                "nome_mae" => ["required"],
                "cpf" => ["required", "min:11", "max:14", Rule::unique(Colaborador::class, "cpf")],
                "data_nascimento" => ["required", Rule::date()],
                "cargo" => ["required"],
            ]);

            $colaborador = new Colaborador();
            $colaborador->fill($validatedData);

            $colaborador->save();

            return Response::json([
                "timestamp" => (new \DateTime())->format(DateTimeInterface::ISO8601),
                "data" => $colaborador
            ], 201);
        } catch (ValidationException $e) {
            return Response::json(["message" => $e->validator->errors()], 400);
        } catch (UniqueConstraintViolationException $e) {
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function show(string $id)
    {
        try {
            return Response::json([
                "timestamp" => (new \DateTime())->format(DateTimeInterface::ISO8601),
                "data" => Colaborador::findOrFail($id),
            ]);
        } catch (ModelNotFoundException $e) {
            return Response::json(["message" => "Não foi possivel encontrar o colaborador código: $id"], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);

            $validatedData = $request->validate([
                "nome_completo" => ["required"],
                "apelido" => ["required"],
                "nome_pai" => ["required"],
                "nome_mae" => ["required"],
                "cpf" => ["required", "min:11", "max:14"/* , Rule::unique(Colaborador::class, "cpf") */],
                "data_nascimento" => ["required", Rule::date()],
                "cargo" => ["required"],
            ]);

            $colaborador->fill($validatedData);

            $colaborador->save();

            return Response::json([
                "timestamp" => (new \DateTime())->format(DateTimeInterface::ISO8601),
                "data" => $colaborador
            ], 200);
        } catch (ModelNotFoundException $e) {
            return Response::json(["message" => "Não foi possivel encontrar o colaborador código: $id"], 404);
        } catch (ValidationException $e) {
            return Response::json(["message" => $e->validator->errors()], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            $colaborador = Colaborador::findOrFail($id);

            $colaborador->delete();

            return Response::json(["status" => true, "message" => "Colaborador $id excluido"]);
        } catch (ModelNotFoundException $e) {
            return Response::json(["message" => "Não foi possivel encontrar o colaborador código: $id"], 404);
        }
    }
}
