<?php

namespace App\Http\Controllers;

use App\Services\PetstoreApiService;
use Illuminate\Http\Request;
use App\Http\Requests\PetRequest;

class PetController extends Controller
{
  protected $petstoreApi;

  public function __construct(PetstoreApiService $petstoreApi)
  {
    $this->petstoreApi = $petstoreApi;
  }

  /**
   * Lista zwierzaków
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    $status = $request->query('status', 'available');

    try {
      $response = $this->petstoreApi->getPetsByStatus($status);
      $pets = collect($response)->map(function ($pet) {
        return (object) $pet;
      });
      return view('pets.index', compact('pets', 'status'));
    } catch (\Exception $e) {
      return redirect()
        ->route('pets.index')
        ->with('error', $e->getMessage());
    }
  }

  /**
   * Pokazuje szczegóły zwierzaka
   * 
   * @param int $id
   * @return \Illuminate\View\View
   */
  public function show($id)
  {
    try {
      $pet = $this->petstoreApi->getPet($id);
      return view('pets.show', compact('pet'));
    } catch (\Exception $e) {
      return redirect()
        ->route('pets.index')
        ->with('error', $e->getMessage());
    }
  }

/**
 * Zapis zwierzaka
 * 
 * @param \App\Http\Requests\PetRequest $request
 * @return \Illuminate\View\View
 */
  public function store(PetRequest $request)
  {
    try {
      $data = $request->only(['name', 'status']);
      $this->petstoreApi->storePet($data);
      return redirect()->back()->with('success', 'Zwierzak został dodany!');
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->with('error', $e->getMessage());
    }
  }

  /**
   * Formularz edycji zwierzaka
   * 
   * @param int $id
   * @return \Illuminate\View\View
   */
  public function edit($id)
  {
    try {
      $pet = $this->petstoreApi->getPet($id);
      return view('pets.edit', compact('pet'));
    } catch (\Exception $e) {
      return redirect()
        ->route('pets.index')
        ->with('error', $e->getMessage());
    }
  }

  /**
   * Aktualizacja zwierzaka
   * 
   * @param \App\Http\Requests\PetRequest $request
   * @param int $id
   * @return \Illuminate\View\View
   */
  public function update(PetRequest $request, $id)
  {
    try {
      $data = $request->only(['name', 'status']);
      $this->petstoreApi->updatePet($id, $data);
      return redirect()->route('pets.show', $id)->with('success', 'Zwierzak został zaktualizowany!');
    } catch (\Exception $e) {
      return redirect()
        ->back()
        ->with('error', $e->getMessage());
    }
  }

  /**
   * Usuwanie zwierzaka
   * 
   * @param int $id
   * @return \Illuminate\View\View
   */
  public function delete($id)
  {
    try {
      $this->petstoreApi->deletePet($id);
      return redirect()->route('pets.index')->with('success', 'Zwierzak został usunięty!');
    } catch (\Exception $e) {
      return redirect()
        ->route('pets.index')
        ->with('error', $e->getMessage());
    }
  }
}
