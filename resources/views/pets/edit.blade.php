<h1>Edycja: {{ $pet->name ?? 'Brak nazwy' }}</h1>

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('pets.update', $pet->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div>
    <label for="name">Imię zwierzaka:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $pet->name) }}" required>
  </div>

  <div>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
      <option value="available" {{ old('status', $pet->status) == 'available' ? 'selected' : '' }}>Available</option>
      <option value="pending" {{ old('status', $pet->status) == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="sold" {{ old('status', $pet->status) == 'sold' ? 'selected' : '' }}>Sold</option>
    </select>
  </div>

  <button type="submit">Zapisz zmiany</button>
</form>
