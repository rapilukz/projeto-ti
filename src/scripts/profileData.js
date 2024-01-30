const userId = $(".card-body").attr("data-user-id");

async function getUserData() {
	return new Promise(function (resolve, reject) {
		$.ajax({
			type: "POST",
			url: "../includes/user/user_data.inc.php",
			dataType: "json",
			data: { id: userId },
			success: function (response) {
				resolve(response.message);
			},
			error: function (xhr, status, error) {
				console.error("Error: " + status);
				reject(error);
			},
		});
	});
}

async function showProfileModal() {
	showModal();

	const data = await getUserData();
	printDataToModal(data);
}

function printDataToModal(data) {
	$("#username").val(data.username);
	$("#email").val(data.email);
	$("#birthdate").val(data.birthdate);
}

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

function updateUserProfile() {
	const errors = $("#errors");
	errors.empty();

	const username = $("#username").val();
	const email = $("#email").val();
	const birthdate = $("#birthdate").val();

	const data = {
		id: userId,
		username: username,
		email: email,
		birthdate: birthdate,
	};

	$.ajax({
		url: "../includes/user/profile_update.inc.php",
		method: "POST",
		dataType: "json",
		data: data,
		success: async function (response) {
			if (response.status === "error") {
				response.message.forEach((error) => {
					const html = `<div class="form-error text-danger">${error}</div>`;

					errors.append(html);
				});
			}
			if (response.status == "success") {
				updateProfileData(data);
				closeModal();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function updateProfileData(data) {
	$("#profile-username").text(data.username);
	$("#profile-main-username").text(data.username);
	$("#profile-email").text(data.email);
	$("#profile-birthdate").text(data.birthdate);
}
