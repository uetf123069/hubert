@if(isset($response))
<div class="alert alert-dismissable alert-{{ $response->success ? 'success' : 'danger' }}">
	<i class="fa fa-fw fa-check"></i>&nbsp; <strong>Success!</strong> $response->message
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
</div>
@endif