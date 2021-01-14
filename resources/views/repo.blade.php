@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-info" style="display: none"></div>
            <div class="card">
                <div class="card-header">{{ __('Repositories') }}</div>
                <p>Total: {{ count($repos) }}</p>
                <div class="card-body">
                    <p>Username: {{ auth()->user()->name }}</p>
                    <div class="col-12">
                        <ul class="list-group">
                        @foreach($repos as $key => $r)
                        <li class="list-group-item">
                          <div class="name">{{ $r->repo_name }}</div>
                          <div class="right">
                            @if (!$r->repo_fork_url)
                            <button type="submit"
                                <?=($r->is_progress ? 'disabled' : '')?>
                                class="btn btn-primary" onclick="forkRepo(event, '{{ $r->id}}')">
                                fork
                            </button>
                            @else
                            <a target="_blank" href="{{ $r->repo_fork_url}}" class="btn btn-primary">repo</a>
                            @endif
                          </div>
                        </li>
                        @endforeach
                        </ul>
                        <div class="pg">
                            {{ $repos }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
function forkRepo(event, id) {
    $(event.target).attr('disabled', true)
    const url = "{{ route('fork')}}"
    const data = {
        id: id,
        csrf_token: "{{ csrf_token() }}"
    }
    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: data,
        success: function(res) {
            console.log(res)
        }
    })
}
</script>
@endsection
