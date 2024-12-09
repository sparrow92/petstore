<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PetstoreApiService
{
  public function getPetsByStatus($status)
  {
    $response = Http::petstore()->get("pet/findByStatus", [
        'status' => $status
    ]);

    return $this->handleResponse($response);
  }

  public function getPet($id)
  {
    $response = Http::petstore()->get("pet/{$id}");

    return $this->handleResponse($response);
  }

  public function storePet($data)
  {
    $response = Http::petstore()->post("pet", $data);

    return $this->handleResponse($response);
  }

  public function updatePet($id, $data)
  {
    $response = Http::petstore()->put("pet", array_merge(['id' => $id], $data));

    return $this->handleResponse($response);
  }

  public function deletePet($id)
  {
    $response = Http::petstore()->delete("pet/{$id}");

    return $this->handleResponse($response);
  }

  private function handleResponse($response)
  {
    if ($response->successful()) {
      return (object) $response->json();
    }

    return $this->handleError($response);
  }

  private function handleError($response)
  {
    switch ($response->status()) {
      case 400:
        throw new \Exception('Nieprawidłowe żądanie. Sprawdź poprawność danych.');
      case 404:
        throw new \Exception('Nie znaleziono zasobu.');
      case 405:
        throw new \Exception('Nieprawidłowa metoda żądania.');
      default:
        throw new \Exception('Wystąpił nieoczekiwany błąd.');
    }
  }
}
