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

function getSession() {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: "./includes/get_session.inc.php",
			method: "POST",
			dataType: "json",
			success: function (data) {
				if (data.status == "error") {
					reject(data);
				}

				if (data.status == "success") {
					resolve(data.message);
				}
			},
			error: function (xhr, status, error) {
				console.error("Error: " + status);
				reject(error);
			},
		});
	});
}

function fillTeamsDropdown() {
	const teamInput = $("#team");

	$.ajax({
		url: "./includes/players/player_teams.inc.php",
		method: "POST",
		dataType: "json",
		success: function (data) {
			if (data.status == "error") {
				console.log(data);
			}

			if (data.status == "success") {
				const options = data.message;
				options.forEach((option) => {
					const optionHtml = $("<option>")
						.text(option.team_name)
						.val(option.team_name);
					teamInput.append(optionHtml);
				});
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}
