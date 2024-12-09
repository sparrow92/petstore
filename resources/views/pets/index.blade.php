<h1>Lista zwierzaków</h1>

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

<form action="{{ route('pets.store') }}" method="POST">
  @csrf
  <div>
    <label for="name">Imię zwierzaka</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
  </div>

  <div>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
      <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
      <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
    </select>
  </div>

  <button type="submit">Dodaj zwierzaka</button>
</form>



@if($pets->isEmpty())
  <p>Brak zwierzaków.</p>
@else
  <ul>
    @foreach($pets as $pet)
      <li><a href="{{ route('pets.show', $pet->id) }}">{{ $pet->name ?? 'Brak nazwy' }} - {{ $pet->status ?? 'Brak statusu' }}</a></li>
    @endforeach
  </ul>
@endif

