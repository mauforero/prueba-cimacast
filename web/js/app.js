$(document).ready(function initializeApp() {
	$('#imageModal').on('show.bs.modal', function modalShownCallback(event) {
		var link = $(event.relatedTarget);
		var number = link.data('number');
		var modal = $(this);

		modal.find('#title-number').text(number);
		modal.find('.modal-body').text('Cargando...');

		$.get(Routing.generate('getNumberImage', { number: number }), function getNumberImageCallback(response) {
			modal.find('.modal-body').html(response);
			modal.modal('handleUpdate');
		});
	});
});