<x-layout>
    <x-setting heading="Publish New Post">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <x-form.input name="title" required />
            <x-form.input name="slug" required />
            <x-form.input name="thumbnail" type="file" required />
            <x-form.textarea name="excerpt" required />
            <x-form.textarea name="body" required />
            <x-form.field>
                <x-form.label name="status"/>

                <select name="status" id="status" required>
                    @foreach (config('helper.status') as $key => $item)
                        <option
                            value="{{ $key }}"
                            {{ old('status') == $key ? 'selected' : '' }}
                        >{{ $item }}</option>
                    @endforeach
                </select>

                <x-form.error name="status"/>
            </x-form.field>
            <x-form.button>Publish</x-form.button>
        </form>
    </x-setting>
</x-layout>
