@if (session('response'))
<div class="alert alert-dismissable alert-{{ session('response')->success ? 'success' : 'danger' }}">
	@if(session('response')->success)
		<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Success!</strong> 
	@else
		<i class="fa fa-fw fa-times"></i>&nbsp; <strong>Oh snap!</strong>
	@endif
	{{ session('response')->message }}
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
</div>
@endif