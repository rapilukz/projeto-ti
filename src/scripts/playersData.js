$(document).ready(() => {
	fillTable();

	$("#players-table_length")
		.prepend(`<button class="btn btn-primary insert-button" onclick="showInserTeamModal()"><i class="fa fa-plus"></i>
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
	return `<button id="row-${data.player_id}" class="btn btn-primary btn-sm edit-button" onclick='showTeamEditModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>
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
