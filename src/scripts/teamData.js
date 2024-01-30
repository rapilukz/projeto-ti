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
		let newRow = $(`<tr data-team-id=` + row.team_id + `>`);

		// Populate the row with team data
		newRow.append(
			"<th class='text-white' scope='row'>" + row.team_id + "</th>"
		);
		newRow.append("<td class='text-white'>" + row.team_name + "</td>");
		newRow.append("<td class='text-white'>" + row.foundation_year + "</td>");
		newRow.append("<td class='text-white'>" + row.country + "</td>");

		// Add an Edit and Delete button for each team
		newRow.append(
			`<td><button class='btn btn-primary btn-sm edit-button' onclick='showTeamEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button></td>`
		);

		newRow.append(
			`<td><button class='btn btn-danger btn-sm delete-button' onclick='deleteTeam(event);'><i class='fa-solid fa-trash-can'></i>Delete</button></td>`
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

	// Update the table with the filtered teams
	debouncedPopulateTable(filteredTeams);
}

function getTeamId(event) {
	return $(event.target).closest("tr").attr("data-team-id");
}

function deleteTeam(event) {
	if (!confirm("Do you want to delete this team?")) return false;

	const team_id = getTeamId(event);

	$.ajax({
		url: "./includes/teams/team_delete.inc.php",
		method: "POST",
		dataType: "json",
		data: { id: team_id },
		success: function (data) {
			if (data.status == "error") {
				console.log(data);
			}

			if (data.status == "success") {
				allTeams = allTeams.filter((team) => team.team_id !== team_id);

				$("#team-table tbody")
					.find("tr[data-team-id='" + team_id + "']")
					.remove();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function showTeamEditModal(event) {
	const team_id = getTeamId(event);
	const teamData = allTeams.find((team) => team.team_id.toString() === team_id);

	showModal();
	renderModalData(teamData);
}

function renderModalData(data) {
	$("#name").val(data.team_name);
	$("#foundation-year").val(data.foundation_year);
	$("#country").val(data.country);
	document.getElementById("modal").setAttribute("team-id", data.team_id);
}

function updateTeam() {
	const errors = $("#errors");
	errors.empty();

	const id = $("#modal").attr("team-id");
	const name = $("#name").val();
	const year = $("#foundation-year").val();
	const country = $("#country").val();

	$.ajax({
		url: "./includes/teams/team_update.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			id: id,
			name: name,
			year: year,
			country: country,
		},
		success: async function (data) {
			if (data.status === "error") {
				data.message.forEach((error) => {
					const html = `<div class="form-error text-danger">${error}</div>`;

					errors.append(html);
				});
			}
			if (data.status == "success") {
				const teams = await getTeams();
				populateTable(teams);
				closeModal();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}
