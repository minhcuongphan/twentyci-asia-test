<x-layout>
    <x-setting heading="Publish New Post">
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif
        <form method="POST" action="{{ route('user-post-store') }}" enctype="multipart/form-data">
            @csrf

            <x-form.input name="title" required />
            <x-form.error name="title"/>

            <x-form.input name="slug" required />
            <x-form.error name="slug"/>

            <x-form.input name="thumbnail" type="file" required />
            <x-form.error name="thumbnail"/>

            <x-form.textarea name="excerpt" required />
            <x-form.error name="excerpt"/>

            <x-form.textarea name="body" required />
            <x-form.error name="body"/>

            <x-form.button>Publish</x-form.button>
        </form>
    </x-setting>
</x-layout>
