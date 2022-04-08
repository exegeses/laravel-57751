@include( 'layouts.header' )
@include( 'layouts.nav' )

    <main class="container py-4">
        @yield('contenido')
        @yield('contenidox')

    </main>

@include( 'layouts.footer' )
