<div class="py-10 bg-gray-100">
    <div class="max-w-7xl px-4 py-8 mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded-lg">

        <!-- Title Section -->
        <div class="flex justify-center mb-6 pt-6">
            <h1 class="text-3xl font-extrabold text-gray-800 text-center">
                {{$article->title}}
            </h1>
        </div>
        <!-- Image Section -->
        <div class="flex justify-center mb-6">
            <img class="w-1/2 object-cover rounded-t-lg border border-gray-50"
                src="{{ $article->imageUrl() }}" alt="{{ $article->title }}" />
        </div>


        <!-- Content Section -->
        <div class="prose prose-lg max-w-none">
            {!! $article->content !!}
        </div>

        <!-- Back Link -->
        <div class="flex justify-end mt-8 pt-2 border-t-2">
            <a href="{{route('articles.index')}}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                &larr; Go Back
            </a>
        </div>
    </div>
</div>
