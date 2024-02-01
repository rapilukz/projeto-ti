// Global variable to store all users
let allUsers = [];
const roleOptions = ["user", "admin"];

$(document).ready(() => {
	fillTable();
});

async function getUsers() {
	return new Promise(function (resolve, reject) {
		$.ajax({
			type: "POST",
			url: "./includes/user/user_list.inc.php",
			dataType: "json",
			success: function (response) {
				// Update the global variable with the fetched users
				allUsers = response;
				resolve(response);
			},
			error: function (xhr, status, error) {
				console.error("Error: " + status);
				reject(error);
			},
		});
	});
}

function fillTable() {
	$("#user-table").DataTable({
		lengthMenu: [
			[-1, 3, 5, 10],
			["All", 3, 5, 10],
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sLengthMenu: "_MENU_",
		},
		processing: true,
		serverSide: true,
		rowId: "user_id",
		serverMethod: "POST",
		ajax: {
			url: "./includes/user/user_list.inc.php",
		},
		columns: [
			{ data: "user_id", className: "id-row" },
			{ data: "username", className: "username-row" },
			{ data: "email", className: "email-row" },
			{ data: "birthdate", className: "birthdate-row" },
			{ data: "role", className: "role-row" },
			{
				data: {
					id: "user_id",
					username: "username",
					email: "email",
					country: "contry",
				},
				render: function (data) {
					return renderButtons(data);
				},
				className: "actions-row",
			},
		],
	});
}

function renderButtons(data) {
	if (data.same_user) {
		return `<button id="row-${data.user_id}" class="btn btn-primary btn-sm edit-button" onclick='showUseEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>`;
	} else {
		return `<button id="row-${data.user_id}"  class="btn btn-primary btn-sm edit-button" onclick='showUseEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>
		<button id="${data.user_id}"  class="btn btn-danger btn-sm delete-button" onclick='deleteUser(event);'><i class='fa-solid fa-trash-can'></i>Delete</button>`;
	}
}

function deleteUser(event) {
	if (!confirm("Do you want to delete this user?")) return false;

	const user_id = $(event.target).attr("id").split("-")[1];

	$.ajax({
		url: "./includes/user/user_delete.inc.php",
		method: "POST",
		dataType: "json",
		data: { id: user_id },
		success: function (data) {
			if (data.status == "success") {
				// Update the global variable by removing the deleted user

				$("#user-table tbody")
					.find("tr[data-user-id='" + user_id + "']")
					.remove();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function showUseEditModal(event) {
	const id = $(event.target).attr("id").split("-")[1];
	console.log(id);
	const base = `#${id}`;

	const userData = {
		user_id: id,
		username: $(`${base} td.username-row`).text(),
		email: $(`${base} td.email-row`).text(),
		birthdate: $(`${base} td.birthdate-row`).text(),
		role: $(`${base} td.role-row`).text(),
	};

	showModal();
	renderModalData(userData);
}

function renderModalData(data) {
	const roleInput = $("#role");

	$("#username").val(data.username);
	$("#email").val(data.email);
	$("#birthdate").val(data.birthdate);
	document.getElementById("modal").setAttribute("user-id", data.user_id);

	roleInput.empty(); // Clear existing options

	roleOptions.forEach((role) => {
		const option = $("<option>").text(role).val(role);
		roleInput.append(option);
	});
	roleInput.val(data.role);
}

function updateUser() {
	const errors = $("#errors");
	errors.empty();

	const id = $("#modal").attr("user-id");
	const username = $("#username").val();
	const email = $("#email").val();
	const birthdate = $("#birthdate").val();
	const role = $("#role").val();

	const updateData = {
		id: id,
		username: username,
		email: email,
		birthdate: birthdate,
		role: role,
	};

	$.ajax({
		url: "./includes/user/user_update.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			id: id,
			username: username,
			email: email,
			birthdate: birthdate,
			role,
		},
		success: async function (data) {
			if (data.status === "error") {
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				setNewData(updateData);
				closeModal();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function setNewData(data) {
	const id = data.id;
	const base = `#${id}`;

	console.log($(`${base} td.username-row`));
	$(`${base} td.username-row`).text(data.username);
	$(`${base} td.email-row`).text(data.email);
	$(`${base} td.birthdate-row`).text(data.birthdate);
	$(`${base} td.role-row`).text(data.role);
}
