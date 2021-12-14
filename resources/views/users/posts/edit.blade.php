<x-layout>
    <x-setting :heading="'Edit Post: ' . $post->title">
        <form method="POST" action="{{  route('user-post-update', ['post' => $post->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="post_id" value="{{ $post->id }}">

            <x-form.input name="title" :value="old('title', $post->title)" required />
            <x-form.input name="slug" :value="old('slug', $post->slug)" required />

            <div class="flex mt-6">
                <div class="flex-1">
                    <x-form.input name="thumbnail" type="file" :value="old('thumbnail', $post->thumbnail)" />
                </div>

                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="" class="rounded-xl ml-6" width="100">
            </div>

            <x-form.textarea name="excerpt" required>{{ old('excerpt', $post->excerpt) }}</x-form.textarea>
            <x-form.textarea name="body" required>{{ old('body', $post->body) }}</x-form.textarea>

            <x-form.button>Update</x-form.button>
        </form>
    </x-setting>
</x-layout>
