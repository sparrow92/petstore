<h1>{{ $pet->name ?? 'Brak nazwy' }}</h1>

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

<form action="{{ route('pets.delete', $pet->id) }}" method="POST" style="display: inline;">
  @csrf
  @method('DELETE')
  <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć tego zwierzaka?')">Usuń zwierzaka</button>
</form>

<a href="{{ route('pets.edit', $pet->id) }}">Edytuj zwierzaka</a>
<a href="{{ route('pets.index') }}">Powrót do listy</a>