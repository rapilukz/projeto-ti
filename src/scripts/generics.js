function showModal() {
	const errors = $("#errors");
	errors.empty();

	const modal = new bootstrap.Modal(document.getElementById("modal"), {});
	modal.show();
}

function closeModal() {
	const modalId = document.getElementById("modal");
	const modal = bootstrap.Modal.getInstance(modalId);

	modal.hide();
}

function renderModalErrors(errors) {
	const html = $("#errors");
	html.empty();

	errors.forEach((error) => {
		const errorHtml = `<div class="form-error text-danger">${error}</div>`;

		html.append(errorHtml);
	});
}
