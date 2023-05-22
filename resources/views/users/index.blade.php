@extends('layouts.app')

@section('content')

<div id="myModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
  <div class="flex items-center justify-center min-h-screen">
    <div class="relative bg-white w-80 rounded-lg shadow-lg">
      <div class="absolute top-0 right-0 pt-2 pr-2">
        <button id="closeModal" class="text-gray-700 hover:text-gray-900">
          <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
            <path
              d="M6.707 6.293a1 1 0 0 1 1.414 0L12 10.586l3.879-3.88a1 1 0 1 1 1.414 1.414L13.414 12l3.879 3.88a1 1 0 1 1-1.414 1.414L12 13.414l-3.879 3.88a1 1 0 1 1-1.414-1.414L10.586 12 6.707 8.121a1 1 0 0 1 0-1.414z" />
          </svg>
        </button>
      </div>
      <div class="p-8">
      <div className="py-2 text-left">
      <input type="email" className="bg-gray-200 border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
        placeholder="Email"
        required
        />
      </div>
      <div className="py-2 text-left">
      <input type="text" className="bg-gray-200 border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
        placeholder="Name"
        required
        />
      </div>
      <div className="py-2 text-left">
      <input type="text" className="bg-gray-200 border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
        placeholder="username"
        required
        />
      </div>
      <div className="py-2 text-left">
      <input type="password" className="bg-gray-200 border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
        placeholder="Password"
        required
        />
      </div>
      <div className="py-2 text-left">
      <input type="password" className="bg-gray-200 border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
        placeholder="Confirm Password"
        required
        />
      </div>
        <!-- Modal content goes here -->
      </div>
    </div>
  </div>
</div>



<div class="grid justify-items-end mr-5 mt-3">
<button id="add-user" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
  Add User
</button>
</div>

<div class="flex justify-center mt-5">
    <div class="overflow-x-auto">
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('user.show', $user->id) }}">{{ $user->email }}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<script>
  const modal = document.getElementById("myModal");
  const btn = document.getElementById("add-user");
  const closeBtn = document.getElementById("closeModal");

  btn.addEventListener("click", () => {
    modal.classList.remove("hidden");
    // Add a blur effect to the rest of the page
    document.body.classList.add("modal-open");
  });

  closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
    // Remove the blur effect from the page
    document.body.classList.remove("modal-open");
  });
</script>

@endsection
