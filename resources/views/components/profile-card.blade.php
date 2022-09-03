@props(['profile'])

<x-card>
  <div class="flex">
    <img class="hidden w-48 mr-6 md:block"
      src="{{$profile->logo ? asset('storage/' . $profile->picture) : asset('/images/no-image.png')}}" alt="" />
    <div>
      <x-listings-tags :tagsCsv="$profile->tags" />
      <div class="text-lg mt-4">
        <i class="fa-solid fa-location-dot"></i> {{$profile->location}}
      </div>
    </div>
  </div>
</x-card>