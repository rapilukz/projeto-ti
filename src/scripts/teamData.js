$(document).ready(() => {
	fillTable();

	/*          <button class="btn btn-primary insert-button" onclick="showInserTeamModal()"><i class="fa fa-plus"></i>
                    Insert</button> */

	$("#team-table_length")
		.prepend(`<button class="btn btn-primary insert-button" onclick="showInserTeamModal()"><i class="fa fa-plus"></i>
	Insert</button> `);
});

function fillTable() {
	$("#team-table").DataTable({
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
		serverMethod: "POST",
		ajax: {
			url: "./includes/teams/team_list.inc.php",
		},
		columns: [
			{ data: "team_id" },
			{ data: "team_name" },
			{ data: "foundation_year" },
			{ data: "country" },
			{
				data: {
					id: "team_id",
					name: "team_name",
					foundation_year: "foundation_year",
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
	console.log(data);

	return `<button class='btn btn-primary btn-sm edit-button' onclick='showTeamEditModal(${data})'><i class='fa-solid fa-pencil'></i>Edit</button>
		<button class='btn btn-danger btn-sm delete-button' onclick='deleteTeam(${data});'><i class='fa-solid fa-trash-can'></i>Delete</button>`;
}

function deleteTeam(id) {
	if (!confirm("Do you want to delete this team?")) return false;

	$.ajax({
		url: "./includes/teams/team_delete.inc.php",
		method: "POST",
		dataType: "json",
		data: { id: id },
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

function showTeamEditModal(id) {
	document.querySelector(".modal-title").innerHTML = "Edit Team";
	const teamData = allTeams.find((team) => team.team_id.toString() === id);

	showModal();
	renderModalData(teamData);
}

function renderModalData(data) {
	console.log(data);
	/* $("#name").val(data.team_name);
	$("#foundation-year").val(data.foundation_year);
	$("#country").val(data.country);
	document.getElementById("modal").setAttribute("team-id", data.team_id);
	document.getElementById("edit-button").addEventListener("click", updateTeam); */
}

function clearModalData() {
	$("#name").val("");
	$("#foundation-year").val("");
	$("#country").val("");
	document.getElementById("modal").removeAttribute("team-id");
}

function updateTeam() {
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
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				const teams = await getTeams();
				populateTable(teams);
				closeModal();
				document
					.getElementById("edit-button")
					.removeEventListener("click", updateTeam);
				clearModalData();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}
function showInserTeamModal() {
	clearModalData();
	document.querySelector(".modal-title").innerHTML = "Insert Team";
	document.getElementById("edit-button").addEventListener("click", insertTeam);
	showModal();
}
function insertTeam() {
	document
		.getElementById("edit-button")
		.removeEventListener("click", insertTeam);

	const name = $("#name").val();
	const year = $("#foundation-year").val();
	const country = $("#country").val();

	$.ajax({
		url: "./includes/teams/team_insert.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			name: name,
			year: year,
			country: country,
		},
		success: async function (data) {
			if (data.status === "error") {
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				const teams = await getTeams();
				populateTable(teams);
				closeModal();
				document
					.getElementById("edit-button")
					.removeEventListener("click", insertTeam);
				clearModalData();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}
