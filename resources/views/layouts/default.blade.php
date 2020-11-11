<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('includes.head')

    <body>
        @include('includes.header')

        <div class="container content">
            @include('includes.form')
            @include('includes.list')
        </div>
    </body>
</html>
