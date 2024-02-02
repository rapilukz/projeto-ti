function showProfileModal() {
	const userData = {
		username: $(`#profile-username`).text().trim(),
		email: $(`#profile-email`).text().trim(),
		birthdate: $(`#profile-birthdate`).text().trim(),
	};

	showModal();
	renderModalData(userData);
}

function renderModalData(data) {
	$("#username").val(data.username);
	$("#email").val(data.email);
	$("#birthdate").val(data.birthdate);
	document.getElementById("modal").setAttribute("user-id", data.user_id);
}

async function updateUser() {
	const id = await getUserId();
	const username = $("#username").val();
	const email = $("#email").val();
	const birthdate = $("#birthdate").val();

	const newData = {
		id,
		username,
		email,
		birthdate,
	};

	$.ajax({
		url: "../includes/user/profile_update.inc.php",
		method: "POST",
		dataType: "json",
		data: newData,
		success: async function (data) {
			if (data.status === "error") {
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				setNewData(newData);
				closeModal();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function setNewData(data) {
	$(`#profile-main-username`).text(data.username);
	$(`#profile-username`).text(data.username);
	$(`#profile-email`).text(data.email);
	$(`#profile-birthdate`).text(data.birthdate);
}

function getUserId() {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: "../includes/user/profile_id.inc.php",
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
