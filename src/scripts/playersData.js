$(document).ready(() => {
	fillTable();
	fillTeamsDropdown();

	$("#players-table_length")
		.prepend(`<button class="btn btn-primary insert-button" onclick="showInserPlayerModal()"><i class="fa fa-plus"></i>
    Insert</button> `);
});

function fillTable() {
	$("#players-table").DataTable({
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
		rowId: "player_id",
		serverMethod: "POST",
		ajax: {
			url: "./includes/players/player_list.inc.php",
		},
		columns: [
			{ data: "player_id", className: "id-row" },
			{ data: "player_name", className: "name-row" },
			{ data: "position", className: "position-row" },
			{ data: "birthdate", className: "birthdate-row" },
			{ data: "team_name", className: "team-row" },
			{
				data: {
					player_id: "player_id",
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
	return `<button id="row-${data.player_id}" class="btn btn-primary btn-sm edit-button" onclick='showEditPlayerModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>
		<button id="row-${data.player_id}" class="btn btn-danger btn-sm delete-button" onclick='deletePlayer(event);'><i class='fa-solid fa-trash-can'></i>Delete</button>`;
}

function deletePlayer(event) {
	if (!confirm("Do you want to delete this player?")) return false;

	const id = $(event.target).attr("id").split("-")[1];

	$.ajax({
		url: "./includes/players/player_delete.inc.php",
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

function showInserPlayerModal() {
	clearModalData();
	document.querySelector(".modal-title").innerHTML = "Insert Team";
	document
		.getElementById("edit-button")
		.addEventListener("click", insertPlayer);
	showModal();
}

function showEditPlayerModal(event) {
	document.querySelector(".modal-title").innerHTML = "Edit Team";
	const id = $(event.target).attr("id").split("-")[1];

	const base = `#${id}`;
	const playerData = {
		id: id,
		name: $(`${base} td.name-row`).text(),
		position: $(`${base} td.position-row`).text(),
		birthdate: $(`${base} td.birthdate-row`).text(),
		team: $(`${base} td.team-row`).text(),
	};

	showModal();
	renderModalData(playerData);
}

function renderModalData(data) {
	$("#player-name").val(data.name);
	$("#player-position").val(data.position);
	$("#player-birthdate").val(data.birthdate);
	$("#team").val(data.team);
	document.getElementById("modal").setAttribute("player-id", data.id);
	document
		.getElementById("edit-button")
		.addEventListener("click", updatePlayer);
}

function clearModalData() {
	$("#player-name").val("");
	$("#player-position").val("");
	$("#player-birthdate").val("");
	$("#team").val("");
}

function updatePlayer() {
	const id = $("#modal").attr("player-id");
	const name = $("#player-name").val();
	const position = $("#player-position").val();
	const birthdate = $("#player-birthdate").val();
	const team = $("#team").val();

	const updateData = {
		id: id,
		name: name,
		position: position,
		birthdate: birthdate,
		team: team,
	};

	$.ajax({
		url: "./includes/players/player_update.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			id,
			name,
			position,
			birthdate,
			team,
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
					.removeEventListener("click", updatePlayer);
				clearModalData();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function insertPlayer() {
	document
		.getElementById("edit-button")
		.removeEventListener("click", insertPlayer);

	const name = $("#player-name").val();
	const position = $("#player-position").val();
	const birthdate = $("#player-birthdate").val();
	const team = $("#team").val();

	$.ajax({
		url: "./includes/players/player_insert.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			name: name,
			position: position,
			birthdate: birthdate,
			team: team,
		},
		success: async function (data) {
			if (data.status === "error") {
				renderModalErrors(data.message);
			}
			if (data.status == "success") {
				insertNewRow(data.message);
				closeModal();
				document
					.getElementById("edit-button")
					.removeEventListener("click", insertPlayer);
				clearModalData();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function insertNewRow(data) {
	const table = $("#players-table").DataTable();

	// Add a new row to the DataTable
	const newRowData = {
		player_id: data.player_id,
		player_name: data.player_name,
		position: data.position,
		birthdate: data.birthdate,
		team_name: data.team_name,
	};

	table.row.add(newRowData).draw().node();
}

function setNewData(data) {
	const id = data.id;
	const base = `#${id}`;

	$(`${base} td.name-row`).text(data.name);
	$(`${base} td.position-row`).text(data.position);
	$(`${base} td.birthdate-row`).text(data.birthdate);
	$(`${base} td.team-row`).text(data.team);
}
