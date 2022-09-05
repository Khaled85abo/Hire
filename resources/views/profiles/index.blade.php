<x-layout>
  @if (!Auth::check())
    @include('partials._hero')
  @endif

  @include('partials._search-profiles')

  <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

    @unless(count($profiles) == 0)

    @foreach($profiles as $profile)
    <x-profile-card :profile="$profile" />
    @endforeach

    @else
    <p>No profiles found</p>
    @endunless

  </div>

  <div class="mt-6 p-4">
    {{$profiles->links()}}
  </div>
</x-layout>
