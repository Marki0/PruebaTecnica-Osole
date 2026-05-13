@if (session('status'))
    <div class="admin-flash admin-flash--ok" role="status">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="admin-flash admin-flash--err" role="alert">
        <strong>Revisá los datos:</strong>
        <ul style="margin:0.35rem 0 0 1.1rem;padding:0;">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
