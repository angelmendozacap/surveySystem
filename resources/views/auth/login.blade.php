@extends('layouts.app')

@section('content')
<section class="w-full h-full flex items-center justify-center">
  <div class="w-full max-w-md p-4">
    <form class="bg-white shadow-md rounded px-4 md:px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
            Correo Electrónico
          </label>

          <input id="email" type="email" class="shadow appearance-none border @error('email') border-red-500 @enderror rounded w-full py-2 px-3 mb-1 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

          @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
            Contraseña
          </label>

          <input id="password" type="password" class="shadow appearance-none border @error('password') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-1 leading-tight focus:outline-none focus:shadow-outline" name="password" autocomplete="current-password">

          @error('password')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
          @enderror
        </div>

      <div class="flex items-center">
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Ingresar
        </button>
      </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
      &copy;{{ date('Y') }} FIS UNCP. Todos los Derechos Reservados.
    </p>
  </div>
</section>
@endsection
