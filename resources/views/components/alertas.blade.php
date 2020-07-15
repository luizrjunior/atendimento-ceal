@if(session()->get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
        </svg>
        Alerta!
    </h5>
    {{ session()->get('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-shield-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.357 3.478c-.42 3.969.87 6.928 2.423 8.911a11.192 11.192 0 0 0 2.417 2.3c.371.256.715.451 1.007.586.27.124.558.225.796.225s.527-.101.796-.225c.292-.135.636-.33 1.007-.586.466-.32.983-.74 1.502-1.263L1.357 3.478zm11.787 7.545c1.145-1.984 1.902-4.644 1.444-8a1.454 1.454 0 0 0-1.003-1.183 61.09 61.09 0 0 0-2.772-.815C9.77.749 8.663.5 8 .5c-.662 0-1.77.249-2.813.525-.548.145-1.1.303-1.59.45l9.547 9.548z"/>
            <path fill-rule="evenodd" d="M14.646 15.354l-14-14 .708-.708 14 14-.707.707z"/>
        </svg>
        Erro!
    </h5>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
