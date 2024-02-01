$(document).ready(() => {
	fillTable();
	fillTeamsDropdown();

	$("#trainer-table_length")
		.prepend(`<button class="btn btn-primary insert-button" onclick="showInserTrainerModal()"><i class="fa fa-plus"></i>
    Insert</button> `);
});

function fillTable() {
	$("#trainer-table").DataTable({
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
		rowId: "trainer_id",
		serverMethod: "POST",
		ajax: {
			url: "./includes/trainers/trainer_list.inc.php",
		},
		columns: [
			{ data: "trainer_id", className: "id-row" },
			{ data: "trainer_name", className: "name-row" },
			{ data: "coaching_license", className: "license-row" },
			{ data: "team_name", className: "team-row" },
			{
				data: {
					trainer_id: "trainer_id",
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
	return `<button id="row-${data.trainer_id}" class="btn btn-primary btn-sm edit-button" onclick='showEditTrainerModal(event)'><i class='fa-solid fa-pencil'></i>Edit</button>
		<button id="row-${data.trainer_id}" class="btn btn-danger btn-sm delete-button" onclick='deleteTrainer(event);'><i class='fa-solid fa-trash-can'></i>Delete</button>`;
}

function deleteTrainer(event) {
	if (!confirm("Do you want to delete this trainer?")) return false;

	const id = $(event.target).attr("id").split("-")[1];

	$.ajax({
		url: "./includes/trainers/trainer_delete.inc.php",
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

function clearModalData() {
	$("#name").val("");
	$("#license").val("");
	$("#team").val("");
	document.getElementById("modal").removeAttribute("trainer-id");
}

function showInserTrainerModal() {
	clearModalData();
	document.querySelector(".modal-title").innerHTML = "Insert Team";
	document
		.getElementById("edit-button")
		.addEventListener("click", insertTrainer);
	showModal();
}

function insertTrainer() {
	const name = $("#name").val();
	const license = $("#license").val();
	const team = $("#team").val();

	$.ajax({
		url: "./includes/trainers/trainer_insert.inc.php",
		method: "POST",
		dataType: "json",
		data: {
			name: name,
			license: license,
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
					.removeEventListener("click", insertTrainer);
				clearModalData();
			}
		},
		error: function (xhr, status, error) {
			console.error("Error: " + status);
		},
	});
}

function insertNewRow(data) {
	const table = $("#trainer-table").DataTable();

	// Add a new row to the DataTable
	const newRowData = {
		trainer_id: data.trainer_id,
		trainer_name: data.trainer_name,
		coaching_license: data.coaching_license,
		team_name: data.team_name,
	};

	table.row.add(newRowData).draw().node();
}
