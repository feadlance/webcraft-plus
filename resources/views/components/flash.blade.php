@if ( Session::has('flash.error') )
	<script type="text/javascript">
		swalError('{{ session('flash.error') }}');
	</script>
@endif

@if ( Session::has('flash.success') )
	<script type="text/javascript">
		swalSuccess('{{ session('flash.success') }}');
	</script>
@endif

@if ( Session::has('flash.info') )
	<script type="text/javascript">
		swal('Hey!', '{{ session('flash.info') }}', 'info');
	</script>
@endif

@if ( Session::has('flash.warning') )
	<script type="text/javascript">
		swal('Hop!', '{{ session('flash.warning') }}', 'warning');
	</script>
@endif

@if ( Session::has('status') )
	<script type="text/javascript">
		swal('', '{{ session('status') }}');
	</script>
@endif