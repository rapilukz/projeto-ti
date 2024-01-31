$(document).ready(() => {
	fillTable();

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
		rowId: "team_id",
		serverMethod: "POST",
		ajax: {
			url: "./includes/teams/team_list.inc.php",
		},
		columns: [
			{ data: "team_id", className: "id-row" },
			{ data: "team_name", className: "name-row" },
			{ data: "foundation_year", className: "year-row" },
			{ data: "country", className: "country-row" },
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
	return `<button id="row-${data.team_id}" class="btn btn-primary btn-sm edit-button" onclick='showTeamEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>
		<button id="row-${data.team_id}" class="btn btn-danger btn-sm delete-button" onclick='deleteTeam(event);'><i class='fa-solid fa-trash-can'></i>Delete</button>`;
}

function deleteTeam(event) {
	if (!confirm("Do you want to delete this team?")) return false;

	const id = $(event.target).attr("id").split("-")[1];

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
				$(event.target).closest("tr").remove();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function showTeamEditModal(event) {
	document.querySelector(".modal-title").innerHTML = "Edit Team";
	const id = $(event.target).attr("id").split("-")[1];

	const base = `#${id}`;

	const teamData = {
		id: id,
		name: $(`${base} td.name-row`).text(),
		year: $(`${base} td.year-row`).text(),
		country: $(`${base} td.country-row`).text(),
	};

	showModal();
	renderModalData(teamData);
}

function renderModalData(data) {
	$("#name").val(data.name);
	$("#foundation-year").val(data.year);
	$("#country").val(data.country);
	document.getElementById("modal").setAttribute("team-id", data.id);
	document.getElementById("edit-button").addEventListener("click", updateTeam);
}

function setNewData(data) {
	const id = data.id;
	const base = `#${id}`;

	$(`${base} td.name-row`).text(data.name);
	$(`${base} td.year-row`).text(data.year);
	$(`${base} td.country-row`).text(data.country);
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

	const updateData = {
		id: id,
		name: name,
		year: year,
		country: country,
	};

	$.ajax({
		url: "./includes/teams/team_update.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			id,
			name,
			year,
			country,
		},
		success: async function (data) {
			if (data.status === "error") {
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				setNewData(updateData);
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
