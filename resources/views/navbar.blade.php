<nav class="navbar navbar-light bg-light">
    <form class="form-inline">
        <a href="{{ route('book.index') }}"><button class="btn btn-sm btn-outline-secondary" type="button">Books list</button></a>
        @role('admin')
            <a href="{{ route('user.index') }}"><button class="btn btn-sm btn-outline-secondary" type="button">Users list</button></a>
        @endrole
    </form>
</nav>
