// Global variable to store all users
let allUsers = [];
const roleOptions = ["user", "admin"];

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

// Other functions remain unchanged...
async function fillUsersTable() {
	// Use the global variable instead of calling getUsers directly
	const users = await getUsers();
	populateTable(users);
}

function deleteUser(event) {
	if (!confirm("Do you want to delete this user?")) return false;

	const user_id = getUserId(event);

	$.ajax({
		url: "./includes/user/user_delete.inc.php",
		method: "POST",
		dataType: "json",
		data: { id: user_id },
		success: function (data) {
			if (data.status == "success") {
				// Update the global variable by removing the deleted user
				allUsers = allUsers.filter((user) => user.user_id !== user_id);

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

function getUserId(event) {
	return $(event.target).closest("tr").attr("data-user-id");
}

function showUseEditModal(event) {
	const user_id = getUserId(event);
	const userData = allUsers.find((user) => user.user_id.toString() === user_id);

	showModal();
	renderModalData(userData);
}

function renderModalData(data) {
	const roleInput = $("#role");

	$("#username").val(data.username);
	$("#foundation-year").val(data.email);
	$("#birthdate").val(data.birthdate);
	document.getElementById("modal").setAttribute("user-id", data.user_id);

	roleInput.empty(); // Clear existing options

	roleOptions.forEach((role) => {
		const option = $("<option>").text(role).val(role);
		roleInput.append(option);
	});
	roleInput.val(data.role);
}

function populateTable(data) {
	clearTable();
	const tableBody = $("#user-table tbody");
	data.forEach((row) => {
		let newRow = $(`<tr data-user-id=` + row.user_id + `>`);

		// Populate the row with user data
		newRow.append(
			"<th class='text-white' scope='row'>" + row.user_id + "</th>"
		);
		newRow.append("<td class='text-white'>" + row.username + "</td>");
		newRow.append("<td class='text-white'>" + row.email + "</td>");
		newRow.append("<td class='text-white'>" + row.birthdate + "</td>");
		newRow.append("<td class='text-white'>" + row.role + "</td>");

		// Add an Edit and Delete button for each user
		newRow.append(
			`<td><button class='btn btn-primary btn-sm edit-button' onclick='showUseEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button></td>`
		);
		// Prevents deleting the current user
		if (row.same_user) {
			newRow.append(`<td></td>`);
		} else {
			newRow.append(
				`<td><button class='btn btn-danger btn-sm delete-button' onclick='deleteUser(event);'><i class='fa-solid fa-trash-can'></i>Delete</button></td>`
			);
		}

		// Append the row to the table
		tableBody.append(newRow);
	});
}

function clearTable() {
	$("#user-table tbody").empty();
}

function debounce(func, delay) {
	let timeoutId;
	return function () {
		const context = this;
		const args = arguments;
		clearTimeout(timeoutId);
		timeoutId = setTimeout(() => {
			func.apply(context, args);
		}, delay);
	};
}

const debouncedPopulateTable = debounce(populateTable, 300);

function searchTable() {
	const searchText = $("#search").val().toLowerCase();

	const filteredUsers = allUsers.filter((user) => {
		return (
			user.username.toLowerCase().includes(searchText) ||
			user.email.toLowerCase().includes(searchText) ||
			user.birthdate.toLowerCase().includes(searchText)
		);
	});

	// Update the table with the filtered users
	debouncedPopulateTable(filteredUsers);
}

function updateUser() {
	const errors = $("#errors");
	errors.empty();

	const id = $("#modal").attr("user-id");
	const username = $("#username").val();
	const email = $("#email").val();
	const birthdate = $("#birthdate").val();
	const role = $("#role").val();

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
				data.message.forEach((error) => {
					const html = `<div class="form-error text-danger">${error}</div>`;

					errors.append(html);
				});
			}
			if (data.status == "success") {
				const users = await getUsers();
				populateTable(users);
				closeModal();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}
