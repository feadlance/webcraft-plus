<script type="text/javascript">
	window.WebcraftPlus = {!! json_encode([
		'csrfToken' => csrf_token()
	]) !!};

	function swalConfirm() {
		return swal({
		    title: '{{ __('Emin misiniz?') }}',
		    text: "{{ __('Bu işlemi daha sonra geri alamazsınız') }}",
		    type: 'warning',
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: '{{ __('Sil') }}',
		    cancelButtonText: '{{ __('Vazgeç') }}'
		});
	}

	function swalSuccess(body, title = '{{ __('Tamam!') }}') {
		return swal(title, body, 'success');
	}

	function swalError(body, title = '{{ __('Hata!') }}') {
		return swal(title, body, 'error');
	}

	{!! settings('lebby.google.analytics') !!}
</script>