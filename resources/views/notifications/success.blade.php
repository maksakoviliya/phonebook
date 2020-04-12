@if(session()->has('success'))
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <i class="material-icons">close</i>
    </button>
    <span>{{session('success')}}</span>
  </div>
@endif