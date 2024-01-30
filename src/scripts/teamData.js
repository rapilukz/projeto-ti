let allTeams = [];

$(document).ready(() => {
	fillTeamsTable();
});

function getTeams() {
	return new Promise(function (resolve, reject) {
		$.ajax({
			type: "POST",
			url: "./includes/teams/team_list.inc.php",
			dataType: "json",
			success: function (response) {
				allTeams = response;
				resolve(response);
			},
			error: function (xhr, status, error) {
				console.error("Error: " + status);
				reject(error);
			},
		});
	});
}

async function fillTeamsTable() {
	// Use the global variable instead of calling getUsers directly
	const teams = await getTeams();
	populateTable(teams);
}

function populateTable(data) {
	clearTable();
	const tableBody = $("#team-table tbody");

	data.forEach((row) => {
		let newRow = $(`<tr data-user-id=` + row.team_id + `>`);

		// Populate the row with user data
		newRow.append(
			"<th class='text-white' scope='row'>" + row.team_id + "</th>"
		);
		newRow.append("<td class='text-white'>" + row.team_name + "</td>");
		newRow.append("<td class='text-white'>" + row.foundation_year + "</td>");
		newRow.append("<td class='text-white'>" + row.country + "</td>");

		// Add an Edit and Delete button for each user
		newRow.append(
			`<td><button class='btn btn-primary btn-sm edit-button' onclick='showUseEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button></td>`
		);

		newRow.append(
			`<td><button class='btn btn-danger btn-sm delete-button' onclick='deleteUser(event);'><i class='fa-solid fa-trash-can'></i>Delete</button></td>`
		);

		// Append the row to the table
		tableBody.append(newRow);
	});
}

function clearTable() {
	$("#team-table tbody").empty();
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

	const filteredTeams = allTeams.filter((team) => {
		return (
			team.team_name.toLowerCase().includes(searchText) ||
			team.foundation_year.toString().toLowerCase().includes(searchText) ||
			team.country.toLowerCase().includes(searchText)
		);
	});

	// Update the table with the filtered users
	debouncedPopulateTable(filteredTeams);
}
