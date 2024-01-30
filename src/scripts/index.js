function getUsers() {
	const tableBody = $("#user-table tbody");

	$.ajax({
		type: "POST",
		url: "./includes/user/user_list.inc.php",
		dataType: "json",
		success: function (response) {
			response.forEach((row) => {
				let newRow = $(`<tr data-user-id=` + row.user_id + `>`);

				// Populate the row with user data
				newRow.append(
					"<th class='text-white' scope='row'>" + row.user_id + "</th>"
				);
				newRow.append("<td class='text-white'>" + row.username + "</td>");
				newRow.append("<td class='text-white'>" + row.email + "</td>");
				newRow.append("<td class='text-white'>" + row.birthdate + "</td>");

				// Add an Edit and Delete button for each user
				newRow.append(
					"<td><button class='btn btn-primary btn-sm edit-button'><i class='fa-solid fa-pencil'></i>Edit</button></td>"
				);
				// Prevents deleting the current user
				if (row.same_user) {
					newRow.append(`<td></td>`);
				} else {
					newRow.append(
						`<td><button class='btn btn-danger btn-sm delete-button' onclick='deleteUser(${row.user_id})'><i class='fa-solid fa-trash-can'></i>Delete</button></td>`
					);
				}

				// Append the row to the table
				tableBody.append(newRow);
			});
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function deleteUser(user_id) {
	if (!confirm("Do you want to delete this user?")) return false;

	$.ajax({
		url: "./includes/user/user_delete.inc.php",
		method: "POST",
		dataType: "json",
		data: { id: user_id },
		success: function (data) {
			console.log(data);
			if (data.status == "success") {
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
