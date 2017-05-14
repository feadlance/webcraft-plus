<script type="text/javascript">
	window.WebcraftPlus = {!! json_encode([
		'csrfToken' => csrf_token()
	]) !!};

	function swalConfirm(title = null, text = null, confirmText = null, type = 'warning') {
		return swal({
		    title: title ? title : '{{ __('Emin misiniz?') }}',
		    text: text ? text : "{{ __('Bu işlemi daha sonra geri alamazsınız') }}",
		    type: type,
		    showCancelButton: true,
		    confirmButtonColor: '#3085d6',
		    cancelButtonColor: '#d33',
		    confirmButtonText: confirmText ? confirmText : '{{ __('Sil') }}',
		    cancelButtonText: '{{ __('Vazgeç') }}'
		});
	}

	function swalSuccess(body, title = '{{ __('Tamam!') }}') {
		return swal(title, body, 'success');
	}

	function swalError(body, title = '{{ __('Hata!') }}') {
		return swal(title, body, 'error');
	}

	function sl2AddIcon(opt) {
		if ( !opt.id ) {
			return opt.text;
		}

		var optImage = $(opt.element).data('image');

		if ( !optImage ) {
			return opt.text;
		}

		return $(
			'<span><img src="' + optImage + '" class="select2-img" /> ' + $(opt.element).text() + '</span>'
		);
	}

	$(function () {
		$('tr.link td.clickable').on('click', function () {
			window.location.href = $(this).parent().data('href');
		});
	});
</script>